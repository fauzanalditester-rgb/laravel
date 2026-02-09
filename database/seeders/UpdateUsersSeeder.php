<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UpdateUsersSeeder extends Seeder
{
    public function run()
    {
        // 1. Update Super Admin
        $superAdmin = User::where('email', 'abi@lagoibay.com')->first();
        if ($superAdmin) {
            $superAdmin->update([
                'email' => 'abi@erp.com',
                'password' => Hash::make('password'),
            ]);
            $this->command->info("Updated Super Admin: abi@erp.com / password");
        } else {
            // Check if already updated? or recreate
            $superAdmin = User::firstOrCreate(
                ['email' => 'abi@erp.com'],
                ['name' => 'Abi (Super Admin)', 'password' => Hash::make('password')]
            );
            // Assign role logic
            if (method_exists($superAdmin, 'assignRole')) {
                $superAdmin->assignRole('Super Admin');
            }
            $this->command->info("Ensured Super Admin: abi@erp.com / password");
        }

        // 2. Update Admin
        $admin = User::where('email', 'admin@lagoibay.com')->first();
        if ($admin) {
            $admin->update([
                'email' => 'admin@erp.com',
                'password' => Hash::make('password'),
            ]);
            $this->command->info("Updated Admin: admin@erp.com / password");
        } else {
            $admin = User::firstOrCreate(
                ['email' => 'admin@erp.com'],
                ['name' => 'Admin Operasional', 'password' => Hash::make('password')]
            );
            if (method_exists($admin, 'assignRole')) {
                $admin->assignRole('Admin');
            }
            $this->command->info("Ensured Admin: admin@erp.com / password");
        }

        // 3. Update Kasir
        $kasir = User::where('email', 'kasir@lagoibay.com')->first();
        if ($kasir) {
            $kasir->update([
                'email' => 'kasir@erp.com',
                'password' => Hash::make('password'),
            ]);
            $this->command->info("Updated Kasir: kasir@erp.com / password");
        } else {
            $kasir = User::firstOrCreate(
                ['email' => 'kasir@erp.com'],
                ['name' => 'Staff Kasir', 'password' => Hash::make('password')]
            );
            if (method_exists($kasir, 'assignRole')) {
                $kasir->assignRole('Kasir');
            }
            $this->command->info("Ensured Kasir: kasir@erp.com / password");
        }
    }
}
