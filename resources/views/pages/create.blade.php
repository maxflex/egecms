@extends('app')
@section('controller', 'PagesForm')
@section('title', 'Добавление переменной')
@section('content')
<div class="row">
    <div class="col-sm-12">
        @include('pages._form')
        @include('modules.create_button')
    </div>
</div>
@stop
