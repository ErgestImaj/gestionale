<?php

namespace App\Console\Commands;

use App\Models\Structure;
use App\Models\User;
use App\Models\UserGroups;
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
			  $this->line('Start fixing structure permissions');
			  Structure::chunk(100,function ($structures){
			  	foreach ($structures as $structure):
						if ($structure->type == Structure::TYPE_PARTNER){
							$user = 	$structure->owner;
							$user->roles()->sync(UserGroups::where('name', User::PARTNER)->firstOrFail()->id);
						}elseif ($structure->type == Structure::TYPE_MASTER){
							$user = 	$structure->owner;
							if ($user){
								$user->roles()->sync(UserGroups::where('name', User::MASTER)->firstOrFail()->id);
							}

						}elseif ($structure->type == Structure::TYPE_AFFILIATE){
							$user = 	$structure->owner;
							if ($user){
								$user->roles()->sync(UserGroups::where('name', User::AFFILIATI)->firstOrFail()->id);
							}
						}
					endforeach;
				});
			  $this->line('DONE');
    }
}
