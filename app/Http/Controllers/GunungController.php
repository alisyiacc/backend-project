<?php

namespace App\Http\Controllers;

use App\Models\Gunung;

class GunungController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil mengambil data gunung',
            'data' => Gunung::all(),
        ], 200);
    }
}
