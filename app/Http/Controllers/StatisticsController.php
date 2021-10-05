<?php

namespace App\Http\Controllers;

use App\Models\Statistic;
use App\Models\User;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'movements' => ['required', 'integer', 'min:0'],
            'bad_movements' => ['required', 'integer', 'min:0'],
            'start_at' => ['required', 'date_format:Y-m-d H:i:s'],
            'end_at' => ['required', 'date_format:Y-m-d H:i:s'],
        ]);

        $data = $request->only('movements', 'bad_movements', 'start_at', 'end_at');
        \Auth::user()->statistics()->save(new Statistic($data));
        $message = 'Estadisticas de juego guardadas.';

        return response()->json(compact('message'), 200);
    }
}
