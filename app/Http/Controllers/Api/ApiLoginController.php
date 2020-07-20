<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller as Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class ApiLoginController extends Controller
{

    public function login(Request $request)
    {

        $email = $request->query('email');
        $password = $request->query('password');

        $user = User::where('is_active', 0)
            ->where('application_user.email', '=', $email)
            ->first();

        if ($user) {

            if (Hash::check($password, $user->password)) {
                $role = $user->permission->code;
                if ($role != "OPERADOR") {
                    return response()->json(['code'=>403, 'message' => 'No Autorizado'], 403);
                }
                $token = Str::random(60);
                $user->forceFill([
                    'api_token' => hash('sha256', $token),
                ])->save();
                return ['token' => $token];
            } else {
                return response()->json(['code'=>401, 'message' => 'Credenciales incorrectas'], 401);
            }

        } else {

            return response()->json(['code'=>404, 'message' => 'Usuario no registrado'], 404);

        }
    }

}
