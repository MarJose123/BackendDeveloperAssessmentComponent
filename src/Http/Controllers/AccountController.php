<?php
/*
 * Copyright (c) 2023.  LF Backend Developer Assessment by Josie Noli Darang.
 */

namespace MarJose123\BackendDeveloperAssessmentComponent\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AccountController
{
    public function index()
    {
        return response()->json([
            'status' => 'success',
            'code' => Response::HTTP_OK,
            'message' => 'List of all User',
            'count' => User::count(),
            'data' => User::all(),
        ], Response::HTTP_OK);

    }

    public function store(Request $request)
    {
        if(!$request->hasAny(['name', 'email', 'password'])) return response()->json([
            'status' => 'failed',
            'code' => Response::HTTP_UNPROCESSABLE_ENTITY,
            'message' => 'Name, Email address, and Password is required.',
        ], Response::HTTP_UNPROCESSABLE_ENTITY);

        $createUser = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' =>  Hash::make($request->password)
        ]);

        return response()->json([
            'status' => 'success',
            'code' => Response::HTTP_CREATED,
            'message' => 'User has been successfully created',
            'data' => $createUser
        ], Response::HTTP_CREATED);


    }

    public function destroy(string $id)
    {
        User::find($id)->delete();

        return response()->json([
            'status' => 'success',
            'code' => Response::HTTP_OK,
            'message' => 'User has been deleted',
        ], Response::HTTP_OK);
    }

    public function profile()
    {
        return response()->json([
            'status' => 'success',
            'code' => Response::HTTP_OK,
            'message' => 'Your account information',
            'data' => auth()->user(),
        ], Response::HTTP_OK);
    }
}
