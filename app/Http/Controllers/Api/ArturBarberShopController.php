<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ArturBarberShop;
use App\Models\ArturProduct;
use Illuminate\Http\Request;

class ArturBarberShopController extends Controller
{

    /**
 * @OA\Post(
 *     path="api/artur/barberShop",
 *     operationId="createBarberShop",
 *     tags={"Artur"},
 *     summary="Cria um novo Barber Shop",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name","descripition","advantages","contact"},
 *             @OA\Property(property="name", type="string", example="Barber Shop A"),
 *             @OA\Property(property="descripition", type="string", example="Melhor Barber Shop da cidade"),
 *             @OA\Property(property="advantages", type="string", example="Preços acessíveis, ambiente agradável"),
 *             @OA\Property(property="contact", type="string", example="1234-5678"),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Barber Shop criado com sucesso",
 *         @OA\JsonContent(
 *             @OA\Property(property="barberShop", type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="Barber Shop A"),
 *                 @OA\Property(property="descripition", type="string", example="Melhor Barber Shop da cidade"),
 *                 @OA\Property(property="advantages", type="string", example="Preços acessíveis, ambiente agradável"),
 *                 @OA\Property(property="contact", type="string", example="1234-5678"),
 *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-08-21T00:00:00.000000Z"),
 *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-08-21T00:00:00.000000Z"),
 *             ),
 *             @OA\Property(property="message", type="string", example="Barber Shop criado com sucesso"),
 *             @OA\Property(property="status", type="integer", example=200)
 *         )
 *     )
 * )
 */

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'descripition' => 'required|string',
            'advantages' => 'required|string',
            'contact' => 'required|string',
        ]);

        $barberShop = new ArturBarberShop();
        $barberShop->name = $request->name;
        $barberShop->descripition = $request->descripition;
        $barberShop->advantages = $request->advantages;
        $barberShop->contact = $request->contact;
        $barberShop->save();

        return response()->json([
            'barberShop' => $barberShop,
            'message' => 'Barber Shop criado com sucesso',
            'status' => 200,
        ]);
    }

/**
 * @OA\Put(
 *     path="api/artur/barberShop/{id}",
 *     operationId="updateBarberShop",
 *     tags={"Artur"},
 *     summary="Atualiza as informações de um Barber Shop existente",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID do Barber Shop",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name","descripition","advantages","contact"},
 *             @OA\Property(property="name", type="string", example="Barber Shop Atualizado"),
 *             @OA\Property(property="descripition", type="string", example="Descrição atualizada"),
 *             @OA\Property(property="advantages", type="string", example="Novas vantagens"),
 *             @OA\Property(property="contact", type="string", example="9876-5432"),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Barber Shop atualizado com sucesso",
 *         @OA\JsonContent(
 *             @OA\Property(property="barberShop", type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="Barber Shop Atualizado"),
 *                 @OA\Property(property="descripition", type="string", example="Descrição atualizada"),
 *                 @OA\Property(property="advantages", type="string", example="Novas vantagens"),
 *                 @OA\Property(property="contact", type="string", example="9876-5432"),
 *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-08-21T00:00:00.000000Z"),
 *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-08-21T00:00:00.000000Z"),
 *             ),
 *             @OA\Property(property="message", type="string", example="Barber Shop atualizado com sucesso"),
 *             @OA\Property(property="status", type="integer", example=200)
 *         )
 *     )
 * )
 */

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'descripition' => 'required|string',
            'advantages' => 'required|string',
            'contact' => 'required|string',
        ]);

        $barberShop = ArturBarberShop::find($id);

        if (!$barberShop) {
            return response()->json([
                'message' => 'Barber Shop não encontrado',
                'status' => 404,
            ]);
        }

        $barberShop->name = $request->name;
        $barberShop->descripition = $request->descripition;
        $barberShop->advantages = $request->advantages;
        $barberShop->contact = $request->contact;
        $barberShop->save();

        return response()->json([
            'barberShop' => $barberShop,
            'message' => 'Barber Shop atualizado com sucesso',
            'status' => 200,
        ]);
    }

/**
 * @OA\Delete(
 *     path="api/artur/barberShop/{id}",
 *     operationId="deleteBarberShop",
 *     tags={"Artur"},
 *     summary="Remove um Barber Shop existente",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID do Barber Shop",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Barber Shop deletado com sucesso",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Barber Shop deletado com sucesso"),
 *             @OA\Property(property="status", type="integer", example=200)
 *         )
 *     )
 * )
 */

    public function destroy($id)
    {
        $barberShop = ArturBarberShop::find($id);

        if (!$barberShop) {
            return response()->json([
                'message' => 'Barber Shop não encontrado',
                'status' => 404,
            ]);
        }

        $barberShop->delete();

        return response()->json([
            'message' => 'Barber Shop deletado com sucesso',
            'status' => 200,
        ]);
    }

/**
 * @OA\Get(
 *     path="api/artur/barberShop/{id}",
 *     operationId="getBarberShop",
 *     tags={"Artur"},
 *     summary="Exibe as informações de um Barber Shop específico",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID do Barber Shop",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Detalhes do Barber Shop",
 *         @OA\JsonContent(
 *             @OA\Property(property="barberShop", type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="Barber Shop A"),
 *                 @OA\Property(property="descripition", type="string", example="Melhor Barber Shop da cidade"),
 *                 @OA\Property(property="advantages", type="string", example="Preços acessíveis, ambiente agradável"),
 *                 @OA\Property(property="contact", type="string", example="1234-5678"),
 *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-08-21T00:00:00.000000Z"),
 *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-08-21T00:00:00.000000Z"),
 *             ),
 *             @OA\Property(property="products", type="array",
 *                 @OA\Items(
 *                     @OA\Property(property="id", type="integer", example=1),
 *                     @OA\Property(property="name", type="string", example="Produto A"),
 *                     @OA\Property(property="price", type="number", format="float", example=29.99),
 *                     @OA\Property(property="barber_shop_id", type="integer", example=1),
 *                     @OA\Property(property="created_at", type="string", format="date-time", example="2024-08-21T00:00:00.000000Z"),
 *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-08-21T00:00:00.000000Z"),
 *                 )
 *             ),
 *             @OA\Property(property="status", type="integer", example=200)
 *         )
 *     )
 * )
 */

    public function show($id)
    {
        $barberShop = ArturBarberShop::find($id);

        if (!$barberShop) {
            return response()->json([
                'message' => 'Barber Shop não encontrado',
                'status' => 404,
            ]);
        }

        $products = ArturProduct::where('barber_shop_id', $id)->get();

        return response()->json([
            'barberShop' => $barberShop,
            'products' => $products,
            'status' => 200,
        ]);
    }
}
