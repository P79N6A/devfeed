<?php

namespace Fedn\Http\Controllers\Admin;

use Fedn\Http\Controllers\Controller;
use Fedn\Mail\SendSpecials;
use Illuminate\Support\Facades\Mail;

use Illuminate\Http\Request;

use Fedn\Models\Special;
use Fedn\Models\Article;


class MailController extends Controller
{
    public function send(Request $request)
    {
        $data = $request->all();
        $specialId = $data['id'];

        $special = Special::find($specialId);
        if(!$special) {
            throw new ModelNotFoundException('专题不存在！');
        }

        $articles = Article::find(explode(',',$special->article_list));

//        Mail::send(new sendSpecial($special,$articles),['special'=>$special,'articles'=>$articles],function($message) use ($special) {
        $to = [$special->accept_email];
//            $to = ['miyatang@tencent.com','172681735@qq.com','tangfen19149@163.com'];
//            $message ->to($to)->subject($special->title);
//        });
        Mail::to($to)->send(new SendSpecials($special,$articles));

        if(count(Mail::failures()) == 0){
            //将专题的发送标志置为1
            $special->flag_send = 1;
            $special->save();
            $returnObj = array(
                'errcode' => 0,
                'errmsg' => '发送成功'
            );
        }else{
            $returnObj = array(
                'errcode' => -1,
                'errmsg' => '发送失败，请稍后重试',
            );
        }
        return $returnObj;
    }
}
