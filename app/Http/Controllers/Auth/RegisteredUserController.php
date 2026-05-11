<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function registerApi(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'nombres' => ['required', 'string', 'max:255'],
                'apellidos' => ['required', 'string', 'max:255'],
                'documento' => ['nullable', 'string', 'max:255'],
                'celular' => ['nullable', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
                'password' => ['required', 'string', 'min:8'],
            ]);

            $userData = [
                'nombres' => $request->nombres,
                'apellidos' => $request->apellidos,
                'documento' => $request->documento,
                'celular' => $request->celular,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ];

            // Solo agregar rol si existe la columna en la base de datos
            try {
                $userData['rol'] = 'cliente';
                $user = User::create($userData);
            } catch (\Exception $e) {
                // Si falla por la columna rol, crear sin ese campo
                unset($userData['rol']);
                $user = User::create($userData);
            }

            event(new Registered($user));

            return response()->json([
                'success' => true,
                'message' => 'Usuario registrado correctamente',
                'user' => [
                    'id' => $user->id,
                    'nombres' => $user->nombres,
                    'apellidos' => $user->apellidos,
                    'email' => $user->email,
                    'rol' => $user->rol ?? 'cliente',
                ]
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error del servidor: ' . $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nombres' => ['required', 'string', 'max:255'],
            'apellidos' => ['required', 'string', 'max:255'],
            'documento' => ['nullable', 'string', 'max:255'],
            'celular' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', \Illuminate\Validation\Rules\Password::defaults()],
        ]);

        $userData = [
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'documento' => $request->documento,
            'celular' => $request->celular,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ];

        // Solo agregar rol si existe la columna en la base de datos
        try {
            $userData['rol'] = 'cliente';
            $user = User::create($userData);
        } catch (\Exception $e) {
            // Si falla por la columna rol, crear sin ese campo
            unset($userData['rol']);
            $user = User::create($userData);
        }

        event(new Registered($user));
        Auth::login($user);

        return redirect('/');
    }
}