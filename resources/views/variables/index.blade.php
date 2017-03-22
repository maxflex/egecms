@extends('app')
@section('title', 'Переменные')
@section('controller', 'VariablesIndex')

@section('title-right')
    {{ link_to_route('variables.create', 'добавить переменную') }}
@endsection

@section('content')
    <div ng-repeat="group in groups">
        <h4>@{{ group.title }}</h4>
        <table class="table droppable-table">
            <tr ng-repeat="variable in getVariables(group.id)" draggable="true"
                ng-dragstart="dragStart(variable.id)" ng-dragend='dragEnd()'>
                <td>
                    <a href='variables/@{{ variable.id }}/edit'>@{{ variable.name }}</a>
                </td>
                <td>
                    @{{ model.desc }}
                </td>
            </tr>
        </table>
    </div>
    <div ng-show='dnd.drag_id'>
        <h4>Новая группа</h4>
        <table class="table droppable-table">
            <tr ng-repeat="i in [1, 2, 3, 4]">
                <td>
                    –
                </td>
                <td>
                    –
                </td>
            </tr>
        </table>
    </div>
    @include('modules.pagination')
@stop
