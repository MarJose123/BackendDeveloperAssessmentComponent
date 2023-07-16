<?php

namespace MarJose123\BackendDeveloperAssessmentComponent\Http\Controllers;

use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

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

    public function store()
    {

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
