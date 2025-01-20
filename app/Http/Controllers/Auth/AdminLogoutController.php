<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Filament\Facades\Filament;

class AdminLogoutController extends Controller
{
    public function logout(Request $request)
    {
        // Limpiar la sesión de Filament
        if (Filament::auth()->check()) {
            Filament::auth()->logout();
        }

        // Limpiar la sesión de Laravel
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
