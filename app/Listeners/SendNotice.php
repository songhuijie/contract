<?php

namespace App\Listeners;

use App\Events\Notice;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendNotice
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Notice  $event
     * @return void
     */
    public function handle(Notice $event)
    {
        //
        $user_id = $event->user_id;
        $message = $event->message;
        $type = $event->type;

        $title = '';
        $content = '';
        switch ($type){
            case 1:
                $date = $message['date'];
                $enterprise = $message['enterprise'];
                $signatory = $message['signatory'];

                $title = $signatory.'已签字';
                $content = "于{$date}同{$enterprise}拟定的合同{$signatory}已签字,发送至您的邮箱。请注意查收,及时回复！";
                break;
            case 2:
                $title = '身份认证审核通过';
                $content = '您的身份认证已经审核通过！';
                break;
            case 3:

                break;
            default:
                break;
        }

        $notice = new \App\Models\Notice();
        $notice_data = [
            'user_id'=>$user_id,
            'title'=>$title,
            'content'=>$content,
        ];
        $notice->insert($notice_data);
    }
}
