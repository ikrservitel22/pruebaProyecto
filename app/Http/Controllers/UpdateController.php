<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CreateUP;
use App\Models\Usuarios;
use Illuminate\Support\Facades\DB;

class UpdateController extends Controller
{
    public function Edit($id)
    {
        $Usuario = DB::table('registro') 
            ->join('per_usu', 'registro.usuario_id', '=', 'per_usu.usuario_id')
            ->select(
                'registro.usuario_id',
                'registro.usuario',
                'registro.nombre',
                'registro.clave',
                'registro.cedula',
                'per_usu.permiso_id'
            )
            ->where('registro.usuario_id', $id)
            ->first();

        $Permisos = DB::table('permisos')->get();

        return view('CRUD.Edit', compact('Usuario', 'Permisos'));
    }

    public function Update(Request $request, $id)
    {
        // 🔹 actualizar tabla registro
        DB::table('registro')
            ->where('usuario_id', $id)
            ->update([
                'usuario' => $request->usuario,
                'nombre' => $request->nombre,
                'clave' => $request->clave,
                'cedula' => $request->cedeula,
            ]);

        // 🔹 actualizar tabla per_usu
        DB::table('per_usu')
            ->where('usuario_id', $id)
            ->update([
                'permiso_id' => $request->permiso_id,
            ]);

        $permiso = DB::table('per_usu')
            ->where('usuario_id', $id)
            ->value('permiso_id');

        if (session('id') == $id) {
            session(['permiso_id' => $permiso]);
        }
        
        return redirect('/lista')->with('success', 'Usuario actualizado');
    }
}