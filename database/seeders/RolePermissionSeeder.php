<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Permissions
        $permissions = [
            'manage users',
            'view material',
            'create material',
            'edit material',
            'delete material',
            'view finance',
            'create finance',
            'edit finance',
            'delete finance',
            'approve pengajuan kas',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create Roles and Assign Permissions

        // 1. Super Admin (Abi) - All Access
        $superAdminRole = Role::firstOrCreate(['name' => 'Super Admin']);
        $superAdminRole->givePermissionTo(Permission::all());

        // 2. Admin - Material Management & Operational
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $adminRole->givePermissionTo([
            'view material',
            'create material',
            'edit material',
            'delete material',
            'view finance', // Can view but not edit sensitive finance
        ]);

        // 3. Kasir - Finance Management
        $kasirRole = Role::firstOrCreate(['name' => 'Kasir']);
        $kasirRole->givePermissionTo([
            'view finance',
            'create finance',
            'edit finance',
            'delete finance',
            'view material', // Read only for materials
        ]);

        // Create Default Users

        // Super Admin
        $superAdmin = User::firstOrCreate(
            ['email' => 'abi@lagoibay.com'],
            [
                'name' => 'Abi (Super Admin)',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );
        $superAdmin->assignRole($superAdminRole);

        // Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@lagoibay.com'],
            [
                'name' => 'Admin Operasional',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );
        $admin->assignRole($adminRole);

        // Kasir
        $kasir = User::firstOrCreate(
            ['email' => 'kasir@lagoibay.com'],
            [
                'name' => 'Staff Kasir',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );
        $kasir->assignRole($kasirRole);
    }
}
