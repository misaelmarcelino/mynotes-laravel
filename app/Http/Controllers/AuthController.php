<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function loginSubmit(Request $request)
    {
        // Form Validation

        $request->validate(
            [
                'text_username' => 'required|email|',
                'text_password' => 'required|min:6|max:16'
            ],
            // Mensagens de erro
            [
                'text_username.required' => 'O campo usuário é obrigatório',
                'text_username.email' => 'O usuário deve ser um e-mail válido',
                'text_password.required' => 'O campo senha é obrigatório',
                'text_password.min' => 'A senha deve ter no mínimo :min caracteres',
                'text_password.max' => 'A senha deve ter no máximo :max caracteres'
            ]
        );



        //  Get user input
        $username = $request->input('text_username');
        $password = $request->input('text_password');

        //  Check if user exists

        $user = User::where('username', $username)->where('deleted_at', NULL)->first();

        if (!$user) {
            return redirect()->back()->withInput()->with(['loginError' => 'Usuário ou senha inválidos.']);
        }

        //  Check if password is correct
        if (!password_verify($password, $user->password)) {
            return redirect()->back()->withInput()->with(['loginError' => 'Usuário ou senha inválidos.']);
        }

        // update last login

        $user->last_login = date('Y-m-d H:i:s');
        $user->save();

        //login session user

        session([
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
            ],

        ]);

        return redirect()->route('home');

    }

    public function logout()
    {
        session()->forget('user');
        return redirect()->route('login');
    }
}
