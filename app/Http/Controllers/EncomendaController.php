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


        // Admin -> Mostra todas as encomendas
        // Employee -> Mostra encomendas pendentes e pagas
        // Client -> Mostra apenas as suas encomendas
        if(Auth::user()->tipo == 'C'){
            $encomendas = Encomenda::where('customer_id', Auth::user()->id)->orderBy('date', 'DESC')->paginate(20);
        } else if(Auth::user()->tipo == 'E'){
            $encomendas = Encomenda::where('status', 'pending')->orWhere('status', 'paid')->orderBy('date', 'DESC')->paginate(20);
        } else {
            $encomendas = Encomenda::orderBy('date', 'DESC')->paginate(20);
        }
        return view('dashboard.encomendas.index', ['encomendas' => $encomendas, 'status' => $request->status ?? '']);
    }

    public function view(Encomenda $encomendas){
        return view('dashboard.encomendas.view', ['order' => $encomendas]);
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
        $encomenda->status = 'pending';
        $encomenda->customer_id = Auth::user()->id;
        $encomenda->date = date('Y-m-d');
        $encomenda->total_price = $aux['total'];
        $encomenda->notes = $data['notes'];
        $encomenda->nif = $data['nif'];
        $encomenda->address = $data['address'];
        $encomenda->payment_type = $data['payment_type'];
        $encomenda->payment_ref = $data['payment_type'] == 'PAYPAL' ? Auth::user()->email : $data['nif'];
        $encomenda->save();

        // Criar tshirts
        foreach($carrinho as $t){
            $tshirt = new Tshirt();
            $tshirt->encomenda_id = $encomenda->id;
            $tshirt->tshirtImage_id = $t->image->id;
            $tshirt->cor_codigo = $t->color_code;
            $tshirt->tamanho = $t->size;
            $tshirt->quantidade = $t->qty;
            $tshirt->preco_un = $t->unit_price;
            $tshirt->subtotal = $t->sub_total;
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
            $carrinho[$i]->imagem = TshirtImage::find($t->imagem);
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
        $encomenda->estado = 'paid';
        $encomenda->save();

        return redirect()->route('dashboard.encomendas.index')->with('success', 'A encomenda foi alterada para o estado "PAGA"');
    }

    public function close(Encomenda $encomenda){
        $encomenda->estado = 'closed';

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
        $encomenda->estado = 'canceled';
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
