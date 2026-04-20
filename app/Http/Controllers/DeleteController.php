<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CreateUP;
use App\Models\Usuarios;

class DeleteController extends Controller
{
    public function destroy($id)
    {
        $usuario = Usuarios::findOrFail($id);
        $usuario->delete();

        return redirect('/lista')->with('success', 'Usuario eliminado');
    }
}
