<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::create(['name'=> 'Admin']);
        $tecnico = Role::create(['name'=> 'Tecnico']);

        $permission = Permission::create(['name' => 'home'])->syncRoles([$admin, $tecnico]);

        $permission = Permission::create(['name' => 'asignar.index'])->syncRoles([$admin, $tecnico]);
        //permission = Permission::create(['name' => 'asignar.create'])->syncRoles([$admin, $tecnico]);

        $permission = Permission::create(['name' => 'asignar_producto.index'])->assignRole($admin);
        $permission = Permission::create(['name' => 'asignar_producto.create'])->assignRole($admin);

        $permission = Permission::create(['name' => 'user.index'])->assignRole($admin);
        $permission = Permission::create(['name' => 'user.edit'])->assignRole($admin);
        $permission = Permission::create(['name' => 'user.update'])->assignRole($admin);

        $permission = Permission::create(['name' => 'roles.index'])->assignRole($admin);
        $permission = Permission::create(['name' => 'roles.create'])->assignRole($admin);
        $permission = Permission::create(['name' => 'roles.edit'])->assignRole($admin);
        $permission = Permission::create(['name' => 'roles.destroy'])->assignRole($admin);

        $permission = Permission::create(['name' => 'cliente.index'])->assignRole($admin);
        $permission = Permission::create(['name' => 'cliente.create'])->assignRole($admin);
        $permission = Permission::create(['name' => 'cliente.edit'])->assignRole($admin);
        $permission = Permission::create(['name' => 'cliente.destroy'])->assignRole($admin);

        $permission = Permission::create(['name' => 'producto.index'])->assignRole($admin);
        $permission = Permission::create(['name' => 'producto.create'])->assignRole($admin);
        $permission = Permission::create(['name' => 'producto.edit'])->assignRole($admin);
        $permission = Permission::create(['name' => 'producto.destroy'])->assignRole($admin);

        $permission = Permission::create(['name' => 'detalle_producto.index'])->assignRole($admin);
        $permission = Permission::create(['name' => 'detalle_producto.create'])->assignRole($admin);
        $permission = Permission::create(['name' => 'detalle_producto.edit'])->assignRole($admin);
        $permission = Permission::create(['name' => 'detalle_producto.destroy'])->assignRole($admin);

        $permission = Permission::create(['name' => 'tecnico.index'])->assignRole($admin);
        $permission = Permission::create(['name' => 'tecnico.create'])->assignRole($admin);
        $permission = Permission::create(['name' => 'tecnico.edit'])->assignRole($admin);
        $permission = Permission::create(['name' => 'tecnico.destroy'])->assignRole($admin);

        $permission = Permission::create(['name' => 'importexcel.index'])->assignRole($admin);
        $permission = Permission::create(['name' => 'impor_cliente.create'])->assignRole($admin);
        $permission = Permission::create(['name' => 'impor_producto.create'])->assignRole($admin);
        $permission = Permission::create(['name' => 'impor_detalle.create'])->assignRole($admin);

        /*
        $permission = Permission::create(['name' => 'cliente.index'])->assignRole($admin);
        $permission = Permission::create(['name' => 'cliente.create'])->assignRole($admin);
        $permission = Permission::create(['name' => 'cliente.edit'])->assignRole($admin);
        $permission = Permission::create(['name' => 'cliente.destroy'])->assignRole($admin);

        $permission = Permission::create(['name' => 'producto.index'])->assignRole($admin);
        $permission = Permission::create(['name' => 'producto.create'])->assignRole($admin);
        $permission = Permission::create(['name' => 'producto.edit'])->assignRole($admin);
        $permission = Permission::create(['name' => 'producto.destroy'])->assignRole($admin);
        */
    }
}
