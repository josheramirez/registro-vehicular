<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Closure;

class Roles
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $tipo_usuario)
    {
        $user = Auth::user();
        if ($user == null) {
            return redirect()->route('login');
        }
        $arr = explode(';', $tipo_usuario);
        $pasa = 0;
        foreach ($arr as $a) {
            if ($user->tipo_usuario == $a) {
                $pasa = 1;
            }
        }
        if ($pasa == 1) {
            return $next($request);
        } else {
            return response()->view('errores/503');
        }
        return $next($request);
    }
}
