<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class LayoutsController extends Controller
{
    public function login()
    {
        $data = [
            'url' => 'touroku'
        ];
        return view('login.login', $data);
    }

    public function comfirm(Request $req)
    {
        $param = [
            'user_id' => $req->login_id,
        ];
        $users = DB::select('select * from users where user_id = :user_id', $param);

        if(empty($users)){
            return 'ログインIDが一致するものがありません。';
        }

        foreach($users as $user){
            if(($user->user_id == $req->login_id) && ($user->mail == $req->mail) &&($user->permit == 1)){
                return redirect('keijiban/form');
            } else {
                return 'パスワード不一致';
            }
        }
    }

    public function touroku()
    {
        return view('login.touroku');
    }
    
    public function register(Request $req)
    {
        $create_id = uniqid();

        $user = new User();
        $user->user_id = $create_id;
        $user->name = $req->name;
        $user->pass = $req->pass;
        $user->mail = $req->mail;
        $user->permit = false;
        
        $user->save();

        return redirect('layouts/complete/'.$create_id);
    }

    public function complete($user_id)
    {
        $param = [
            'user_id' => $user_id,
        ];
        $users = DB::select('select * from users where user_id = :user_id', $param);

        foreach($users as $user){
            $user_id = $user->user_id;
            //本登録用urlの取得
            if(empty($_SERVER["HTTP"])){
                $url = "http://".$_SERVER["HTTP_HOST"]."/touroku.php/".$user_id;
            } else {
                $url = "https://".$_SERVER["HTTP_HOST"]."/kadai4_3/touroku.php"."?product=".$result;
            }
            mb_language("japanese");
            mb_internal_encoding("UTF-8");
            
            $to = $user->mail;
            
            $header= "shinzi7280@gmail.com";
            
            $subject = "ユーザー登録";
            $body = "以下URLから24時間以内に登録を行ってください。\n";
            $body.= $url."\n";
            $body.= "24時間を過ぎた場合、仮登録は自動で登録が解除されます。\n";
            
            $r = mb_send_mail($to, $subject, $body, $header);
            if (!$r) {
                echo "失敗";
            }
        }

        $data = [
            'url' => 'login'
        ];
        return view('login.complete', $data);
    }
}
