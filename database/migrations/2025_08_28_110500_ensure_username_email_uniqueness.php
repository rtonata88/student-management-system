<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class EnsureUsernameEmailUniqueness extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // First, fix any duplicate usernames by appending numbers
        $this->fixDuplicateUsernames();
        
        // Then, fix any duplicate emails by appending numbers
        $this->fixDuplicateEmails();
        
        // Add unique constraints if they don't exist
        if (Schema::hasTable('users')) {
            // Check if username unique constraint exists
            $usernameIndexExists = DB::select("SHOW INDEX FROM users WHERE Key_name = 'users_username_unique'");
            if (empty($usernameIndexExists)) {
                Schema::table('users', function (Blueprint $table) {
                    $table->unique('username');
                });
            }
            
            // Check if email unique constraint exists
            $emailIndexExists = DB::select("SHOW INDEX FROM users WHERE Key_name = 'users_email_unique'");
            if (empty($emailIndexExists)) {
                Schema::table('users', function (Blueprint $table) {
                    $table->unique('email');
                });
            }
        }
    }

    /**
     * Fix duplicate usernames by appending numbers
     */
    private function fixDuplicateUsernames()
    {
        $duplicates = DB::select("
            SELECT username, COUNT(*) as count 
            FROM users 
            WHERE username IS NOT NULL AND username != '' 
            GROUP BY username 
            HAVING COUNT(*) > 1
        ");

        foreach ($duplicates as $duplicate) {
            $users = DB::table('users')
                ->where('username', $duplicate->username)
                ->orderBy('id')
                ->get();

            $counter = 1;
            foreach ($users as $index => $user) {
                if ($index > 0) { // Keep first one as is, modify others
                    $newUsername = $duplicate->username . $counter;
                    
                    // Ensure the new username is unique
                    while (DB::table('users')->where('username', $newUsername)->exists()) {
                        $counter++;
                        $newUsername = $duplicate->username . $counter;
                    }
                    
                    DB::table('users')
                        ->where('id', $user->id)
                        ->update(['username' => $newUsername]);
                    
                    $counter++;
                }
            }
        }
    }

    /**
     * Fix duplicate emails by appending numbers
     */
    private function fixDuplicateEmails()
    {
        $duplicates = DB::select("
            SELECT email, COUNT(*) as count 
            FROM users 
            WHERE email IS NOT NULL AND email != '' 
            GROUP BY email 
            HAVING COUNT(*) > 1
        ");

        foreach ($duplicates as $duplicate) {
            $users = DB::table('users')
                ->where('email', $duplicate->email)
                ->orderBy('id')
                ->get();

            $counter = 1;
            foreach ($users as $index => $user) {
                if ($index > 0) { // Keep first one as is, modify others
                    $emailParts = explode('@', $duplicate->email);
                    $newEmail = $emailParts[0] . $counter . '@' . $emailParts[1];
                    
                    // Ensure the new email is unique
                    while (DB::table('users')->where('email', $newEmail)->exists()) {
                        $counter++;
                        $newEmail = $emailParts[0] . $counter . '@' . $emailParts[1];
                    }
                    
                    DB::table('users')
                        ->where('id', $user->id)
                        ->update(['email' => $newEmail]);
                    
                    $counter++;
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropUnique(['username']);
                $table->dropUnique(['email']);
            });
        }
    }
}
