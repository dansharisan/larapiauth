<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\AppResponse;
use App\User;
use App\Enums\ActiveStatus;
use App\Enums\RoleType;

class UserController extends Controller
{
    /**
    * @OA\Get(
    *         path="/api/users",
    *         tags={"Users"},
    *         summary="Get users",
    *         description="Get list of users",
    *         operationId="user-list",
    *         @OA\Parameter(
    *             name="page",
    *             in="query",
    *             description="Current page",
    *             required=false,
    *             @OA\Schema(
    *                 type="integer",
    *             )
    *         ),
    *         @OA\Parameter(
    *             name="per_page",
    *             in="query",
    *             description="Items per page",
    *             required=false,
    *             @OA\Schema(
    *                 type="integer",
    *             )
    *         ),
    *         @OA\Response(
    *             response=200,
    *             description="Successful operation"
    *         ),
    *         @OA\Response(
    *             response=500,
    *             description="Server error"
    *         ),
    * )
    */
    public function index(Request $request)
    {
        $users = User::paginate($request->query('per_page'));

        for ($i=0; $i<count($users); $i++) {
            $roleArr = [];
            foreach ($users[$i]->getRoleNames() as $role) {
                array_push($roleArr, RoleType::getKey($role));
            }
            $users[$i]['display_roles'] = implode(", ", $roleArr);
            $users[$i]['status'] = ActiveStatus::getKey($users[$i]['active']);
        }

        return response()->json(['success' => AppResponse::STATUS_SUCCESS, 'data' => $users], AppResponse::HTTP_OK);
    }
}
