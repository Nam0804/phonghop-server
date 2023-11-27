<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmailJob;
use App\Mail\SendMail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Nette\Utils\DateTime;
use Symfony\Component\Process\Process;

class MailController extends Controller
{
    protected function sendMail(Request $request)
    {
        $mytime = Carbon::now();
        $meetingTimeInAdvance = Meeting::getTime();
        if ($meetingTimeInAdvance == $mytime){
            $emailJob = new SendEmailJob();
            dispatch($emailJob);
            return \Illuminate\Support\Facades\Process::timeout(120)->start('php artisan queue:work');
        }
    }
}
