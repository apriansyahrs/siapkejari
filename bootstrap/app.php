<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            Route::prefix('panel')->middleware(['web'])->name('panel.')->group(base_path('routes/panel.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->redirectGuestsTo(function($request) {
            if ($request->is('panel/*')) {
                return route('panel.login');
            }
            return route('login');
        });
        $middleware->redirectUsersTo(function($request) {
            if ($request->is('panel/*')) {
                return route('panel.employee');
            }
            return route('home');
        });
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
