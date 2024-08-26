<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ArturProduct;
use Illuminate\Http\Request;

class ArturProductController extends Controller
{

/**
 * @OA\Post(
 *     path="api/artur/product",
 *     operationId="createProduct",
 *     tags={"Artur"},
 *     summary="Cria um novo produto para um Barber Shop",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name","price","barber_shop_id"},
 *             @OA\Property(property="name", type="string", example="Produto A"),
 *             @OA\Property(property="price", type="number", format="float", example=29.99),
 *             @OA\Property(property="barber_shop_id", type="integer", example=1),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Produto criado com sucesso",
 *         @OA\JsonContent(
 *             @OA\Property(property="product", type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="Produto A"),
 *                 @OA\Property(property="price", type="number", format="float", example=29.99),
 *                 @OA\Property(property="barber_shop_id", type="integer", example=1),
 *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-08-21T00:00:00.000000Z"),
 *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-08-21T00:00:00.000000Z"),
 *             ),
 *             @OA\Property(property="message", type="string", example="Produto criado com sucesso"),
 *             @OA\Property(property="status", type="integer", example=200)
 *         )
 *     )
 * )
 */

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'barber_shop_id' => 'required|exists:artur_barber_shops,id',
        ]);

        $product = new ArturProduct();
        $product->name = $request->name;
        $product->price = $request->price;
        $product->barber_shop_id = $request->barber_shop_id;
        $product->save();

        return response()->json([
            'product' => $product,
            'message' => 'Produto criado com sucesso',
            'status' => 200,
        ]);
    }
/**
 * @OA\Put(
 *     path="api/artur/product/{id}",
 *     operationId="updateProduct",
 *     tags={"Artur"},
 *     summary="Atualiza as informações de um produto existente",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID do produto",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name","price","barber_shop_id"},
 *             @OA\Property(property="name", type="string", example="Produto Atualizado"),
 *             @OA\Property(property="price", type="number", format="float", example=39.99),
 *             @OA\Property(property="barber_shop_id", type="integer", example=1),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Produto atualizado com sucesso",
 *         @OA\JsonContent(
 *             @OA\Property(property="product", type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="Produto Atualizado"),
 *                 @OA\Property(property="price", type="number", format="float", example=39.99),
 *                 @OA\Property(property="barber_shop_id", type="integer", example=1),
 *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-08-21T00:00:00.000000Z"),
 *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-08-21T00:00:00.000000Z"),
 *             ),
 *             @OA\Property(property="message", type="string", example="Produto atualizado com sucesso"),
 *             @OA\Property(property="status", type="integer", example=200)
 *         )
 *     )
 * )
 */

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'barber_shop_id' => 'required|exists:artur_barber_shops,id',
        ]);

        $product = ArturProduct::find($id);
        $product->name = $request->name;
        $product->price = $request->price;
        $product->barber_shop_id = $request->barber_shop_id;
        $product->save();

        return response()->json([
            'product' => $product,
            'message' => 'Produto atualizado com sucesso',
            'status' => 200,
        ]);
    }

/**
 * @OA\Delete(
 *     path="api/artur/product/{id}",
 *     operationId="deleteProduct",
 *     tags={"Artur"},
 *     summary="Remove um produto existente",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID do produto",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Produto deletado com sucesso",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Produto deletado com sucesso"),
 *             @OA\Property(property="status", type="integer", example=200)
 *         )
 *     )
 * )
 */


    public function destroy($id)
    {
        $product = ArturProduct::find($id);
        $product->delete();

        return response()->json([
            'message' => 'Produto deletado com sucesso',
            'status' => 200,
        ]);
    }
}
