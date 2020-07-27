<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Traits\ConnectionRedis;


class sendEmail extends Command
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
        for ($i = 0; $i < sizeof($emails); $i++) {
            Mail::to($emails[$i])->send(new \App\Mail\SendEmail());
            $redis->zAdd('email:success','25',$emails[$i]);
            $redis->zRem('emails',$emails[$i]);
        }

        $redis->close();
    }
}
