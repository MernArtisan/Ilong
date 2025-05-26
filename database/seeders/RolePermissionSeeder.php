<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Create roles
        $adminRole = Role::create(['name' => 'admin', 'description' => 'Administrator role']);
        $sellerRole = Role::create(['name' => 'seller', 'description' => 'Seller role']);
        $buyerRole = Role::create(['name' => 'buyer', 'description' => 'Buyer role']);

        // Create permissions
        $permissions = [
            'create_product',
            'edit_product',
            'delete_product',
            'view_orders',
            'manage_users'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Assign permissions to roles
        $adminRole->permissions()->attach(Permission::all());
        $sellerRole->permissions()->attach(Permission::whereIn('name', ['create_product', 'edit_product', 'view_orders'])->get());
    }
}
