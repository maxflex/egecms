@extends('app')
@section('title', 'Редактирование страницы')
@section('title-center')
    <span ng-click="FormService.edit()">сохранить</span>
@stop
@section('title-right')
    <a href="{{ config('app.web-url') }}@{{ FormService.model.url }}" target="_blank">просмотреть страницу на сайте</a>
    <span ng-click="FormService.delete($event)">удалить раздел</a>
@stop
@section('content')
@section('controller', 'PagesForm')
<div class="row">
    <div class="col-sm-12">
        @include('pages._form')
    </div>
</div>
@stop
