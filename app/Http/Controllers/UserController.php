<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Traits\LocalResponse;

class UserController extends Controller
{
    public function login(LoginRequest $request)
    {
        $user = User::where('name', "like", $request->name)->first();
        info($request);

        if (!Hash::check($request->password, $user->password))
            return LocalResponse::returnError('البيانات غير متوافقة', 400, [
                'password' => ['كملة السر خطأ']
            ]);

        $token = $user->getToken();
        return LocalResponse::returnData("login", [
            'token' => $token,
            'user' => $user
        ]);
    }
}
