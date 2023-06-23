<?php

namespace App\Http\Controllers;

use App\Http\Requests\Users\ProfileUpdateRequest;
use App\Http\Requests\users\UserCreateRequest;
use App\Http\Requests\Users\UserUpdateRequest;
use App\Models\Cliente;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }

    public function index(Request $request){

        $tipo = $request->query('user_type') == '*' ? null :$request->query('user_type') ;
        $conditions = $tipo ? ["user_type" => $tipo] : [];

        $users = User::where($conditions)->paginate(20);

        return view('dashboard.users.index', ['users' => $users, 'user_type' => $tipo]);
    }

    public function view(User $user){
        return view('dashboard.users.view', ['user' => $user]);
    }

    public function edit(User $user){
        return view('dashboard.users.edit', ['user' => $user]);
    }

    public function create(){
        return view('dashboard.users.create');
    }

    public function apagados(){
        $users = User::onlyTrashed()->orderBy('deleted_at', 'DESC')->paginate(20);

        return view('dashboard.users.apagados', ['users' => $users]);
    }

    public function restore($id){

        User::onlyTrashed()->where('id', $id)->restore();

        // Caso o utilizador seja cliente, restaurar o registo do cliente
        $user = User::find($id);
        if($user->user_type == 'C'){
            Cliente::onlyTrashed()->where('id', $id)->first()->restore();
        }

        return redirect()->route('dashboard.users.index')->with('success', 'O utilizador foi restaurado com sucesso!');
    }

    public function store(UserCreateRequest $request){
        $data = $request->validated();

        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->user_type = $data['tipo'];
        $user->save();

        if($data['tipo'] == 'C'){
            $cliente = new Cliente();
            $cliente->id = $user->id;
            $cliente->save();
        }

        return redirect()->route('dashboard.users.index')->with('success', 'Novo utilizador inserido com sucesso!');
    }

    public function update(User $user, UserUpdateRequest $request){

        $data = $request->validated();

        // Caso se altere o utilizador para 'cliente', criar o registo de cliente
        if($data['user_type'] == 'C' && $user->user_type != 'C' && !Cliente::where('id', $user->id)->exists()){
            $cliente = new Cliente();
            $cliente->id = $user->id;
            $cliente->save();
        }

        // Guardar utilizador
        $user->fill($data);
        $user->save();

        return redirect()->route('dashboard.users.index')->with('success', 'A informação do utilizador foi alterada com sucesso!');
    }

    public function profile(){
        return view('dashboard.users.profile');
    }

    public function apagarFoto(User $user)
    {
        Storage::delete('public/photos/' . $user->photo_url);
        $user->photo_url = null;
        $user->save();
        return redirect()->route('dashboard.profile')->with('success', 'A foto foi removida com sucesso!');
    }

    public function atualizarPerfil(User $user, ProfileUpdateRequest $request){

        $data = $request->validated();

        if($data['password']){
            $user->password = Hash::make($data['password']);
        }

        if(isset($data['avatar'])){
            if($user->photo_url){
                // Eliminar foto antiga
                Storage::delete('public/photos/' . $user->photo_url);
                $user->photo_url = null;
            }

            $filename = $user->id . "_" . date("Ymd_His") . "."  . $data['avatar']->extension();

            // Upload da nova foto
            Storage::putFileAs('public/photos', $data['avatar'], $filename);

            $user->photo_url = $filename;
        }

        $user->name = $data['name'];
        $user->email = $data['email'];
        if($user->user_type == 'C'){

            $user->cliente->nif = $data['nif'];
            $user->cliente->address = $data['endereco'];

            // Alterar tipo_pagamento e ref_pagamento
            if($data['tipo_pagamento'] == 'PAYPAL'){
                $user->cliente->default_payment_type = 'PAYPAL';
                $user->cliente->default_payment_ref = $user->email;
            } else if($data['tipo_pagamento'] == 'MC' || $data['tipo_pagamento'] == 'VISA'){
                $user->cliente->default_payment_type = $data['tipo_pagamento'];
                $user->cliente->default_payment_ref = $user->cliente->nif;
            }
            $user->cliente->save();
        }

        $user->save();

        return redirect()->route('dashboard.profile')->with('success', 'O perfil foi atualizado');
    }

    public function block(User $user){
        $this->authorize('block', $user);

        $user->blocked = 1;
        $user->save();

        return redirect()->route('dashboard.users.index')->with('success', 'O utilizador foi bloqueado!');
    }

    public function unblock(User $user){
        $this->authorize('unblock', $user);

        $user->blocked = 0;
        $user->save();

        return redirect()->route('dashboard.users.index')->with('success', 'O utilizador foi desbloqueado!');
    }

    public function destroy(User $user){
        $user->delete();

        return redirect()->route('dashboard.users.index')->with('success', 'O utilizador foi removido com sucesso!');
    }
}
