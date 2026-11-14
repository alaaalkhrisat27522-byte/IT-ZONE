<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');

        $users = User::with('role')
            ->when($q, fn ($query) => $query->where(function ($query) use ($q) {
                $query->where('full_name', 'like', "%{$q}%")->orWhere('email', 'like', "%{$q}%");
            }))
            ->latest()
            ->get();

        return view('admin.users.index', compact('users', 'q'));
    }

    /** ترقية مستخدم عادي ← أدمن */
    public function promote(User $user)
    {
        if ($user->isSuperAdmin()) {
            return back()->with('success', '👑 حساب المدير الأعلى لا يمكن تعديله!');
        }

        $user->update(['role_id' => Role::firstOrCreate(['slug' => 'admin'], ['name' => 'Admin', 'is_system' => true])->id]);

        return back()->with('success', "✅ تمت ترقية {$user->full_name} إلى Admin!");
    }

    /** تنزيل أدمن ← مستخدم عادي */
    public function demote(User $user)
    {
        if ($user->isSuperAdmin()) {
            return back()->with('success', '👑 حساب المدير الأعلى لا يمكن تعديله!');
        }

        $user->update(['role_id' => Role::firstOrCreate(['slug' => 'user'], ['name' => 'User', 'is_system' => true])->id]);

        return back()->with('success', "⬇️ تم تنزيل {$user->full_name} إلى مستخدم عادي!");
    }

    /** حظر / تفعيل */
    public function toggle(User $user)
    {
        if ($user->isSuperAdmin() || $user->id === auth()->id()) {
            return back()->with('success', 'لا يمكنك حظر نفسك أو المدير الأعلى!');
        }

        $user->update(['is_active' => ! $user->is_active]);

        return back()->with('success', $user->is_active ? "✅ تم تفعيل {$user->full_name}!" : "🚫 تم حظر {$user->full_name}!");
    }

    /** حذف نهائي */
    public function destroy(User $user)
    {
        if ($user->isSuperAdmin() || $user->id === auth()->id()) {
            return back()->with('success', 'لا يمكنك حذف نفسك أو المدير الأعلى!');
        }

        $user->delete();

        return back()->with('success', "🗑️ تم حذف {$user->full_name} نهائياً!");
    }
}
