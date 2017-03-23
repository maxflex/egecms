@extends('app')
@section('title', 'Переменные')
@section('controller', 'VariablesIndex')

@section('title-right')
    {{ link_to_route('variables.create', 'добавить переменную') }}
@endsection

@section('content')
    <span ng-init='groups = {{ \App\Models\VariableGroup::getIds() }}'></span>
    <div ng-repeat="group in groups">
        <h4>@{{ group.title }}</h4>
        <div class='droppable-table' ondragover="allowDrop(event)"
            ng-dragenter="dnd.over = group.id" ng-dragleave="dnd.over = undefined" ng-drop="drop(group.id)"
            ng-class="{'over': dnd.over === group.id && dnd.over != dnd.variable_id}">
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
    </div>
    <div>
    <div ng-show='dnd.variable_id > 0'>
        <h4>{{ \App\Models\VariableGroup::DEFAULT_TITLE }}</h4>
        <div class='droppable-table' ondragover="allowDrop(event)"
            ng-dragenter="dnd.over = null" ng-dragleave="dnd.over = undefined" ng-drop="drop(null)"
            ng-class="{'over': dnd.over === null}">
            <table class="table">
                <tr ng-repeat="i in [1, 2, 3, 4]">
                    <td>
                        <div class='fake-info'></div>
                    </td>
                    <td>
                        <div class='fake-info' style='width: 50px'></div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    @include('modules.pagination')
@stop
