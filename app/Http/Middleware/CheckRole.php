<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,...$roles): Response
    {
        $user = $request->user();
        if(!$user){
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }
        if(!in_array($user->role, $roles)){
            return response()->json([
                'message' => 'Forbidden action'
            ], 403);
        }
        return $next($request);
    }
}
