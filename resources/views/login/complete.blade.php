@extends('layouts.base')
@section('title','登録完了ページ')
@section('main')
<h1>登録が完了しました。</h1>
<p>メール受け取り後、本登録を行ってください。</p>
<a href="{{$url}}">ログインページに戻る。</a>
@endsection