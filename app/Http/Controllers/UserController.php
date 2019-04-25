<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\AppResponse;
use App\User;
use App\Enums\ActiveStatus;
use App\Enums\RoleType;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
// use Carbon\Carbon;

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

        return response()->json(['success' => AppResponse::STATUS_SUCCESS, 'message' => 'Banned user successfully.'], AppResponse::HTTP_OK);
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

        return response()->json(['success' => AppResponse::STATUS_SUCCESS, 'message' => 'Unbanned user successfully.'], AppResponse::HTTP_OK);
    }

    /**
    * @OA\Delete(
    *         path="/api/users/{id}",
    *         tags={"Users"},
    *         summary="Delete an user",
    *         description="Delete an user",
    *         operationId="delete-user",
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
    public function delete($id)
    {
        // Check for data validity
        $user = User::find($id);
        if (!$id || empty($user)) {
            return response()->json(['success' => AppResponse::STATUS_FAILURE, 'message' => "User ID is invalid."], AppResponse::HTTP_BAD_REQUEST);
        }
        // Delete the data
        $user->delete();

        return response()->json(['success' => AppResponse::STATUS_SUCCESS, 'message' => 'Deleted user successfully.'], AppResponse::HTTP_OK);
    }

    /**
    * @OA\Post(
    *         path="/api/users/collection:batchDelete",
    *         tags={"Users"},
    *         summary="Delete selected users",
    *         description="Delete selected users",
    *         operationId="delete-user-batch",
    *         @OA\Response(
    *             response=200,
    *             description="Successful operation"
    *         ),
    *         @OA\Response(
    *             response=422,
    *             description="Invalid input"
    *         ),
    *         @OA\Response(
    *             response=500,
    *             description="Server error"
    *         ),
    *         @OA\RequestBody(
    *             required=true,
    *             @OA\MediaType(
    *                 mediaType="application/x-www-form-urlencoded",
    *                 @OA\Schema(
    *                     type="object",
    *                     @OA\Property(
    *                         property="ids",
    *                         description="Users' IDs",
    *                         type="array",
    *                         @OA\Items(
    *                             type="integer"
    *                         ),
    *                     ),
    *                 )
    *             )
    *         )
    * )
    */
    public function batchDelete(Request $request)
    {
        // Check for data validity
        $ids = $request->input('ids');

        if (empty($ids) || !is_array(explode(',', $ids)) || count(explode(',', $ids)) == 0) {
            return response()->json(['success' => AppResponse::STATUS_FAILURE, 'message' => 'Invalid data.'], AppResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        // Delete selected users
        User::whereIn('id', explode(',', $ids))->delete();

        return response()->json(['success' => AppResponse::STATUS_SUCCESS, 'message' => 'Deleted users successfully.'], AppResponse::HTTP_OK);
    }

    /**
    * @OA\Patch(
    *         path="/api/users/{id}",
    *         tags={"Users"},
    *         summary="Edit an user",
    *         description="Edit an user",
    *         operationId="edit-user",
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
    *         @OA\RequestBody(
    *             required=true,
    *             @OA\MediaType(
    *                 mediaType="application/x-www-form-urlencoded",
    *                 @OA\Schema(
    *                     type="object",
    *                     @OA\Property(
    *                         property="email_verified_at",
    *                         description="Email verified date",
    *                         type="string",
    *                         format="date",
    *                     ),
    *                     @OA\Property(
    *                         property="role_ids",
    *                         description="Role IDs",
    *                         type="array",
    *                         @OA\Items(
    *                             type="integer"
    *                         ),
    *                     ),
    *                 )
    *             )
    *         )
    * )
    */
    public function update(Request $request, $id)
    {
        $roleIds = $request->input('role_ids');
        // Check for data validity
        if (empty($roleIds) || !is_array(explode(',', $roleIds)) || count(explode(',', $roleIds)) == 0) {
            return response()->json(['success' => AppResponse::STATUS_FAILURE, 'message' => 'Please select at least a role.'], AppResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            DB::beginTransaction();

            $user = User::find($id);
            if ($user == null) {
                return response()->json(['success' => AppResponse::STATUS_FAILURE, 'message' => 'Invalid user ID'], AppResponse::HTTP_BAD_REQUEST);
            }
            // Update user data
            $user->fill($request->all());
            $verifiedAt = $request->input('email_verified_at');
            $user->email_verified_at = date("Y-m-d H:i:s", strtotime($verifiedAt));
            $user->save();

            // Remove old roles
            DB::table('model_has_roles')->where('model_id', $id)->where('model_type', User::class)->delete();
            // Add new roles
            $roleIdArr = preg_split('/,/', $roleIds, null, PREG_SPLIT_NO_EMPTY);
            if ($roleIdArr && is_array($roleIdArr) && !empty($roleIdArr[0]) && count($roleIdArr) > 0) {
                foreach ($roleIdArr as $roleId) {
                    $role = Role::find($roleId);
                    $user->assignRole($role->name);
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }

        return response()->json(['success' => AppResponse::STATUS_SUCCESS, 'message' => 'Edited user successfully.', 'data' => $user], AppResponse::HTTP_OK);
    }

    /**
    * @OA\Post(
    *         path="/api/users",
    *         tags={"Users"},
    *         summary="Create an user",
    *         description="Create an user",
    *         operationId="create-user",
    *         @OA\Response(
    *             response=200,
    *             description="Successful operation"
    *         ),
    *         @OA\Response(
    *             response=422,
    *             description="Invalid input or email taken"
    *         ),
    *         @OA\Response(
    *             response=500,
    *             description="Server error"
    *         ),
    *         @OA\RequestBody(
    *             required=true,
    *             @OA\MediaType(
    *                 mediaType="application/x-www-form-urlencoded",
    *                 @OA\Schema(
    *                     type="object",
    *                     @OA\Property(
    *                         property="email",
    *                         description="Email",
    *                         type="string",
    *                     ),
    *                     @OA\Property(
    *                         property="password",
    *                         description="Password",
    *                         type="string",
    *                         format="password"
    *                     ),
    *                     @OA\Property(
    *                         property="email_verified_at",
    *                         description="Email verified date",
    *                         type="string",
    *                         format="date",
    *                     ),
    *                     @OA\Property(
    *                         property="role_ids",
    *                         description="Role IDs",
    *                         type="array",
    *                         @OA\Items(
    *                             type="integer"
    *                         ),
    *                     ),
    *                 )
    *             )
    *         )
    * )
    */
    public function store(Request $request)
    {
        $roleIds = $request->input('role_ids');
        $verifiedAt = $request->input('email_verified_at');
        // Validate input data
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string',
            'role_ids' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => AppResponse::STATUS_FAILURE, 'errors'=>$validator->errors()], AppResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        // Create user
        try {
            DB::beginTransaction();
            $user = new User([
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'email_verified_at' => date("Y-m-d H:i:s", strtotime($verifiedAt))
            ]);
            $user->save();

            // Add new roles
            $roleIdArr = preg_split('/,/', $roleIds, null, PREG_SPLIT_NO_EMPTY);
            if ($roleIdArr && is_array($roleIdArr) && !empty($roleIdArr[0]) && count($roleIdArr) > 0) {
                foreach ($roleIdArr as $roleId) {
                    $role = Role::find($roleId);
                    $user->assignRole($role->name);
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }

        return response()->json(['success' => AppResponse::STATUS_SUCCESS, 'data' => $user], AppResponse::HTTP_OK);
    }
}
