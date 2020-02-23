<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public $user;

    /**
     * UserControlelr constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->user->paginate(10);

        return response()->json([
            'status' => 'Ok',
            'result' =>  compact('users')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'first_name' => 'required|min:3',
            'last_name' => 'required|min:3',
            'username' => 'required|min:3|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        if($validate->fails()) return response()->json([
            'status' => 'Ok',
            'result' => ['error' => $validate->errors()]
        ], 400);

        $user = $this->user->create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        $user->refresh();

        return response()->json([
            'status' => 'Ok',
            'result' => compact('user')
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = $this->user->find($id);

        return response()->json([
            'status' => 'Ok',
            'result' => compact('user')
        ], 200);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'first_name' => 'required|min:3',
            'last_name' => 'required|min:3',
            'username' => 'required|min:3',
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if($validate->fails()) return response()->json([
            'status' => 'Ok',
            'result' => ['error' => $validate->errors()]
        ], 400);

        $this->user->where('id',$id)->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $user = $this->user->find($id);

        return response()->json([
            'status' => 'Ok',
            'result' => compact('user')
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = $this->user->find($id);

        if(!$this->user->destroy($id)) {
            return response()->json([
                'status' => 'Ok',
                'result' => [
                    'message' => 'Unable to delete user record.'
                ]
            ], 200);
        }

        return response()->json([
            'status' => 'Ok',
            'result' => [
                'message' => "User Id {$id} has been deleted.",
                'user' => $user
            ]
        ], 200);
    }
}
