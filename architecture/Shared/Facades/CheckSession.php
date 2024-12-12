<?php

namespace Architecture\Shared\Facades;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $x1 = array_keys(session()->all());
        $x2 = [
            'id',
            'name',
            'level',
            'levelActive',
            'kodeFakultas',
            'kodeProdi',
            'jafung',
            'author_id',
        ];

        $x3 = [
            'alter_id',
            'alter_name',
            'alter_level',
            'alter_levelActive',
            'alter_kodeFakultas',
            'alter_kodeProdi',
            'alter_jafung',
            'alter_author_id',
        ];

        $rule1 = count(array_intersect($x1, $x2)) > 0;
        $rule2 = count(array_intersect($x1, $x3)) > 0;

        if ($rule1 || $rule2) {
            return $next($request);
        }
        return redirect()->route('auth.authorization');
    }
}
