<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UpdateUsernameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::whereNull('username')->orWhere('username', '')->get();

        foreach ($users as $user) {
            $baseUsername = 'user_' . $user->id;
            $username = $baseUsername;
            $counter = 1;

            // Make sure username is unique
            while (User::where('username', $username)->where('id', '!=', $user->id)->exists()) {
                $username = $baseUsername . '_' . $counter;
                $counter++;
            }

            $user->username = $username;
            $user->save();

            echo "Updated user {$user->id} ({$user->email}) to username: {$username}\n";
        }

        echo "\nTotal users updated: " . $users->count() . "\n";
    }
}
