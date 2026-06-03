<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = User::all();
        return view('admin.usuarios.index', compact('usuarios'));
    }

    public function storeApi(Request $request)
    {
        try {
            $request->validate([
                'nombres' => 'required|string|max:255',
                'apellidos' => 'required|string|max:255',
                'email' => 'required|email|unique:users',
                'documento' => 'required|string|max:255|unique:users',
                'celular' => 'required|string|max:255',
                'rol' => 'required|in:admin,cliente',
                'password' => 'required|string|min:8',
            ]);

            $usuario = User::create([
                'nombres' => $request->nombres,
                'apellidos' => $request->apellidos,
                'email' => $request->email,
                'documento' => $request->documento,
                'celular' => $request->celular,
                'rol' => $request->rol,
                'password' => bcrypt($request->password),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Usuario creado correctamente',
                'user' => $usuario
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

    public function edit($id)
    {
        $usuario = User::findOrFail($id);
        return view('admin.usuarios.edit', compact('usuario'));
    }

    public function updateApi(Request $request, $id)
    {
        try {
            $usuario = User::findOrFail($id);

            $request->validate([
                'nombres' => 'required|string|max:255',
                'apellidos' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $id,
                'documento' => 'nullable|string|max:255',
                'celular' => 'nullable|string|max:255',
                'rol' => 'required|in:admin,cliente',
            ]);

            $usuario->nombres = $request->nombres;
            $usuario->apellidos = $request->apellidos;
            $usuario->email = $request->email;
            $usuario->documento = $request->documento;
            $usuario->celular = $request->celular;
            $usuario->rol = $request->rol;

            // Solo actualizar password si se proporciona uno nuevo
            if ($request->filled('password')) {
                $usuario->password = bcrypt($request->password);
            }

            $usuario->save();

            return response()->json([
                'success' => true,
                'message' => 'Usuario actualizado correctamente',
                'user' => [
                    'id' => $usuario->id,
                    'nombres' => $usuario->nombres,
                    'apellidos' => $usuario->apellidos,
                    'email' => $usuario->email,
                    'rol' => $usuario->rol,
                ]
            ], 200);

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

    public function update(Request $request, $id)
    {
        $usuario = User::findOrFail($id);

        $request->validate([
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'documento' => 'nullable|string|max:255',
            'celular' => 'nullable|string|max:255',
            'rol' => 'required|in:admin,cliente',
        ]);

        $usuario->nombres = $request->nombres;
        $usuario->apellidos = $request->apellidos;
        $usuario->email = $request->email;
        $usuario->documento = $request->documento;
        $usuario->celular = $request->celular;
        $usuario->rol = $request->rol;

        // Solo actualizar password si se proporcionó uno nuevo
        if ($request->filled('password')) {
            $usuario->password = bcrypt($request->password);
        }

        $usuario->save();

        return redirect()->route('admin.usuarios')->with('success', 'Usuario actualizado correctamente');
    }

    public function indexApi()
    {
        try {
            $users = User::all();
            return response()->json($users, 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al obtener usuarios',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function destroyApi($id)
    {
        try {
            $user = User::find($id);

            if (!$user) {
                return response()->json([
                    'error' => 'Usuario no encontrado'
                ], 404);
            }

            // Evitar que se elimine el admin principal
            if ($user->rol === 'admin' && $user->id === 1) {
                return response()->json([
                    'error' => 'No se puede eliminar el administrador principal'
                ], 403);
            }

            $user->delete();

            return response()->json([
                'message' => 'Usuario eliminado correctamente'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al eliminar usuario',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
