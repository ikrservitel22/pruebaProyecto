<?php

namespace App\Http\Controllers;

use App\Models\Usuarios;
use Illuminate\Http\Request;
use App\Models\UserPermission;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

/**
 * Controlador para la gestión de usuarios.
 *
 * Maneja las operaciones relacionadas con usuarios: creación, login, listado, etc.
 */
class UsuariosController extends Controller
{
    /**
     * Muestra la página principal con la lista de usuarios.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $usuarios = Usuarios::all();
        return view('Usuarios.principal', compact('usuarios')); //muestra la vista login
    }

    /**
     * Crea un nuevo usuario.
     *
     * Verifica si el usuario ya existe, y si no, lo crea junto con su permiso.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(Request $request)
    {
        // Verificar si el nombre de usuario ya está registrado
        $usuarioExistente = Usuarios::where('usuario', $request->usuario)
                            ->first();

        if ($usuarioExistente) {
            return redirect('/create')->with('error_2', 'usuario existente');
        }

        // Crear el usuario en la tabla 'registro'
        $nuevoUsuario = Usuarios::create([
            'nombre' => $request->nombre,
            'usuario' => $request->usuario,
            'clave' => $request->clave,
            'state' => true,
            'cedula' => $request->cedula
        ]);

        // Crear relación de permiso en la tabla intermedia 'rol_usu'
        UserPermission::create([
            'usuario_id' => $nuevoUsuario->usuario_id,
            'rol_id' => 2
        ]);

        return redirect('/login')->with('success', 'usuario creado');
    }

    /**
     * Maneja el login de usuarios.
     *
     * Verifica las credenciales y establece la sesión si son correctas.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        // Validar credenciales en la tabla 'registro'
        $usuario = Usuarios::where('usuario', $request->usuario)
                    ->where('clave', $request->clave)
                    ->first();

        if (!$usuario && $request->is('/*')) {
            return redirect('/login')->with('error', 'Usuario o clave incorrectos');
        }

        if ($request->is('api/*')) {

             $token = JWTAuth::fromUser($usuario);

            return response()->json([
                'token' => $token,
                'user' => [
                    'usuario' => $usuario->usuario,
                    'nombre' => $usuario->nombre,
                    'cedula' => $usuario->cedula
                ]
            ]);
        }

        // Obtener rol del usuario desde la tabla intermedia
        $rolUsuario = UserPermission::where('usuario_id', $usuario->usuario_id)
                                ->first();

        $rolId = $rolUsuario?->rol_id;
        $rolNombre = $rolUsuario?->rol?->rol;

        // Guardar datos de sesión del usuario autenticado
        session([
            'usuario' => $usuario->usuario,
            'id' => $usuario->usuario_id,
            'rol_id' => $rolId,
            'rol_nombre' => $rolNombre ? strtolower($rolNombre) : null,
        ]);

        return redirect('/')->with('success', 'Sesión iniciada correctamente');
    }

    /**
     * Muestra la lista de usuarios.
     *
     * @return \Illuminate\View\View
     */
    public function lista()
    {
        $usuarios = Usuarios::with('roles')->paginate(5)->through(function($usuario) {
            $usuario->rol_nombre = $usuario->roles->first()->rol ?? 'Sin rol';
            return $usuario;
        });
        return view('Usuarios.lista', compact('usuarios'));
    }

    /**
     * Muestra la vista de entrada de usuarios.
     *
     * @return \Illuminate\View\View
     */
    public function inputtt()
    {
        $usuarios = Usuarios::all();
        return view('Usuarios.inputtt', compact('usuarios'));
    }
}