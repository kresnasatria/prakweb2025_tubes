<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Closure;
use Illuminate\Http\Response;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up(): void
{
    Schema::table('users', function (Blueprint $table) {
        // Kita set default 'customer' agar user yang register otomatis jadi pembeli
        $table->string('role')->default('customer')->after('email');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }

    public function handle(Request $request, Closure $next): Response
{
    // Cek 1: Apakah user sudah login?
    // Cek 2: Apakah role-nya 'admin'?
    if (Auth::check() && Auth::user()->role === 'admin') {
        return $next($request); // Silakan masuk
    }

    // Jika tidak, lempar error 403 (Forbidden) atau redirect ke home
    abort(403, 'Anda bukan Admin!');
}
};
