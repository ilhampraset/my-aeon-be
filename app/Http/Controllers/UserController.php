<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use mysql_xdevapi\Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
class UserController extends Controller
{
    public  function index(): \Illuminate\Http\JsonResponse
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
            $user = User::findOrFail($id);
            return response()->success(200, ['data'=> $user]);
        }catch (ModelNotFoundException $e) {
            return response()->error(404, 'Failed Retrieve Data', [$e->getMessage()]);
        }catch (\Exception $exception) {
            return response()->error(500, $exception->getMessage(), [$exception->getMessage()]);
        }

    }
}
