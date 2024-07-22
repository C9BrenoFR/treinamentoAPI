<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Identity;
use Illuminate\Http\Request;

/**
 * @OA\Info(
 *  title="Treinamento API",
 *  version="1.0",
 * )
 */

class IdentityController extends Controller
{

    /**
     * @OA\Get(
     *     path="/api/identities",
     *     summary="Get all identities",
     *     tags={"Identity"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(
     *                     property="id",
     *                     type="integer",
     *                     example=1
     *                 ),
     *                 @OA\Property(
     *                     property="title",
     *                     type="string",
     *                     example="Example Title"
     *                 ),
     *                 @OA\Property(
     *                     property="text",
     *                     type="string",
     *                     example="Example text for the identidade."
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function index(){
        $identities = Identity::all();

        if($identities->isEmpty()){
            return response()->json([
                'message' => 'Não foi encontrado nenhum registro',
                'status' => 204
            ]);
        }

        return response()->json([
            'identities' => $identities,
            'status' => 200
        ]);
    }
}
