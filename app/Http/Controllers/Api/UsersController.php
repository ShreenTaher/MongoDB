<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }
    private function userValidator($data)
    {
        return Validator::make($data,
            [
                'name'      => 'required|min:3|max:60',
                'email'     => 'required|email',
                'password'  => 'required'
            ]);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $validator = $this->userValidator($data);

        if ($validator->fails()) {
            $errors = [];
            foreach ($validator->errors()->toArray() as $key => $value) {
                $errors[$key] = $value[0];
            }
            return response()->json(['errors' => $errors]);
        }

        $user = User::create(array_merge($request->except('password'), ['password' => Hash::make($request->password)]));
        return response()->json($user);
    }

    public function update($id, Request $request)
    {
        $data = $request->all();
        $validator = $this->userValidator($data);

        if ($validator->fails()) {
            $errors = [];
            foreach ($validator->errors()->toArray() as $key => $value) {
                $errors[$key] = $value[0];
            }
            return response()->json(['errors' => $errors]);
        }
        $user = User::where('_id', $id)->firstOrFail();
        $user->update(array_merge($request->except('password'), ['password' => Hash::make($request->password)]));
        return response()->json($user);
    }

    public function destroy($id)
    {
        User::where('_id', $id)->firstOrFail()->delete();
        return response()->json(['status' => 'success']);
    }
}
