@extends('layouts.base')
@section('title', '編集ページ')
@section('main')
<h1>編集ページ</h1>
<form method="post" action="/save/{{$b->id}}">
  @csrf
  @method('PATCH')
  <label>
  </label>
</form>
@endsection