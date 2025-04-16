<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Notifications\LogReminder;
use Log;

class SendLogReminder extends Command
{
   
    protected $signature = 'reminder:log';
    protected $description = 'Send a weekly log reminder to all users';

    
    public function handle()
    {
        $users = User::all();
        foreach ($users as $user){
            $user->notify(new LogReminder());
        }
        $this->info('Log reminder sent to all users.');
    }
}
