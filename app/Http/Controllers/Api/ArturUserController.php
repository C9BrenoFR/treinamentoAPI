<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ArturUser;
use Hash;
use Illuminate\Http\Request;

class ArturUserController extends Controller
{

/**
 * @OA\Post(
 *     path="api/artur/user",
 *     operationId="createUser",
 *     tags={"Artur"},
 *     summary="Cria um novo usuário",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name","email","password"},
 *             @OA\Property(property="name", type="string", example="Artur"),
 *             @OA\Property(property="email", type="string", example="artur@example.com"),
 *             @OA\Property(property="password", type="string", example="123456"),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Usuário criado com sucesso",
 *         @OA\JsonContent(
 *             @OA\Property(property="id", type="integer", example=1),
 *             @OA\Property(property="name", type="string", example="Artur"),
 *             @OA\Property(property="email", type="string", example="artur@example.com"),
 *             @OA\Property(property="password", type="string", example="$2y$10$..."),
 *             @OA\Property(property="created_at", type="string", format="date-time", example="2024-08-21T00:00:00.000000Z"),
 *             @OA\Property(property="updated_at", type="string", format="date-time", example="2024-08-21T00:00:00.000000Z"),
 *         )
 *     )
 * )
 */

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = new ArturUser();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json($user);
    }

/**
 * @OA\Put(
 *     path="api/artur/user/{id}",
 *     operationId="updateUser",
 *     tags={"Artur"},
 *     summary="Atualiza as informações de um usuário existente",
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
 *             required={"name","email"},
 *             @OA\Property(property="name", type="string", example="Artur Atualizado"),
 *             @OA\Property(property="email", type="string", example="artur.updated@example.com"),
 *             @OA\Property(property="password", type="string", example="123456"),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Usuário atualizado com sucesso",
 *         @OA\JsonContent(
 *             @OA\Property(property="user", type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="Artur Atualizado"),
 *                 @OA\Property(property="email", type="string", example="artur.updated@example.com"),
 *                 @OA\Property(property="password", type="string", example="$2y$10$..."),
 *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-08-21T00:00:00.000000Z"),
 *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-08-21T00:00:00.000000Z"),
 *             ),
 *             @OA\Property(property="message", type="string", example="Usuário atualizado com sucesso"),
 *             @OA\Property(property="status", type="integer", example=200)
 *         )
 *     )
 * )
 */


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
        ]);

        $user = ArturUser::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'Usuário não encontrado',
                'status' => 404,
            ]);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return response()->json([
            'user' => $user,
            'message' => 'Usuário atualizado com sucesso',
            'status' => 200,
        ]);
    }

/**
 * @OA\Delete(
 *     path="api/artur/user/{id}",
 *     operationId="deleteUser",
 *     tags={"Artur"},
 *     summary="Remove um usuário existente",
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
 *     )
 * )
 */

    public function destroy($id)
    {
        $user = ArturUser::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'Usuário não encontrado',
                'status' => 404,
            ]);
        }

        $user->delete();

        return response()->json([
            'message' => 'Usuário deletado com sucesso',
            'status' => 200,
        ]);
    }

/**
 * @OA\Get(
 *     path="api/artur/user/{id}",
 *     operationId="getUser",
 *     tags={"Artur"},
 *     summary="Exibe as informações de um usuário específico",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID do usuário",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Detalhes do usuário",
 *         @OA\JsonContent(
 *             @OA\Property(property="user", type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="Artur"),
 *                 @OA\Property(property="email", type="string", example="artur@example.com"),
 *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-08-21T00:00:00.000000Z"),
 *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-08-21T00:00:00.000000Z"),
 *             ),
 *             @OA\Property(property="status", type="integer", example=200)
 *         )
 *     )
 * )
 */


    public function show($id)
    {
        $user = ArturUser::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'Usuário não encontrado',
                'status' => 404,
            ]);
        }

        return response()->json([
            'user' => $user,
            'status' => 200,
        ]);
    }
}
