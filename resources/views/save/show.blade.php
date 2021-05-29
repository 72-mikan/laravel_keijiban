@extends('layouts.base')
@section('title', '削除ページ')
@section('main')
<h1>以下の内容が削除内容です。</h1>
<p>本当に削除してもよろしいですか？</p>
<form method="post" action="/save/{{$post->id}}">
  @csrf
  @method('DELETE')
  <div class="">
    <span id="post_name">投稿者名:</span>
    {{$post->post_name}}
  </div>
    <span id="comment">コメント:</span>
    {{$post->comment}}
  </div>
  <div class="">
    <input type="submit" value="削除" />
    <a href="../keijiban/form">戻る</a>
  </div>
</form>
@endsection