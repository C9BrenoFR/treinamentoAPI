<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DuTraining;
use App\Models\DuUser;
use Hash;
use Illuminate\Http\Request;

class DuUserController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $duUser = new DuUser();
        $duUser->name = $request->name;
        $duUser->email = $request->email;
        $duUser->password = Hash::make($request->password);
        $duUser->save();

        return response()->json([
            'user' => $duUser,
            'message' => 'Usuário criado com sucesso',
            'status' => 200,
        ]);
    }

    public function update(Request $request, $id){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
        ]);

        $duUser = DuUser::find($id);

        if(!$duUser){
            return response()->json([
                'message' => 'Usuário não encontrado',
                'status' => 404,
            ]);
        }

        $duUser->name = $request->name;
        $duUser->email = $request->email;
        if($request->password)
            $duUser->password = Hash::make($request->password);
        $duUser->save();

        return response()->json([
            'data' => $duUser,
            'message' => 'Usuário atualizado com sucesso',
            'status' => 200,
        ]);
    }

    public function destroy($id){
        $duUser = DuUser::find($id);

        if(!$duUser){
            return response()->json([
                'message' => 'Usuário não encontrado',
                'status' => 404,
            ]);
        }

        $duUser->delete();

        return response()->json([
            'message' => 'Usuário deletado com sucesso',
            'status' => 200,
        ]);
    }

    public function show($id){
        $duUser = DuUser::find($id);

        if(!$duUser){
            return response()->json([
                'message' => 'Usuário não encontrado',
                'status' => 404,
            ]);
        }

        $training = DuTraining::where('du_user_id', $id)->get();

        return response()->json([
            'user' => $duUser,
            'trainings' => $training,
            'status' => 200,
        ]);
    }
}
