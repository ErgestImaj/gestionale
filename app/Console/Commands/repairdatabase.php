<?php

namespace App\Console\Commands;

use App\Models\UsersInfo;
use Illuminate\Console\Command;

class repairdatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix database data';

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
        $this->line('Start updating fcf_users_userinfo');
         UsersInfo::where('lrn_user','>',1)->chunk(100,function ($userinfos){
					 foreach ($userinfos as $userinfo) {
						 $userinfo->update(['lrn_user'=>1]);
         		}
				 });
        $this->line('DONE');
    }
}
