<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SyncStudentsWithUsersAndFixUserTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 1. Update jhaitange@gmail.com to student type (registered via signup)
        DB::table('users')
            ->where('email', 'jhaitange@gmail.com')
            ->update(['user_type' => 'student']);

        // 2. Get all students that don't have corresponding user accounts
        $students = DB::table('students')
            ->leftJoin('users', 'students.user_id', '=', 'users.id')
            ->whereNull('users.id')
            ->select('students.*')
            ->get();

        foreach ($students as $student) {
            // Generate unique username from student number
            $username = 'STU' . $student->student_number;
            
            // Create user account for each student
            $userId = DB::table('users')->insertGetId([
                'name' => trim($student->student_names . ' ' . $student->surname),
                'username' => $username,
                'email' => $student->contact_email ?: $student->student_number . '@student.local',
                'password' => Hash::make('password123'), // Default password
                'user_type' => 'student',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Update student record with user_id
            DB::table('students')
                ->where('id', $student->id)
                ->update(['user_id' => $userId]);
        }

        // 3. Update existing students that have user accounts to ensure user_type is student
        DB::table('users')
            ->join('students', 'users.id', '=', 'students.user_id')
            ->where('users.user_type', '!=', 'student')
            ->update(['users.user_type' => 'student']);

        // 4. Ensure all users created through registration (not via Users.Create) are students
        // This identifies users likely created via registration by checking if they have student records
        DB::table('users')
            ->join('students', 'users.id', '=', 'students.user_id')
            ->update(['users.user_type' => 'student']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // This migration is not easily reversible as it creates user accounts
        // and updates user types based on business logic
    }
}
