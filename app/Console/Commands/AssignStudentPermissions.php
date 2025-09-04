<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;

class AssignStudentPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'students:assign-permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign default permissions to all users with user_type = student';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Assigning default permissions to student users...');
        
        $studentUsers = User::where('user_type', 'student')->get();
        
        if ($studentUsers->isEmpty()) {
            $this->info('No student users found.');
            return;
        }
        
        $this->info("Found {$studentUsers->count()} student users.");
        
        $bar = $this->output->createProgressBar($studentUsers->count());
        $bar->start();
        
        foreach ($studentUsers as $user) {
            $user->assignDefaultStudentPermissions();
            $bar->advance();
        }
        
        $bar->finish();
        $this->info("\nDefault permissions assigned to all student users successfully!");
    }
}
