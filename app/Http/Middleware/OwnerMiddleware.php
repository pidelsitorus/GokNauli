<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class OwnerMiddleware
{
    public function handle(
        Request $request,
        Closure $next
    ): Response {
        if (!Auth::check()) {
            return redirect(
                route('admin.login', [], false)
            );
        }

        if (
            !Auth::user()->is_admin
            || Auth::user()->role !== 'owner'
        ) {
            abort(
                403,
                'Halaman ini hanya dapat diakses oleh pemilik.'
            );
        }

        return $next($request);
    }
}
