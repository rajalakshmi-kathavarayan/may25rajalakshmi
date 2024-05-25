<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function index(){
        return view('auth.login');
    }
    public function showRegistrationForm()
    {
        // dd('hi');
        return view('auth.register');
    }
    public function checkEmail(Request $request)
    {
        $email = $request->input('email');


        $user = User::where('email', $email)->exists();

        return response()->json(['exists' => $user]);
    }

    public function register(Request $request)
    {

        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'cpassword' => 'required',
            'contact' => 'required',
        ]);
        $emailExists = User::where('email', $request->input('email'))->exists();

        if ($emailExists) {
            return response()->json(['error' => 'Email already exists'], 422);
        }
        $newUser = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'cpassword' => $request->input('cpassword'),
            'contact' => $request->input('contact'),
        ]);
        return response()->json(['message' => 'User registered successfully']);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return response()->json(['authenticated' => true]);
        } else {
            return response()->json(['authenticated' => false], 401);
        }
    }
}
