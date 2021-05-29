<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Post;
use App\Models\File;

class SaveController extends Controller
{
    public function edit($id)
    {
        $data = [
            'post' => Post::findOrFail($id),
            'title' => '掲示板(編集)',
            'flag' => 1,
            'type' => '編集',
            'posts' => Post::all(),
        ];
        return view('keijiban.form', $data);
    }

    public function update(Request $req, $id)
    {
        if(($req->post_name == null) || ($req->comment == null) || ($req->pass == null)){
            return '投稿者名またはコメント、パスワードが無記名です。';
        }

        //データベースの編集(画像動画なし)関数
        function upload_judge($post_name, $comment, $id)
        {
            //postsテーブル編集
            $post = Post::find($id);
            $post->post_name = $post_name;
            $post->comment = $comment;
            $post->post_time = date("Y/m/d H:i:s", time());
            $post->update();

            //fileテーブル削除
            $post = Post::findOrFail($id);
            if(!empty($post->file->file_pass)){
                unlink('storage/'.$post->file->file_pass);
                $post->file->delete();
            }
        }

        //データベースへの保存(画像動画あり)関数
        function upload_data($post_name, $comment, $file_pass, $file_type, $id)
        {
            $post = Post::find($id);
            //修正必要あり
            $post->user_id = 1;
            $post->post_name = $post_name;
            $post->comment = $comment;
            $post->post_time = date("Y/m/d H:i:s", time());
            $post->update();
            //filesデータベースへ
            if(!empty($post->file->file_pass) && !empty($post->file->file_type)){
                //上書きファイルの削除
                if(!empty($post->file->file_pass)){
                    unlink('storage/'.$post->file->file_pass);
                }
                $post->file->file_pass = $file_pass;
                $post->file->file_type = $file_type;
                $post->file->update();
            } else {
                $file = new File();
                $file->post_id = $id;
                $file->file_pass = $file_pass;
                $file->file_type = $file_type;
                $file->save();
            }
        }

        $post = Post::find($id);
        //パスワード比較
        if($post->pass == $req->pass){
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
                        $req->file('upfile')->storeAs('images', $name.".".$extension, 'public');
                    } else if($extension == 'mp4') {
                        //オリジナルのファイル名を取得
                        $name = uniqid();
                        $save_file = "videos/".$name.".".$extension;
                        
                        //アップロードファイルを保存
                        $req->file('upfile')->storeAs('videos', $name.".".$extension, 'public');
                    }
                    upload_data($req->post_name, $req->comment, $save_file, $extension, $id);
                } else {
                    return 'ファイルのタイプが違います。';
                }
            } else {
                upload_judge($req->post_name, $req->comment, $id);
            }
        } else {
            return 'パスワードが違います。';
        }
        return redirect('keijiban/form');
    }

    public function show($id)
    {
        $data = [
            'post' => Post::findOrFail($id)
        ];
        return view('save.show', $data);
    }

    public function delete($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        if(!empty($post->file->file_pass)){
            unlink('storage/'.$post->file->file_pass);
            $post->file->delete();
        }
        
        return redirect('keijiban/form');
    }
}
