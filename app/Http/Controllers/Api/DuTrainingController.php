<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DuTraining;
use App\Models\DuUser;
use Hash;
use Illuminate\Http\Request;

class DuTrainingController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'type' => 'required',
            'weight' => 'required',
            'repetitions' => 'required',
            'time' => 'required',
            'du_user_id' => 'required',
        ]);

        $duTraining = new DuTraining();
        $duTraining->type = $request->type;
        $duTraining->weight = $request->weight;
        $duTraining->repetitions = $request->repetitions;
        $duTraining->time = $request->time;
        $duTraining->du_user_id = $request->du_user_id;
        $duTraining->save();

        return response()->json([
            'training' => $duTraining,
            'message' => 'Treino criado com sucesso',
            'status' => 200,
        ]);
    }

    public function update(Request $request, $id){
        $request->validate([
            'type' => 'required',
            'weight' => 'required',
            'repetitions' => 'required',
            'time' => 'required',
            'du_user_id' => 'required',
        ]);

        $duTraining = DuTraining::find($id);

        if(!$duTraining){
            return response()->json([
                'message' => 'Treino não encontrado',
                'status' => 404,
            ]);
        }

        $duTraining->type = $request->type;
        $duTraining->weight = $request->weight;
        $duTraining->repetitions = $request->repetitions;
        $duTraining->time = $request->time;
        $duTraining->du_user_id = $request->du_user_id;
        $duTraining->save();

        return response()->json([
            'training' => $duTraining,
            'message' => 'Treino atualizado com sucesso',
            'status' => 200,
        ]);
    }

    public function destroy($id){
        $duTraining = DuTraining::find($id);

        if(!$duTraining){
            return response()->json([
                'message' => 'Treino não encontrado',
                'status' => 404,
            ]);
        }

        $duTraining->delete();

        return response()->json([
            'message' => 'Treino deletado com sucesso',
            'status' => 200,
        ]);
    }
}
