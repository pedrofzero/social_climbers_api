<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Lib\Responses;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');

        if (!$name || !$email || !$password) {
            return $this->response(Responses::ERROR['invalid_data']);
        }

        $existingUser = User::where('email', $email)->first();
        if ($existingUser) {
            return $this->response(Responses::ERROR['email_already_exists']);
        }

        $user = new User();

        $user->name = $name;
        $user->email = $email;
        $user->password($password);
        $user->save();

        return $this->response(Responses::SUCCESS);
    }

    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        if (!$email || !$password) {
            return $this->response(Responses::ERROR['invalid_data']);
        }

        $user = User::where('email', $email)->first();
        if (!$user) {
            return $this->response(Responses::ERROR['email_already_exists']);
        }

        if (!Hash::check($password, $user->password)) {
            return $this->response(Responses::ERROR['wrong_credentials']);
        }

        $token = $user->createToken("client")->plainTextToken;

        return $this->response(Responses::SUCCESS, [
            'user' => new UserResource($user),
            'token' => $token
        ]);
    }
}
