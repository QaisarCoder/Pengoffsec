<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class DashboardController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(function ($request, $next) {
                if (!auth()->user() || !auth()->user()->is_admin) {
                    abort(403);
                }
                return $next($request);
            }),
        ];
    }

    public function index()
    {
        return view('admin.dashboard.index');
    }
}
