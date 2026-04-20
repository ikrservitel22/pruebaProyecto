<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class InactivateController extends Controller
{
    public function Softdelete($id)
    {
        DB::table('registro')
            ->where('usuario_id', $id)
            ->update([
                'state' => 0
            ]);

        return redirect('/lista')->with('success', 'Usuario eliminado');
    }
}
