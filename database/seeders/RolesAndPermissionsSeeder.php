<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Crear roles
        $superAdmin = Role::create(['name' => 'Superadministrador']);
        $comercial = Role::create(['name' => 'Comercial']);
        $admin = Role::create(['name' => 'Administrador']);

        // Crear permisos
        $viewAny = Permission::create(['name' => 'view any record']);
        $view = Permission::create(['name' => 'view record']);
        $create = Permission::create(['name' => 'create record']);
        $edit = Permission::create(['name' => 'edit record']);
        $delete = Permission::create(['name' => 'delete record']);

        // Asignar permisos a los roles
        $superAdmin->givePermissionTo([$viewAny, $view, $create, $edit, $delete]);
        $comercial->givePermissionTo([$viewAny, $view]);
        $admin->givePermissionTo([$viewAny, $view, $create, $edit, $delete]);
    }
}
