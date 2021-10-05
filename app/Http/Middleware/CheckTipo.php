<?php

namespace App\Http\Middleware;

use App\Models\Tipo;
use Closure;
use Illuminate\Http\Request;

class CheckTipo
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $tipo)
    {
        if ($tipo == Tipo::ADMIN && $request->user()->tipo != Tipo::ADMIN) {
            return response()->json(['message' => 'No tiene permisos para acceder']);
        } else if ($tipo == Tipo::CLIENTE && $request->user()->tipo != Tipo::CLIENTE) {
            return response()->json(['message' => 'No tiene permisos para acceder']);
        } else if ($tipo == Tipo::VENDEDOR && $request->user()->tipo != Tipo::VENDEDOR) {
            return response()->json(['message' => 'No tiene permisos para acceder']);
        } else if ($tipo == Tipo::NOMINA && $request->user()->tipo != Tipo::NOMINA) {
            return response()->json(['message' => 'No tiene permisos para acceder']);
        }
        return $next($request);
    }
}
