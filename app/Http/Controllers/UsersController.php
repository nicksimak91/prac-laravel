<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserValidationGeneratorRequest;

class UsersController extends Controller
{

    public function register(UserValidationGeneratorRequest $request)
    {

        $validation = $request->validated();
        $user = new User($validation);

        if ($user->save()) {

            return $user->getApiResponseBody($user);
        }
    }

    public function login(Request $request)
    {
        $email = $request->email;
        $password = $request->password;

        $user = User::where('email', $email)->first();

        if ($user->password === $password) {
            $token = $user->generateAndSaveToken();

            $data = [
                'data' => [
                    'api_token' => $token,
                    'email' => $user->email,
                    'id' => $user->id,
                    'name' => $user->name,
                    'surname' => $user->surname,
                ]
            ];

            return response($data, 201);
        }
    }

    public function update(UserValidationGeneratorRequest $request)
    {

        $token = $request->bearerToken();
        $validation = $request->validated();
        $user = new User();
        $data = $user->userUpdate($token, $validation);

        return response($data);
    }
}
