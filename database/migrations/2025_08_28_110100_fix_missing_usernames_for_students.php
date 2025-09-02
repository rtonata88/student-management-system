<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class FixMissingUsernamesForStudents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Find all users with empty or null usernames who are students
        $usersWithoutUsernames = DB::table('users')
            ->leftJoin('students', 'users.id', '=', 'students.user_id')
            ->where('users.user_type', 'student')
            ->where(function($query) {
                $query->whereNull('users.username')
                      ->orWhere('users.username', '');
            })
            ->select('users.id as user_id', 'users.name', 'students.student_number')
            ->get();

        foreach ($usersWithoutUsernames as $user) {
            if ($user->student_number) {
                // Generate username from student number
                $username = 'STU' . $user->student_number;
                
                // Update the user record with the username
                DB::table('users')
                    ->where('id', $user->user_id)
                    ->update(['username' => $username]);
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
        // This migration is not easily reversible
    }
}
