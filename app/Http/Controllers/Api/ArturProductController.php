<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ArturProduct;
use Illuminate\Http\Request;

class ArturProductController extends Controller
{
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
