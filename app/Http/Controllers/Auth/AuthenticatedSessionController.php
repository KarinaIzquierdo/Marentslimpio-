<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(Request $request): RedirectResponse
    {
        $user = DB::table('users')->where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors(['email' => 'Credenciales incorrectas'])->onlyInput('email');
        }

        Auth::loginUsingId($user->id);
        $request->session()->regenerate();

        return $user->rol === 'admin' ? redirect('/admin/dashboard') : redirect('/');
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function loginApi(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = DB::table('users')->where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Credenciales incorrectas'], 401);
        }

        return response()->json(['user' => $user, 'message' => 'Login exitoso']);
    }

    public function logoutApi(Request $request)
    {
        return response()->json(['success' => true, 'message' => 'Sesión cerrada correctamente']);
    }

    public function registerApi(Request $request)
    {
        try {
            $request->validate([
                'nombres' => 'required|string|max:255',
                'apellidos' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
            ]);

            $id = DB::table('users')->insertGetId([
                'nombres' => $request->nombres,
                'apellidos' => $request->apellidos,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'rol' => 'cliente',
                'documento' => $request->documento ?? '',
                'celular' => $request->celular ?? '',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $user = DB::table('users')->where('id', $id)->first();

            return response()->json([
                'success' => true,
                'message' => 'Usuario registrado correctamente',
                'user' => $user
            ], 201);

        } catch (\Exception $e) {
            Log::error("❌ Error en registro API: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar: ' . $e->getMessage()
            ], 500);
        }
    }
}
