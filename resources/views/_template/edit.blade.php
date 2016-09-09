@extends('app')
@section('title', 'Редактирование переменной')
@section('title-right')
    <span ng-click="FormService.delete($event)">удалить переменную</a>
@stop
@section('content')
@section('controller', 'VariablesForm')
<div class="row">
    <div class="col-sm-12">
        @include('variables._form')
        @include('modules.edit_button')
    </div>
</div>
@stop
