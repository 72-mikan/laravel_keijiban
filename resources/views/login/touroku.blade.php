@extends('layouts.base')
@section('title','登録ページ')
@section('main')
<h1>登録ページ</h1>
<form method="post" action="/layouts/register">
  @csrf
  <div class="">
    <label id="name">名前:</label><br />
    <input id="name" name="name" type="text" value="{{old('name')}}">
  </div>
  <div class="">
    <label id="mail">メールアドレス:</label><br />
    <input id="mail" name="mail" type="text" value="{{old('mail')}}">
  </div>
  <div class="">
    <label id="pass">パスワード:</label><br />
    <input id="pass" name="pass" type="text" value="{{old('pass')}}">
  </div>
  <div class="">
    <input type="submit" value="送信">
  </div>
</form>
@endsection