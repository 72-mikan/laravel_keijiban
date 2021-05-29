@extends('layouts.base')
@section('title', '掲示板ページ')
@section('main')
<h1>{{$title}}</h1>
<hr />
<p>こんにちは、〇〇〇さん ID:〇〇〇</p>
@if($flag == 0)
<form method="post" action="/keijiban/post" enctype="multipart/form-data">
@elseif($flag == 1)
<form method="post" action="/save/{{$post->id}}" enctype="multipart/form-data">
@endif

  @csrf
  @if($flag == 1)
    @method('PATCH')
  @endif
  <div class="">
    <label id="post_name">投稿者名:</label><br />
    @if($flag == 0)
    <input id="post_name" name="post_name" type="text" value="{{old('post_name', '')}}" />
    @else
    <input id="post_name" name="post_name" type="text" value="{{old('post_name', $post->post_name)}}">
    @endif
  </div>
  <div class="">
    <label id="comment">コメント:</label><br />
    @if($flag == 0)
    <input id="comment" name="comment" type="text" value="{{old('comment', '')}}" />
    @else
    <input id="comment" name="comment" type="text" value="{{old('comment', $post->comment)}}" >
    @endif
  </div>
  <div class="">
    <label id="pass">パスワード:</label><br />
    @if($flag == 0)
    <input id="pass" name="pass" type="password" value="{{old('pass', '')}}" />
    @else
    <input id="pass" name="pass" type="password" value="{{old('pass', '')}}">
    @endif
  </div>
  <div class="">
    <label id="data">画像・動画:</label><br />
    <input id="upfile" name="upfile" type="file">
  </div>
  <input type="submit" value="{{$type}}"><br />
  <p>※画像ファイルならimg,ipg,png、動画ファイルならmp4の形式でアップロードしてください。</p>
  <p>※編集時、パスワードには最初に設定したパスワードを入力してください。</p>
</form>

<?php $counter = 0; ?>

@foreach($posts as $post)
  <hr />
  <table>
    <th>投稿番号</th>
    <td><?php echo ++$counter; ?></td>
  </table>
  <table>
    <th>投稿者：</th>
    <td>{{$post->post_name}}</td>
  </table>
  <table>
    <th>コメント：</th>
    <td>{{$post->comment}}</td>
  </table>
  @if($post->file != null)
    @if($post->file->file_type == 'gif' || $post->file->file_type == 'jpg' || $post->file->file_type == 'png')
      <img src="{{asset('storage/'.$post->file->file_pass)}}" width="500" height="500">
    @elseif($post->file->file_type == 'gif')
      <video src="{{asset('storage/'.$post->file->file_pass)}}"  alt="アップロードファイル" controls></video>
    @endif
  @endif
  <table>
    <th>投稿日：</th>
    <td>{{$post->post_time}}</td>
  </table>
  <table>
    <td>
      <a href="/save/{{$post->id}}/edit">編集</a> |
      <a href="/save/{{$post->id}}">削除</a>
    </td>
  </table>
@endforeach

@endsection