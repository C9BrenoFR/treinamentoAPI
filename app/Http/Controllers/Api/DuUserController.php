<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DuTraining;
use App\Models\DuUser;
use Hash;
use Illuminate\Http\Request;

/**
 * @OA\Schema(
 *     schema="DuUser",
 *     type="object",
 *     required={"name", "email", "password"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="John Doe"),
 *     @OA\Property(property="email", type="string", example="johndoe@example.com"),
 *     @OA\Property(property="password", type="string", example="hashedpassword"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */

/**
 * @OA\Schema(
 *     schema="DuTraining",
 *     type="object",
 *     required={"type", "weight", "repetitions", "time", "du_user_id"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="type", type="string", example="Musculação"),
 *     @OA\Property(property="weight", type="string", example="50kg"),
 *     @OA\Property(property="repetitions", type="string", example="3x12"),
 *     @OA\Property(property="time", type="string", example="45 minutos"),
 *     @OA\Property(property="du_user_id", type="integer", example=1),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */

class DuUserController extends Controller
{
    /**
 * @OA\Post(
 *     path="api/du/user",
 *     summary="Criar um novo usuário",
 *     description="Cria um novo usuário e retorna os detalhes do usuário criado.",
 *     tags={"Lucas Du"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name", "email", "password"},
 *             @OA\Property(property="name", type="string", example="John Doe"),
 *             @OA\Property(property="email", type="string", format="email", example="johndoe@example.com"),
 *             @OA\Property(property="password", type="string", example="password123")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Usuário criado com sucesso",
 *         @OA\JsonContent(
 *             @OA\Property(property="user", ref="schemas/DuUser"),
 *             @OA\Property(property="message", type="string", example="Usuário criado com sucesso"),
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
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $duUser = new DuUser();
        $duUser->name = $request->name;
        $duUser->email = $request->email;
        $duUser->password = Hash::make($request->password);
        $duUser->save();

        return response()->json([
            'user' => $duUser,
            'message' => 'Usuário criado com sucesso',
            'status' => 200,
        ]);
    }

    /**
 * @OA\Put(
 *     path="api/du/user/{id}",
 *     summary="Atualizar um usuário existente",
 *     description="Atualiza as informações de um usuário existente.",
 *     tags={"Lucas Du"},
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
 *             required={"name", "email"},
 *             @OA\Property(property="name", type="string", example="John Doe"),
 *             @OA\Property(property="email", type="string", format="email", example="johndoe@example.com"),
 *             @OA\Property(property="password", type="string", example="newpassword123", description="Senha nova, opcional")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Usuário atualizado com sucesso",
 *         @OA\JsonContent(
 *             @OA\Property(property="data", ref="schemas/DuUser"),
 *             @OA\Property(property="message", type="string", example="Usuário atualizado com sucesso"),
 *             @OA\Property(property="status", type="integer", example=200)
 *         )
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
        ]);

        $duUser = DuUser::find($id);

        if(!$duUser){
            return response()->json([
                'message' => 'Usuário não encontrado',
                'status' => 404,
            ]);
        }

        $duUser->name = $request->name;
        $duUser->email = $request->email;
        if($request->password)
            $duUser->password = Hash::make($request->password);
        $duUser->save();

        return response()->json([
            'data' => $duUser,
            'message' => 'Usuário atualizado com sucesso',
            'status' => 200,
        ]);
    }

/**
 * @OA\Delete(
 *     path="api/du/user/{id}",
 *     summary="Deletar um usuário",
 *     description="Deleta um usuário existente.",
 *     tags={"Lucas Du"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID do usuário",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Usuário deletado com sucesso",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Usuário deletado com sucesso"),
 *             @OA\Property(property="status", type="integer", example=200)
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Usuário não encontrado"
 *     )
 * )
 */


    public function destroy($id){
        $duUser = DuUser::find($id);

        if(!$duUser){
            return response()->json([
                'message' => 'Usuário não encontrado',
                'status' => 404,
            ]);
        }

        $duUser->delete();

        return response()->json([
            'message' => 'Usuário deletado com sucesso',
            'status' => 200,
        ]);
    }

/**
 * @OA\Get(
 *     path="api/du/user/{id}",
 *     summary="Exibir detalhes de um usuário",
 *     description="Retorna os detalhes de um usuário específico, junto com seus treinos associados.",
 *     tags={"Lucas Du"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID do usuário",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Usuário encontrado",
 *         @OA\JsonContent(
 *             @OA\Property(property="user", ref="schemas/DuUser"),
 *             @OA\Property(property="trainings", type="array", @OA\Items(ref="schemas/DuTraining")),
 *             @OA\Property(property="status", type="integer", example=200)
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Usuário não encontrado"
 *     )
 * )
 */

    public function show($id){
        $duUser = DuUser::find($id);

        if(!$duUser){
            return response()->json([
                'message' => 'Usuário não encontrado',
                'status' => 404,
            ]);
        }

        $training = DuTraining::where('du_user_id', $id)->get();

        return response()->json([
            'user' => $duUser,
            'trainings' => $training,
            'status' => 200,
        ]);
    }
}
