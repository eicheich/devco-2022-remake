<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UpdateDateOfBirthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::whereNull('date_of_birth')->get();

        foreach ($users as $user) {
            // Set default date of birth to 2000-01-01
            $user->date_of_birth = '2000-01-01';
            $user->save();

            echo "Updated user {$user->id} ({$user->email}) with default date of birth\n";
        }

        echo "\nTotal users updated: " . $users->count() . "\n";
    }
}
