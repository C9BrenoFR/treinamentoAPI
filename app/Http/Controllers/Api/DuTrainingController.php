<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DuTraining;
use App\Models\DuUser;
use Hash;
use Illuminate\Http\Request;

class DuTrainingController extends Controller
{

/**
 * @OA\Post(
 *     path="api/du/training",
 *     summary="Criar um novo treino",
 *     description="Cria um novo treino para um usuário.",
 *     tags={"Lucas Du"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"type", "weight", "repetitions", "time", "du_user_id"},
 *             @OA\Property(property="type", type="string", example="Musculação"),
 *             @OA\Property(property="weight", type="string", example="50kg"),
 *             @OA\Property(property="repetitions", type="string", example="3x12"),
 *             @OA\Property(property="time", type="string", example="45 minutos"),
 *             @OA\Property(property="du_user_id", type="integer", example=1)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Treino criado com sucesso",
 *         @OA\JsonContent(
 *             @OA\Property(property="training", ref="schemas/DuTraining"),
 *             @OA\Property(property="message", type="string", example="Treino criado com sucesso"),
 *             @OA\Property(property="status", type="integer", example=200)
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Dados inválidos"
 *     )
 * )
 */

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

    /**
 * @OA\Put(
 *     path="api/du/training/{id}",
 *     summary="Atualizar um treino existente",
 *     description="Atualiza as informações de um treino existente.",
 *     tags={"Lucas Du"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID do treino",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"type", "weight", "repetitions", "time", "du_user_id"},
 *             @OA\Property(property="type", type="string", example="Musculação"),
 *             @OA\Property(property="weight", type="string", example="55kg"),
 *             @OA\Property(property="repetitions", type="string", example="3x10"),
 *             @OA\Property(property="time", type="string", example="50 minutos"),
 *             @OA\Property(property="du_user_id", type="integer", example=1)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Treino atualizado com sucesso",
 *         @OA\JsonContent(
 *             @OA\Property(property="training", ref="schemas/DuTraining"),
 *             @OA\Property(property="message", type="string", example="Treino atualizado com sucesso"),
 *             @OA\Property(property="status", type="integer", example=200)
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Treino não encontrado"
 *     )
 * )
 */

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

/**
 * @OA\Delete(
 *     path="api/du/training/{id}",
 *     summary="Deletar um treino",
 *     description="Deleta um treino existente.",
 *     tags={"Lucas Du"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID do treino",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Treino deletado com sucesso",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Treino deletado com sucesso"),
 *             @OA\Property(property="status", type="integer", example=200)
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Treino não encontrado"
 *     )
 * )
 */

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
