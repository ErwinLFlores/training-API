<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getAllUser(Request $request)
    {
        $users = DB::table('users')->orderBy('id', 'asc')->get();

        $response = response()->json(
            [
                'status' => 'success',
                'data' => $users,
            ]
        );

        return $response;
    }

    public function getUserById(Request $request)
    {
        $id = $request->get('id');

        $users = DB::table('users')->where('id',$id)->first();

        if($users){
            $response = response()->json(
                [
                    'response' => [
                        'status' => 'success',
                        'data' => $users,
                    ]
                ]
            );
        }else{
            $response = response()->json(
                [
                    'response' => [
                        'status' => 'error',
                        'data' => $users,
                    ]
                ]
            );
        }


        return $response;
    }

    public function saveUser(Request $request)
    {
        $getId = DB::table('users')->orderBy('id','desc')->first();

        $user = new User();
        $user->id = $getId->id + 1;
        $user->first_name = $request->get('first_name');
        $user->last_name = $request->get('last_name');
        $user->email = $request->get('email');

        $password = $request->get('password');
        $user->password = app('hash')->make($password);


        if($user->save()){
            $response = response()->json(
                [
                    'response' => [
                        'status' => 'success',
                        'message' => 'Successfully saved!',
                    ]
                ]
            );
        }else{
            $response = response()->json(
                [
                    'response' => [
                        'status' => 'error',
                        'message' => 'Error!',
                    ]
                ]
            );
        }

        return $response;
    }

    public function updateUser(Request $request)
    {
        $id = $request->get('id');

        $update = DB::table('users')
            ->where('id', $id)
            ->update([
                'first_name' => $request->get('first_name'),
                'last_name' => $request->get('last_name'),
                'email' => $request->get('email'),
                'password' => $request->get('password'),
            ]);

        if($update){
            $response = response()->json(
                [
                    'response' => [
                        'status' => 'success',
                        'message' => 'Successfully update!',
                    ]
                ]
            );

        }else{
            $response = response()->json(
                [
                    'response' => [
                        'status' => 'error',
                        'message' => 'Error!',
                    ]
                ]
            );
        }

        return $response;
    }

    public function deleteUser(Request $request)
    {
        $id = $request->get('id');
        DB::table('users')->where('id', $id)->delete();

        $response = response()->json(
            [
                'response' => [
                    'status' => 'success',
                    'message' => 'Successfully deleted!',
                ]
            ]
        );

        return $response;
    }
}
