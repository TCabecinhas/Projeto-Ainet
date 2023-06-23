<?php

namespace App\Http\Controllers;

use App\Http\Requests\Tshirts\TshirtCatalogoSave;
use App\Http\Requests\Tshirts\TshirtSave ;
use App\Http\Requests\Tshirts\TshirtUpdate;
use App\Models\Cor;
use App\Models\TshirtImage;
use App\Models\Preco;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TshirtController extends Controller
{
    public function criarPersonalizada()
    {
        $cores = Cor::all();
        $precos = Preco::take(1)->first();

        return view('tshirts.criar-personalizada', ['cores' => $cores, 'precos' => $precos]);
    }

    public function adicionarPersonalizadaAoCarrinho(TshirtSave $request)
    {
        // Valida se os campos estão preenchidos
        $data = $request->validated();

        // dd($data);

        // Formato do nome do ficheiro
        $extension = $request->file('file')->extension();
        $filename = date("Ymd_His") . "." . $extension;

        // Upload da imagem
        Storage::putFileAs('tshirt_images_private', $request->file('file'), $filename);

        $data['imagem_url'] = $filename;
        unset($data['file']);


        // Criar imagem
        $tshirtImage = new TshirtImage();
        $tshirtImage->customer_id = Auth::user()->id;
        $tshirtImage->name = $data['nome'];
        $tshirtImage->description = $data['descricao'];
        $tshirtImage->image_url = $filename;
        $tshirtImage->save();



        $info_carrinho = [
            'imagem' => $tshirtImage->id,
            'personalizada' => true,
            'cor_codigo' => $data['cor_codigo'],
            'tamanho' => $data['tamanho'],
            'quantidade' => $data['quantidade'],
            'preco' => $data['preco']
        ];

        // Adiciona tshirt personalizada ao array do carrinho (presente na sessão do browser)
        if (session('carrinho')) {
            $carrinho =  json_decode(session('carrinho'), true);
        }


        $carrinho[] = $info_carrinho;

        session()->put('carrinho', json_encode($carrinho));

        return redirect()->route('index')->with('success', 'A t-shirt personalizada foi adicionada ao carrinho.');
    }

    public function editarPersonalizada($index)
    {
        $cores = Cor::all();

        if (session('carrinho')) {
            $tshirt = json_decode(session('carrinho'))[$index];
            // dd($tshirt);
            $tshirt->tshirtImage = TshirtImage::find($tshirt->imagem);

            return view('tshirts.editar-personalizada', ['cores' => $cores, 'tshirt' => $tshirt, 'index' => $index]);
        } else {
            return redirect()->route('carrinho')->with('erro', 'Tshirt não válida');
        }
    }

    public function atualizarPersonalizada(TshirtUpdate $request, $index)
    {
        // TODO: Só permitir a edição da imagem caso o auth == cliente_id da imagem
        $data = $request->validated();

        // Buscar imagem associada
        $tshirtImage = TshirtImage::findOrFail($request->tshirtImage_id);

        // Fazer upload da nova foto
        if ($request->hasFile('file')) {
            if ($request->file('file')->isValid()) {


                // Formato do nome do ficheiro
                $extension = $request->file('file')->extension();
                $filename = date("Ymd_His") . "." . $extension;

                // Upload da imagem
                Storage::putFileAs('tshirt_images_private', $request->file('file'), $filename);

                // Eliminar foto antiga
                Storage::delete('tshirt_images_private/' . $tshirtImage->imagem_url);

                $tshirtImage->image_url = $filename;
                $tshirtImage->save();
            }
        }

        // Adiciona tshirt personalizada ao array do carrinho (presente na sessão do browser)
        if (session('carrinho')) {
            $carrinho =  json_decode(session('carrinho'));
        }

        $info_carrinho = [
            'imagem' => $tshirtImage->id,
            'personalizada' => true,
            'cor_codigo' => $data['cor_codigo'],
            'tamanho' => $data['tamanho'],
            'quantidade' => $data['quantidade']
        ];

        $carrinho[$index] = $info_carrinho;

        session()->put('carrinho', json_encode($carrinho));

        return redirect()->route('carrinho')->with('success', 'A t-shirt personalizada foi atualizada ao carrinho.');
    }

    public function eliminarTshirt($index){
        $carrinho = json_decode(session('carrinho'), "[]");

        if($carrinho && sizeof($carrinho) > $index){
            unset($carrinho[$index]);
        }
        session()->put('carrinho', json_encode($carrinho));

        return redirect()->route('carrinho')->with('sucesso', 'Tshirt removida do carrinho.');
    }

    public function adicionarCatalogoCarrinho(TshirtImage $tshirtImage, TshirtCatalogoSave $request)
    {
        $data = $request->validated();
        // dd($data);

        $data['imagem'] = $tshirtImage->id;
        $data['personalizada'] = false;

        // Adiciona tshirt personalizada ao array do carrinho (presente na sessão do browser)
        if (session('carrinho')) {
            $carrinho =  json_decode(session('carrinho'), true);
        }

        $carrinho[] = $data;

        session()->put('carrinho', json_encode($carrinho));

        return redirect()->route('index')->with('success', 'A t-shirt foi adicionada ao carrinho.');
    }

    public function editarTshirtCatalogo($index){
        $cores = Cor::all();

        if (session('carrinho')) {
            $tshirt = json_decode(session('carrinho'))[$index];

            $tshirt->imagem= TshirtImage::find($tshirt->imagem);

            return view('tshirts.editar-catalogo', ['cores' => $cores, 'tshirt' => $tshirt, 'index' => $index]);
        } else {
            return redirect()->route('carrinho')->with('erro', 'Tshirt não válida');
        }
    }

    public function atualizarTshirtCatalogo($index, TshirtCatalogoSave $request){
        $data = $request->validated();

        $carrinho = json_decode(session('carrinho'), "[]");

        if(sizeof($carrinho) <= $index){
            session()->forget('carrinho');
            return redirect()->route('carrinho')->with('erro', 'Erro: tente de novo');
        }

        $carrinho[$index]['cor_codigo'] = $data['cor_codigo'];
        $carrinho[$index]['tamanho'] = $data['tamanho'];
        $carrinho[$index]['quantidade'] = $data['quantidade'];

        session()->put('carrinho', json_encode($carrinho));

        return redirect()->route('carrinho')->with('success', 'A t-shirt foi alterada ao carrinho.');
    }
}
