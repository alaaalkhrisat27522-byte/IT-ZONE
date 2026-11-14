<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Database\Seeders\SuperAdminSeeder;

class LoginController extends Controller
{
    /** إيميل المدير الأساسي الذي يتعرف عليه النظام تلقائياً */
    private const SUPER_ADMIN_EMAIL = SuperAdminSeeder::SUPER_ADMIN_EMAIL;

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();
                        // منع المحظورين من الدخول
            if (! $user->is_active) {
                Auth::logout();
                return back()->withErrors(['email' => '🚫 حسابك موقوف — تواصل مع الإدارة.']);
            }

            // ===== الدخول الذكي =====
            $isSuperAdminEmail = strtolower($user->email) === strtolower(self::SUPER_ADMIN_EMAIL);

            if ($isSuperAdminEmail) {
                if (!$user->isSuperAdmin()) {
                    $role = \App\Models\Role::firstOrCreate(
                        ['slug' => 'super_admin'],
                        ['name' => 'Super Admin', 'is_system' => true]
                    );
                    $user->update(['role_id' => $role->id]);
                }
                return redirect()->route('admin.dashboard');
            }

            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('home');
        }

        return back()->withErrors([
            'email' => 'بيانات الدخول غير صحيحة',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('auth.login');
    }
}
