<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ArturUser;
use Hash;
use Illuminate\Http\Request;

class ArturUserController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = new ArturUser();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
        ]);

        $user = ArturUser::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'Usuário não encontrado',
                'status' => 404,
            ]);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return response()->json([
            'user' => $user,
            'message' => 'Usuário atualizado com sucesso',
            'status' => 200,
        ]);
    }

    public function destroy($id)
    {
        $user = ArturUser::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'Usuário não encontrado',
                'status' => 404,
            ]);
        }

        $user->delete();

        return response()->json([
            'message' => 'Usuário deletado com sucesso',
            'status' => 200,
        ]);
    }

    public function show($id)
    {
        $user = ArturUser::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'Usuário não encontrado',
                'status' => 404,
            ]);
        }

        return response()->json([
            'user' => $user,
            'status' => 200,
        ]);
    }
}
