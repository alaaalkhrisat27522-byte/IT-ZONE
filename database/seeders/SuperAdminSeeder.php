<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * حساب الإدارة الأساسي (Super Admin) — يُنشأ تلقائياً عند أول تشغيل.
 * الاسم: Alaa | الإيميل: alaaalkhrisat27522@gmail.com | كلمة المرور: ITZone2026
 */
class SuperAdminSeeder extends Seeder
{
    public const SUPER_ADMIN_EMAIL = 'alaaalkhrisat27522@gmail.com';
    public const SUPER_ADMIN_PASSWORD = 'ITZone2026';

    public function run(): void
    {
        // ===== الأدوار الأساسية =====
        $superAdmin = Role::firstOrCreate(
            ['slug' => 'super_admin'],
            ['name' => 'Super Admin', 'description' => 'المدير الأعلى — كل الصلاحيات', 'is_system' => true]
        );
        Role::firstOrCreate(
            ['slug' => 'admin'],
            ['name' => 'Admin', 'description' => 'مدير — إدارة المحتوى', 'is_system' => true]
        );
        Role::firstOrCreate(
            ['slug' => 'user'],
            ['name' => 'User', 'description' => 'طالب — تصفح ومشاهدة', 'is_system' => true]
        );

        // ===== صلاحيات المدير الأعلى =====
        foreach ([
            'manage_users', 'manage_roles', 'manage_permissions', 'manage_content',
            'manage_tutorials', 'manage_tools', 'manage_glossary', 'manage_achievements',
            'manage_study_rooms', 'manage_plans', 'view_dashboard',
        ] as $slug) {
            $permission = Permission::firstOrCreate(
                ['slug' => $slug],
                ['name' => str_replace('_', ' ', $slug), 'description' => null, 'module' => 'system', 'action' => 'manage']
            );
            DB::table('role_permissions')->updateOrInsert(
                ['role_id' => $superAdmin->id, 'permission_id' => $permission->id],
                ['created_at' => now(), 'updated_at' => now()]
            );
        }

        // ===== حساب Alaa =====
        User::updateOrCreate(
            ['email' => self::SUPER_ADMIN_EMAIL],
            [
                'role_id' => $superAdmin->id,
                'full_name' => 'Alaa',
                'password_hash' => Hash::make(self::SUPER_ADMIN_PASSWORD),
                'is_active' => true,
            ]
        );

        echo "SuperAdminSeeder: Alaa جاهز بكل الصلاحيات\n";
    }
}
