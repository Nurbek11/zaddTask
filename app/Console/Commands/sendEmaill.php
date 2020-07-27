<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Traits\ConnectionRedis;
use App\Mail\SendEmail;


class sendEmaill extends Command
{
    use ConnectionRedis;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:sendEmail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'sending an email';

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
     * @return int
     */
    public function handle()
    {
        $redis = $this->getRedis();
        $emails = $redis->zRange('emails', '0', '-1');
        foreach ($emails as $email){
            Mail::to($email)->send(new SendEmail());
            $redis->zAdd('email:success','25',$email);
            $redis->zRem('emails',$email);
        }
        $redis->close();
    }
}
