<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmailJob;

class MailController extends Controller
{
    protected function sendMail():void
    {
//        $mytime = Carbon::now();
//        $meetingTimeInAdvance = Meeting::getTime();
//        if ($meetingTimeInAdvance == $mytime){
            $emailJob = new SendEmailJob();
            dispatch($emailJob);
//        }
    }
}
