@extends('layouts.base')
@section('title','ログインページ')
@section('main')
<h1>ログインフォーム</h1>
<form method="post" action="">
  @csrf
  <div class="">
    <label id="login_id">ログインID:</label><br />
    <input id="login_id" name="login_id" type="text">
  </div>
  <div class="">
    <label id="mail">メール:</label><br />
    <input id="mail" name="mail" type="text">
  </div>
  <div class="">
  <input type="submit" value="送信">
  </div>
  <a href="{{$url}}">登録はこちらから</a>
</form>
@endsection