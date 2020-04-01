<?php

namespace App\Console\Commands;

use App\Models\Tracking;
use Carbon\Carbon;
use Illuminate\Console\Command;

class TrackingStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tracking:expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update tracking status to expired';

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
     	 $this->line('Start updating tracking orders');
        $tracking = Tracking::active()->where('status','!=',Tracking::STATUS_EXPIERD)
					                  ->whereDate('expiry_date','<',Carbon::today()->toDateString())->chunk(100,function ($items){
					                  	foreach ($items as $item){
					                  		$item->update(['status'=>Tracking::STATUS_EXPIERD]);
															}
														});
			$this->line('DONE');
    }
}
