<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Method untuk mendaftarkan akun user
    public function register(Request $request)
    {
        $input = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)

        ];
        // Membuat data user baru dan disimpan ke database
        $user = User::create($input);
        // Menampilkan pesan berhasil dan kode 200 
        $data = [
            'message' => 'Register is success'
        ];

        return response()->json($data, 200);        
    }

    // Method login user
    public function login(request $request)
    {  
        // Meng input email dan password user 
        $input = [
            'email' => $request->email,
            'password' => $request->password
        ];        

        // Kondisi jika autentikasi berhasil maka akan mengembalikan pesan berhasil dan token
        if (Auth::attempt($input)) 
        {
            $token = Auth::user()->createToken('auth_token');

            $data = [
                'message' => 'Login is success',
                'token' => $token->plainTextToken
            ];

            return response()->json($data, 200);
        }

        // Kondisi jika tidak terpenuhi maka akan mengembalikan pesan erorr dan kode 401
        else {
            $data = [
                'message' => 'Invalid Login'
            ];

            return response()->json($data, 401);
        }
    }
}
