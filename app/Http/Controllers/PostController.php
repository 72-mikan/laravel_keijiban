<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\File;

class PostController extends Controller
{
    public function form()
    {
        $data = [
            'title' => '掲示板',
            'flag' => 0,
            'type' => '投稿',
            'posts' => Post::all(),

        ];
        return view('keijiban.form', $data);
    }

    public function post(Request $req)
    {
        //初期値
        $image = false;
        $video = false;

        //アップロード部分
        function upload_judge($post_name, $comment, $pass, $file_pass, $file_type)
        {
            if(($post_name == null) || ($comment == null) || ($pass == null)){
                return '投稿者名またはコメント、パスワードが無記名です。';
            } else {
                $post = new Post();
                //修正必要あり
                $post->user_id = 1;
                $post->post_name = $post_name;
                $post->comment = $comment;
                $post->pass = $pass;
                $post->post_time = date("Y/m/d H:i:s", time());
                $post->save();
                //filesデータベースへ
                if($file_pass != null){
                    $file = new File();
                    $file->post_id = $post->id;
                    $file->file_pass = $file_pass;
                    $file->file_type = $file_type;
                    $file->save();
                }
            }
        }

        //ファイルが指定されているかの判定
        if($req->hasFile('upfile')) {
            //ファイルの取得
            $file = $req->upfile;

            //ファイルが正しくアップロードされているか
            if(!$file->isValid()) {
                return 'アップロードに失敗しました。';
            }

            //動画・画像ファイルの場合分け
            //ファイルのタイプの取得
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime_type = finfo_file($finfo, $file);
            finfo_close($finfo);

            $filetype_array = array(
                'gif' => 'image/gif',
                'jpg' => 'image/jpeg',
                'png' => 'image/png',
                'mp4' => 'video/mp4',
            );

            if($extension = array_search($mime_type, $filetype_array, true)) {
                if($extension == 'gif' || $extension == 'jpg' || $extension == 'png') {
                    //オリジナルのファイル名を取得
                    $name = uniqid();
                    $save_file = "images/".$name.".".$extension;

                    //アップロードファイルを保存
                    //$file->storeAs('image', $name.".".$extension);
                    //$file = $req->file('avatar')->store('image');
                    $req->file('upfile')->storeAs('images', $name.".".$extension, 'public');
                    //
                    upload_judge($req->post_name, $req->comment, $req->pass, $save_file, $extension);
                } else if($extension == 'mp4') {
                    //オリジナルのファイル名を取得
                    $name = uniqid();
                    $save_file = "videos/".$name.".".$extension;
                    
                    //アップロードファイルを保存
                    //$file->storeAs('video', $save_file);
                    $req->file('upfile')->storeAs('videos', $name.".".$extension, 'public');
                    //
                    upload_judge($req->post_name, $req->comment, $req->pass, $save_file, $extension);
                } 
            } else {
                return 'ファイルのタイプが違います。';
            }
        } else {
            //
            $save_file = null;
            $extension = null;
            upload_judge($req->post_name, $req->comment, $req->pass, $save_file, $extension);
        }

        return redirect('keijiban/form');
    }

}
