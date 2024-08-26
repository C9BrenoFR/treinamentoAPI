<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PauloCreditCard;
use App\Models\PauloUser;
use Hash;
use Illuminate\Http\Request;


/**
 * @OA\Schema(
 *     schema="PauloUser",
 *     type="object",
 *     title="Usuário Paulo",
 *     required={"name", "email", "phone_number", "birth_date", "password"},
 *     @OA\Property(property="id", type="integer", description="ID do usuário"),
 *     @OA\Property(property="name", type="string", description="Nome do usuário"),
 *     @OA\Property(property="email", type="string", format="email", description="Email do usuário"),
 *     @OA\Property(property="phone_number", type="string", description="Número de telefone do usuário"),
 *     @OA\Property(property="birth_date", type="string", format="date", description="Data de nascimento do usuário"),
 *     @OA\Property(property="balance", type="number", format="double", description="Saldo do usuário", example=0.00),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Data de criação"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Data de atualização")
 * )
 *
 * @OA\Schema(
 *     schema="PauloCreditCard",
 *     type="object",
 *     title="Cartão de Crédito Paulo",
 *     required={"name", "number", "brand", "is_credit", "user_id"},
 *     @OA\Property(property="id", type="integer", description="ID do cartão de crédito"),
 *     @OA\Property(property="name", type="string", description="Nome do cartão de crédito"),
 *     @OA\Property(property="number", type="string", description="Número do cartão de crédito"),
 *     @OA\Property(property="brand", type="string", description="Bandeira do cartão"),
 *     @OA\Property(property="is_credit", type="boolean", description="Indica se é um cartão de crédito"),
 *     @OA\Property(property="user_id", type="integer", description="ID do usuário associado"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Data de criação"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Data de atualização")
 * )
 *
 * @OA\Schema(
 *     schema="PauloUserWithCards",
 *     type="object",
 *     title="Usuário Paulo com Cartões",
 *     allOf={
 *         @OA\Schema(ref="schemas/PauloUser"),
 *         @OA\Schema(
 *             @OA\Property(
 *                 property="credit_cards",
 *                 type="array",
 *                 @OA\Items(ref="schemas/PauloCreditCard")
 *             )
 *         )
 *     }
 * )
 */
class PauloUserController extends Controller
{
/**
 * @OA\Post(
 *     path="api/paulo/user",
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
 *     path="api/paulo/user/{id}",
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
 *     path="api/paulo/user/{id}",
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
 *     path="api/paulo/user/{id}",
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
