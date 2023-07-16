<?php

namespace MarJose123\BackendDeveloperAssessmentComponent\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;

class RoleController
{
    public function roleList()
    {
        return response()->json([
            'status' => 'success',
            'code' => Response::HTTP_OK,
            'message' => 'List of all Role',
            'count' => Role::count(),
            'data' => Role::all(),
        ], Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        if (! $request->hasAny(['role_name', 'permissions'])) {
            return response()->json([
                'status' => 'failed',
                'code' => Response::HTTP_UNPROCESSABLE_ENTITY,
                'message' => 'role_name address and permissions is required.',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        /*
         * Check if the permission provided is in array format
         */
        if (! is_array($request->permissions)) {
            return response()->json([
                'status' => 'failed',
                'code' => Response::HTTP_UNPROCESSABLE_ENTITY,
                'message' => 'Permissions must be in array format.',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        /*
         * Creation and Storing the DB
         */
        $createdRole = Role::create(['name' => $request->role_name])
            ->givePermissionTo(Permission::whereIn('id', $request->permissions)->get());

        if (! $createdRole) {
            return response()->json([
                'status' => 'failed',
                'code' => Response::HTTP_CREATED,
                'message' => 'Resources not created for unknown issue.',
                'count' => 0,
                'data' => null,
            ], Response::HTTP_CREATED);
        }

        return response()->json([
            'status' => 'success',
            'code' => Response::HTTP_OK,
            'message' => 'New role has been successfully added.',
            'count' => Permission::count(),
            'data' => $createdRole,
        ], Response::HTTP_OK);

    }

    public function permissionList()
    {
        return response()->json([
            'status' => 'success',
            'code' => Response::HTTP_OK,
            'message' => 'List of all Permission',
            'count' => Permission::count(),
            'data' => Permission::all(),
        ], Response::HTTP_OK);
    }
}
