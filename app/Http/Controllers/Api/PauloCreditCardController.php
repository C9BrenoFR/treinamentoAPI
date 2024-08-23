<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PauloCreditCard;
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

class PauloCreditCardController extends Controller
{

/**
 * @OA\Post(
 *     path="/paulo/creditCard",
 *     summary="Criar um novo cartão de crédito",
 *     description="Cria um novo cartão de crédito para um usuário",
 *     tags={"Paulo"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name", "number", "brand", "is_credit", "user_id"},
 *             @OA\Property(property="name", type="string", example="Cartão Principal"),
 *             @OA\Property(property="number", type="string", example="1234-5678-9012-3456"),
 *             @OA\Property(property="brand", type="string", example="Visa"),
 *             @OA\Property(property="is_credit", type="boolean", example=true),
 *             @OA\Property(property="user_id", type="integer", example=1)
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Cartão de crédito criado com sucesso",
 *         @OA\JsonContent(ref="schemas/PauloCreditCard")
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
            'number' => 'required',
            'brand' => 'required',
            'is_credit' => 'required',
            'user_id' => 'required',
        ]);

        $pauloCreditCard = new PauloCreditCard();
        $pauloCreditCard->name = $request->name;
        $pauloCreditCard->number = $request->number;
        $pauloCreditCard->brand = $request->brand;
        $pauloCreditCard->is_credit = $request->is_credit;
        $pauloCreditCard->user_id = $request->user_id;
        $pauloCreditCard->save();

        return response()->json([
            'data' => $pauloCreditCard,
            'message' => 'Cartão de crédito criado com sucesso',
            'status' => 201
        ]);
    }

/**
 * @OA\Put(
 *     path="/paulo/creditCard/{id}",
 *     summary="Atualizar cartão de crédito",
 *     description="Atualiza as informações de um cartão de crédito existente",
 *     tags={"Paulo"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID do cartão de crédito",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name", "number", "brand", "is_credit", "user_id"},
 *             @OA\Property(property="name", type="string", example="Cartão Principal"),
 *             @OA\Property(property="number", type="string", example="1234-5678-9012-3456"),
 *             @OA\Property(property="brand", type="string", example="Visa"),
 *             @OA\Property(property="is_credit", type="boolean", example=true),
 *             @OA\Property(property="user_id", type="integer", example=1)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Cartão de crédito atualizado com sucesso",
 *         @OA\JsonContent(ref="schemas/PauloCreditCard")
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Dados inválidos"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Cartão de crédito não encontrado"
 *     )
 * )
 */
    public function update(Request $request, $id){
        $request->validate([
            'name' => 'required',
            'number' => 'required',
            'brand' => 'required',
            'is_credit' => 'required',
            'user_id' => 'required',
        ]);

        $pauloCreditCard = PauloCreditCard::find($id);
        $pauloCreditCard->name = $request->name;
        $pauloCreditCard->number = $request->number;
        $pauloCreditCard->brand = $request->brand;
        $pauloCreditCard->is_credit = $request->is_credit;
        $pauloCreditCard->user_id = $request->user_id;
        $pauloCreditCard->save();

        return response()->json([
            'data' => $pauloCreditCard,
            'message' => 'Cartão de crédito atualizado com sucesso',
            'status' => 200
        ]);
    }

/**
 * @OA\Delete(
 *     path="/paulo/creditCard/{id}",
 *     summary="Deletar cartão de crédito",
 *     description="Deleta um cartão de crédito existente",
 *     tags={"Paulo"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID do cartão de crédito",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Cartão de crédito deletado com sucesso"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Cartão de crédito não encontrado"
 *     )
 * )
 */
    public function destroy($id){
        $pauloCreditCard = PauloCreditCard::find($id);

        if(!$pauloCreditCard){
            return response()->json([
                'message' => 'Cartão de crédito não encontrado',
                'status' => 404
            ]);
        }

        $pauloCreditCard->delete();

        return response()->json([
            'message' => 'Cartão de crédito deletado com sucesso',
            'status' => 200
        ]);
    }
}
