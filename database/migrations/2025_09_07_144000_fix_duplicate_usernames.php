<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class FixDuplicateUsernames extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Find and fix duplicate usernames before the sync migration runs
        $duplicateUsernames = DB::table('users')
            ->select('username', DB::raw('COUNT(*) as count'))
            ->groupBy('username')
            ->having('count', '>', 1)
            ->get();

        foreach ($duplicateUsernames as $duplicate) {
            $users = DB::table('users')
                ->where('username', $duplicate->username)
                ->orderBy('id')
                ->get();

            // Keep the first user with original username, modify others
            $counter = 1;
            foreach ($users as $index => $user) {
                if ($index > 0) { // Skip the first user
                    $newUsername = $duplicate->username . '_' . $counter;
                    
                    // Ensure the new username is also unique
                    while (DB::table('users')->where('username', $newUsername)->exists()) {
                        $counter++;
                        $newUsername = $duplicate->username . '_' . $counter;
                    }
                    
                    DB::table('users')
                        ->where('id', $user->id)
                        ->update(['username' => $newUsername]);
                    
                    $counter++;
                }
            }
        }

        // Now handle the specific case from the sync migration
        // Check if STU202327586 already exists and handle it
        $existingUser = DB::table('users')->where('username', 'STU202327586')->first();
        if ($existingUser) {
            // Find a student that might be trying to get this username
            $student = DB::table('students')->where('student_number', '202327586')->first();
            if ($student && !$student->user_id) {
                // Generate a unique username for this student
                $counter = 1;
                $newUsername = 'STU202327586_' . $counter;
                while (DB::table('users')->where('username', $newUsername)->exists()) {
                    $counter++;
                    $newUsername = 'STU202327586_' . $counter;
                }
                
                // Update the existing user to use the new username
                DB::table('users')
                    ->where('username', 'STU202327586')
                    ->where('id', '!=', $student->user_id ?? 0)
                    ->update(['username' => $newUsername]);
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
        // This migration cleanup is not easily reversible
    }
}
