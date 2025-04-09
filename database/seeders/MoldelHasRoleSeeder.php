<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MoldelHasRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::findOrFail(1);
        $user->assignRole('Superadministrador');
        /*$users = User::findOrFail(1);
        foreach($users as $user){
            $user->assignRole('Superadministrador');
        }*/
    }
}
