<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Limpiar tablas existentes
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('role_has_permissions')->truncate();
        DB::table('model_has_roles')->truncate();
        DB::table('model_has_permissions')->truncate();
        DB::table('roles')->truncate();
        DB::table('permissions')->truncate();
        DB::table('users')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Create permissions
        Permission::create(['name' => 'edit posts']);
        Permission::create(['name' => 'delete posts']);
        Permission::create(['name' => 'publish posts']);
        Permission::create(['name' => 'unpublish posts']);

        // Create roles and assign permissions
        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo(Permission::all());

        $designer = Role::create(['name' => 'designer']);
        $designer->givePermissionTo([
            'edit posts',
            'publish posts',
            'unpublish posts'
        ]);

        // Crear usuarios
        $adminUser = User::create([
            'name' => 'Administrador',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);
        $adminUser->assignRole('admin');

        $designerUser = User::create([
            'name' => 'Diseñador',
            'email' => 'designer@example.com',
            'password' => Hash::make('password'),
        ]);
        $designerUser->assignRole('designer');

        $normalUser = User::create([
            'name' => 'Usuario Normal',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
        ]);
    }
}
