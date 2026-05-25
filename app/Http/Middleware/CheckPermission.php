<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $permission): Response
    {
        // $routeName = \Route::currentRouteName();
        // $user = Auth::user();
        // if($user->can($routeName)){
        //     return $next($request);
        // }else{
        //      abort(404);
        // }

        if (!auth()->check()) {
            abort(401);
        }
        $permission = "admin." . $permission;
        // echo $permission;
        // die;
        // return "working";

        if (!auth()->user()->can($permission)) {
            abort(403, 'You do not have permission.');
        }

        return $next($request);

    }
}
