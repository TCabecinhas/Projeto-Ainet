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

        if(Auth::user()->user_type == 'C'){
            $encomendas = Encomenda::where('customer_id', Auth::user()->id)->orderBy('date', 'DESC')->paginate(20);
        } else if(Auth::user()->user_type == 'E'){
            $encomendas = Encomenda::where('status', 'pending')->orWhere('status', 'paid')->orderBy('date', 'DESC')->paginate(20);
        } else {
            $encomendas = Encomenda::orderBy('date', 'DESC')->paginate(20);
        }
        return view('dashboard.encomendas.index', ['encomendas' => $encomendas, 'status' => $request->status ?? '']);
    }

    public function view(Encomenda $encomenda){
        return view('dashboard.encomendas.view', ['order' => $encomenda]);
    }

    public function carrinho(){

        $carrinho = json_decode(session('carrinho', "[]"));
        $precos = Preco::first();

        
        $aux = $this->calcularPrecos($carrinho, $precos);
        // dd($aux['carrinho']);
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
        $encomenda->notes = $data['notas'];
        $encomenda->nif = $data['nif'];
        $encomenda->address = $data['endereco'];
        $encomenda->payment_type = $data['tipo_pagamento'];
        $encomenda->payment_ref = $data['tipo_pagamento'] == 'PAYPAL' ? Auth::user()->email : $data['nif'];
        $encomenda->save();
        
        // Criar tshirts
        foreach($carrinho as $t){
            $tshirt = new Tshirt();
            $tshirt->order_id = $encomenda->id;
            $tshirt->tshirt_image_id = $t->imagem->id;
            $tshirt->color_code = $t->cor_codigo;
            $tshirt->size = $t->tamanho;
            $tshirt->qty = $t->quantidade;
            $tshirt->unit_price = $t->unit_price;
            $tshirt->sub_total = $t->sub_total;
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

        // dd($precos);
        
        foreach($carrinho as $i => $t){
            $carrinho[$i]->imagem = TshirtImage::find($t->imagem);
            // Atribuir preços unitarios e subtotais
            if($carrinho[$i]->quantidade >= $precos->qty_discount){
                $carrinho[$i]->imagem['unit_price'] = $t->personalizada ? $precos->unit_price_own_discount : $precos->unit_price_catalog_discount;
                $carrinho[$i]->sub_total = $carrinho[$i]->unit_price * $t->quantidade;
                $total += $carrinho[$i]->sub_total;
            } else {
                $carrinho[$i]->unit_price = $t->personalizada ? $precos->unit_price_own_discount : $precos->unit_price_catalog_discount;
                $carrinho[$i]->sub_total = $carrinho[$i]->unit_price * $t->quantidade;
                $total += $carrinho[$i]->sub_total;
                
            }
            // dd($carrinho[$i]);
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
