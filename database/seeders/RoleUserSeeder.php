<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class RoleUserSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run()
  {
    // Define roles
    $roles = ['admin', 'staff'];

    // Create roles
    foreach ($roles as $roleName) {
      Role::firstOrCreate(['name' => $roleName]);
    }

    // Create users and assign roles
    $users = [
      [
        'name' => 'Admin User',
        'email' => 'admin@mail.com',
        'password' => Hash::make('password'),
        'role' => 'admin',
      ],
      [
        'name' => 'Staff User',
        'email' => 'staff@mail.com',
        'password' => Hash::make('password'),
        'role' => 'staff',
      ],
    ];

    foreach ($users as $userData) {
      $user = User::firstOrCreate(
        ['email' => $userData['email']],
        [
          'name' => $userData['name'],
          'password' => $userData['password'],
        ]
      );

      // Assign role to the user
      $user->assignRole($userData['role']);
    }
  }
}
