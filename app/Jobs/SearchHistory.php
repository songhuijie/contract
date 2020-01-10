<?php

namespace App\Jobs;

use App\Libraries\Lib_make;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class SearchHistory implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    protected  $user_id;
    protected  $data;
    public function __construct($user_id,$data)
    {
        //
        $this->user_id = $user_id;
        $this->data    = $data;
    }



    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // 如果参试大于三次
        if ($this->attempts() > 3) {
            Log::info($this->user_id.'尝试过多');
        }else{

            Lib_make::HandleSearchHistory($this->user_id,$this->data);

        }

    }


    /**
     * 处理一个失败的任务
     *
     * @return void
     */
    public function failed()
    {
        Log::error($this->user_id.'队列任务执行失败'."\n".date('Y-m-d H:i:s'));
    }
}
