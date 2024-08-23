<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PauloCreditCard;
use App\Models\PauloUser;
use Hash;
use Illuminate\Http\Request;

class PauloUserController extends Controller
{
/**
 * @OA\Post(
 *     path="/paulo/user",
 *     summary="Criar um novo usuário",
 *     description="Cria um novo usuário com as informações fornecidas",
 *     tags={"Paulo"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name", "email", "phone_number", "birth_date", "password"},
 *             @OA\Property(property="name", type="string", example="Paulo Silva"),
 *             @OA\Property(property="email", type="string", format="email", example="paulo@exemplo.com"),
 *             @OA\Property(property="phone_number", type="string", example="(11) 98765-4321"),
 *             @OA\Property(property="birth_date", type="string", format="date", example="1980-05-23"),
 *             @OA\Property(property="password", type="string", example="password123")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Usuário criado com sucesso",
 *         @OA\JsonContent(ref="schemas/PauloUser")
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Dados inválidos"
 *     )
 * )
 */
    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone_number' => 'required',
            'birth_date' => 'required',
            'password' => 'required',
        ]);

        $pauloUser = new PauloUser();
        $pauloUser->name = $request->name;
        $pauloUser->email = $request->email;
        $pauloUser->phone_number = $request->phone_number;
        $pauloUser->birth_date = $request->birth_date;
        $pauloUser->password = Hash::make($request->password);
        $pauloUser->save();

        return response()->json([
            'data' => $pauloUser,
            'message' => 'Usuário criado com sucesso',
            'status' => 201
        ]);
    }

/**
 * @OA\Get(
 *     path="/paulo/user/{id}",
 *     summary="Buscar usuário por ID",
 *     description="Retorna os detalhes de um usuário e seus cartões de crédito",
 *     tags={"Paulo"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID do usuário",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Usuário encontrado com sucesso",
 *         @OA\JsonContent(ref="schemas/PauloUserWithCards")
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Usuário não encontrado"
 *     )
 * )
 */
    public function show($id){
        $pauloUser = PauloUser::find($id);
        $creditCards = PauloCreditCard::where('user_id', $id)->get();


        if(!$pauloUser){
            return response()->json([
                'message' => 'Usuário não encontrado',
                'status' => 404
            ]);
        }

        return response()->json([
            'user' => $pauloUser,
            'credit_cards' => $creditCards,
            'message' => 'Usuário encontrado com sucesso',
            'status' => 200
        ]);
    }

/**
 * @OA\Put(
 *     path="/paulo/user/{id}",
 *     summary="Atualizar usuário",
 *     description="Atualiza as informações de um usuário existente",
 *     tags={"Paulo"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID do usuário",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name", "email", "phone_number", "birth_date"},
 *             @OA\Property(property="name", type="string", example="Paulo Silva"),
 *             @OA\Property(property="email", type="string", format="email", example="paulo@exemplo.com"),
 *             @OA\Property(property="phone_number", type="string", example="(11) 98765-4321"),
 *             @OA\Property(property="birth_date", type="string", format="date", example="1980-05-23"),
 *             @OA\Property(property="password", type="string", example="password123", description="Opcional, só enviar se for atualizar")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Usuário atualizado com sucesso",
 *         @OA\JsonContent(ref="schemas/PauloUser")
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Dados inválidos"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Usuário não encontrado"
 *     )
 * )
 */
    public function update(Request $request, $id){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone_number' => 'required',
            'birth_date' => 'required',
        ]);

        $pauloUser = PauloUser::find($id);
        $pauloUser->name = $request->name;
        $pauloUser->email = $request->email;
        $pauloUser->phone_number = $request->phone_number;
        $pauloUser->birth_date = $request->birth_date;
        if($request->password)
            $pauloUser->password = Hash::make($request->password);
        $pauloUser->save();

        return response()->json([
            'data' => $pauloUser,
            'message' => 'Usuário atualizado com sucesso',
            'status' => 200
        ]);
    }

/**
 * @OA\Delete(
 *     path="/paulo/user/{id}",
 *     summary="Deletar usuário",
 *     description="Deleta um usuário existente e seus cartões de crédito",
 *     tags={"Paulo"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID do usuário",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Usuário deletado com sucesso"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Usuário não encontrado"
 *     )
 * )
 */
    public function destroy($id){
        $pauloUser = PauloUser::find($id);

        if(!$pauloUser){
            return response()->json([
                'message' => 'Usuário não encontrado',
                'status' => 404
            ]);
        }
        $creditCards = PauloCreditCard::where('user_id', $id)->get();
        foreach($creditCards as $creditCard){
            $creditCard->delete();
        }
        $pauloUser->delete();

        return response()->json([
            'message' => 'Usuário deletado com sucesso',
            'status' => 200
        ]);
    }
}
