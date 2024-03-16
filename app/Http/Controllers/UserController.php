<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use mysql_xdevapi\Exception;

class UserController extends Controller
{
    public  function index(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $users = User::paginate(5);
            return response()->success(200, ['data' =>$users ]);
        }catch (Exception $exception) {
            return response()->error(503, $exception->getMessage(),[]);
        }

    }

    public function show(Request $request, $id): \Illuminate\Http\JsonResponse
    {

        try {
            $user =User::find($id);
            return response()->success(200, ['data'=> $user]);
        }catch (Exception $exception) {
            return response()->error(503, $exception->getMessage(),[]);
        }
    }
}
