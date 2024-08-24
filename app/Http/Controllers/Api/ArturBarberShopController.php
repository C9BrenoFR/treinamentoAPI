<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ArturBarberShop;
use App\Models\ArturProduct;
use Illuminate\Http\Request;

class ArturBarberShopController extends Controller
{
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
