<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {//GET - READ
        try {
            $currentPage = $request->get('current_page') ?? 1;
            $regsPerPage = 3;

            $skip = ($currentPage - 1) * $regsPerPage;

            $users = User::skip($skip)->take($regsPerPage)->orderByDesc('id')->get(); //User::all();

            return response()->json($users->toResourceCollection(),200);
        } catch (\Exception $ex) {
            return response()->json(['message'=>'Erro ao buscar todos os usuários!','error'=>$ex->getMessage()],500);
        }
    }

   
    public function store(StoreUserRequest $request)
    {//POST - CREATE
        try {
            $data = $request->validated();
            $user = new User();
            $user->fill($data);
            $user->password = Hash::make('12345678'); 
            $user->save();
            return response()->json(["message"=>"Usuário criado com sucesso!","user"=>$user->toResource()],201);
        } catch (\Exception $ex) {
            return response()->json(['message'=>'Erro ao criar usuário!','error'=>$ex->getMessage()],500);
        }
        
        
    }

    
    public function show(string $id)
    {//GET(id) - READ
        try {
            $user = User::findOrFail($id);
            return response()->json($user->toResource(),200);
        } catch (\Exception $ex) {
            return response()->json(['message'=>'Usuário não encontrado!'],404);
        }
    }


    public function update(UpdateUserRequest $request, string $id)
    {
        //PUT/PATCH - UPDATE
        // verificar se o usuário existe, se não existir retornar 404
        //tratar a mensagem de erro correta email já existe, retornar 400
        try {
            $data = $request->validated();
            $user = User::findOrFail($id);
            $user->update($data);
            return response()->json(["message"=>"Usuário atualizado com sucesso!","user"=>$user->toResource()],201);
        } catch (\Exception $ex) {
            return response()->json(['message'=>'Erro ao atualizar usuário!','error'=>$ex->getMessage()],400);
        }
    }


    public function destroy(string $id)
    {
        //DELETE - DELETE
        try {
            //$user = User::findOrFail($id);
            $removed = User::destroy($id);
            //$user->delete($user);
            if(!$removed) {
                throw new \Exception();
            }
            // return response()->json(["message"=>"Usuário deletado com sucesso!","user"=>$user],200);
            return response()->json(["message"=>"Usuário deletado com sucesso!"],200);
            
        } catch (\Exception $ex) {
            return response()->json(['message'=>'Erro ao deletar usuário!','error'=>$ex->getMessage()],500);
        }
    }
}
