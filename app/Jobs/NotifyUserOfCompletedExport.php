<?php

namespace App\Jobs;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Notifications\AccountSummaryExportReady;

class NotifyUserOfCompletedExport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected $user;

    protected $filePath;

    protected $report_request;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user, $filePath, $report_request)
    {
        $this->user = $user;

        $this->filePath = $filePath;

        $this->report_request = $report_request;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if(!is_null($this->user)){
            foreach ($this->user->unreadNotifications as $notification) {
                $notification->markAsRead();
            }
        }
        

        $this->report_request->status = 'Complete';
        $this->report_request->save();

        $this->user->notify(new AccountSummaryExportReady($this->filePath));
    }
}
