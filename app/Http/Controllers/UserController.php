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

    /**
    * @OA\Patch(
    *         path="/api/users/{id}/ban",
    *         tags={"Users"},
    *         summary="Ban an user",
    *         description="Ban an user",
    *         operationId="ban-user",
    *         @OA\Response(
    *             response=200,
    *             description="Successful operation"
    *         ),
    *         @OA\Response(
    *             response=500,
    *             description="Server error"
    *         ),
    *         @OA\Parameter(
    *             name="id",
    *             in="path",
    *             description="User ID",
    *             required=true,
    *             @OA\Schema(
    *                 type="integer",
    *             )
    *         ),
    * )
    */
    public function ban($id)
    {
        // Check for data validity
        $user = User::find($id);
        if (!$id || empty($user)) {
            return response()->json(['success' => AppResponse::STATUS_FAILURE, 'message' => "User ID is invalid."], AppResponse::HTTP_BAD_REQUEST);
        }
        // Update the data
        $user->active = ActiveStatus::Banned;
        $user->save();

        return response()->json(['success' => AppResponse::STATUS_SUCCESS], AppResponse::HTTP_OK);
    }

    /**
    * @OA\Patch(
    *         path="/api/users/{id}/unban",
    *         tags={"Users"},
    *         summary="Unban an user",
    *         description="Unban an user",
    *         operationId="unban-user",
    *         @OA\Response(
    *             response=200,
    *             description="Successful operation"
    *         ),
    *         @OA\Response(
    *             response=500,
    *             description="Server error"
    *         ),
    *         @OA\Parameter(
    *             name="id",
    *             in="path",
    *             description="User ID",
    *             required=true,
    *             @OA\Schema(
    *                 type="integer",
    *             )
    *         ),
    * )
    */
    public function unban($id)
    {
        // Check for data validity
        $user = User::find($id);
        if (!$id || empty($user)) {
            return response()->json(['success' => AppResponse::STATUS_FAILURE, 'message' => "User ID is invalid."], AppResponse::HTTP_BAD_REQUEST);
        }
        // Update the data
        if ($user->email_verified_at) {
            $user->active = ActiveStatus::Active;
        } else {
            $user->active = ActiveStatus::Inactive;
        }
        $user->save();

        return response()->json(['success' => AppResponse::STATUS_SUCCESS], AppResponse::HTTP_OK);
    }
}
