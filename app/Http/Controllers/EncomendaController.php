<?php

namespace App\Http\Controllers;

use App\Http\Requests\Encomendas\EncomendasStoreRequest;
use App\Mail\EncomendaCriada;
use App\Mail\EncomendaFechada;
use App\Models\Encomenda;
use App\Models\TshirtImage;
use App\Models\Preco;
use App\Models\Tshirt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use PDF;

class EncomendaController extends Controller
{
    public function index(Request $request){


        // Administrador -> Mostra todas as encomendas
        // Funcionário -> Mostra encomendas pendentes e pagas
        // Cliente -> Mostra apenas as suas encomendas
        if(Auth::user()->tipo == 'C'){
            $encomendas = Encomenda::where('cliente_id', Auth::user()->id)->orderBy('data', 'DESC')->paginate(20);
        } else if(Auth::user()->tipo == 'F'){
            $encomendas = Encomenda::where('estado', 'pendente')->orWhere('estado', 'paga')->orderBy('data', 'DESC')->paginate(20);
        } else {
            $encomendas = Encomenda::orderBy('data', 'DESC')->paginate(20);
        }

        return view('dashboard.encomendas.index', ['encomendas' => $encomendas, 'estado' => $request->estado ?? '']);
    }

    public function view(Encomenda $encomenda){
        return view('dashboard.encomendas.view', ['encomenda' => $encomenda]);
    }

    public function carrinho(){

        $carrinho = json_decode(session('carrinho', "[]"));
        $precos = Preco::first();

        $aux = $this->calcularPrecos($carrinho, $precos);


        return view('encomendas.carrinho', ['carrinho' => $aux['carrinho'], 'total' => $aux['total']]);
    }

    public function checkout(){

        $total = session('total');

        return view('encomendas.checkout', ['total' => $total]);
    }

    public function encomendar(EncomendasStoreRequest $request){

        $data = $request->validated();

        $carrinho = json_decode(session('carrinho', "[]"));
        $precos = Preco::first();


        if(!$carrinho){
            // Limpa toda a sessão para prevenir erros
            session()->forget('carrinho');

            // Retorna erro
            return redirect()->route('carrinho')->with('erro', 'ERRO: Não foi possível efetuar encomenda!');
        }

        $aux = $this->calcularPrecos($carrinho, $precos);

        // Criar encomenda
        $encomenda = new Encomenda();
        $encomenda->estado = 'pendente';
        $encomenda->cliente_id = Auth::user()->id;
        $encomenda->data = date('Y-m-d');
        $encomenda->preco_total = $aux['total'];
        $encomenda->notas = $data['notas'];
        $encomenda->nif = $data['nif'];
        $encomenda->endereco = $data['endereco'];
        $encomenda->tipo_pagamento = $data['tipo_pagamento'];
        $encomenda->ref_pagamento = $data['tipo_pagamento'] == 'PAYPAL' ? Auth::user()->email : $data['nif'];
        $encomenda->save();

        // Criar tshirts
        foreach($carrinho as $t){
            $tshirt = new Tshirt();
            $tshirt->encomenda_id = $encomenda->id;
            $tshirt->tshirtImage_id = $t->image->id;
            $tshirt->cor_codigo = $t->cor_codigo;
            $tshirt->tamanho = $t->tamanho;
            $tshirt->quantidade = $t->quantidade;
            $tshirt->preco_un = $t->preco_un;
            $tshirt->subtotal = $t->subtotal;
            $tshirt->save();
        }

        // Mandar e-mail
        Mail::to(Auth::user())->send(new EncomendaCriada($encomenda));

        // Limpa toda a sessão
        session()->forget('carrinho');

        return redirect()->route('index')->with('success', 'A compra foi feita com sucesso');
    }

    private function calcularPrecos($carrinho, $precos){
        $total = 0;

        foreach($carrinho as $i => $t){
            $carrinho[$i]->image = TshirtImage::find($t->image);
            // Atribuir preços unitarios e subtotais
            if($carrinho[$i]->quantidade >= $precos->quantidade_desconto){
                $carrinho[$i]->preco_un = $t->personalizada ? $precos->preco_un_proprio_desconto : $precos->preco_un_catalogo_desconto;
                $carrinho[$i]->subtotal = $carrinho[$i]->preco_un * $t->quantidade;
                $total += $carrinho[$i]->subtotal;
            } else {
                $carrinho[$i]->preco_un = $t->personalizada ? $precos->preco_un_proprio : $precos->preco_un_catalogo;
                $carrinho[$i]->subtotal = $carrinho[$i]->preco_un * $t->quantidade;
                $total += $carrinho[$i]->subtotal;
            }
        }

        return ['carrinho' => $carrinho, 'total' => $total];
    }

    public function pay(Encomenda $encomenda){
        $encomenda->estado = 'paga';
        $encomenda->save();

        return redirect()->route('dashboard.encomendas.index')->with('success', 'A encomenda foi alterada para o estado "PAGA"');
    }

    public function close(Encomenda $encomenda){
        $encomenda->estado = 'fechada';

        // Gerar PDF
        $recibo = $this->gerarRecibo($encomenda);
        $encomenda->recibo_url = $recibo;
        $encomenda->save();


        // Mandar e-mail
        if(isset($encomenda->cliente->user)){
            Mail::to($encomenda->cliente->user)->send(new EncomendaFechada($encomenda));
        }

        return redirect()->route('dashboard.encomendas.index')->with('success', 'A encomenda foi alterada para o estado "FECHADA"');
    }

    public function cancel(Encomenda $encomenda){
        $encomenda->estado = 'anulada';
        $encomenda->save();

        return redirect()->route('dashboard.encomendas.index')->with('success', 'A encomenda foi alterada para o estado "ANULADA"');
    }

    private function gerarRecibo(Encomenda $encomenda){

        view()->share('encomenda', $encomenda);

        $filename = "encomenda_" . $encomenda->id . "_" . date('Y_m_d') . '.pdf';
        $pdf = PDF::loadView('dashboard.encomendas.recibo');
        Storage::put('pdf_recibos/'.$filename, $pdf->output());

        return $filename;
    }

    public function recibo(Encomenda $encomenda){
        return Storage::download('pdf_recibos/'. $encomenda->recibo_url);
    }
}
