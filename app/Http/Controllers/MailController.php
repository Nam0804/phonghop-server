<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmailJob;

class MailController extends Controller
{
    protected function sendMail(): \Illuminate\Process\InvokedProcess
    {
//        $mytime = Carbon::now();
//        $meetingTimeInAdvance = Meeting::getTime();
//        if ($meetingTimeInAdvance == $mytime){
            $emailJob = new SendEmailJob();
            dispatch($emailJob);
            return \Illuminate\Support\Facades\Process::timeout(120)->start('php artisan queue:work');
//        }
    }
}
