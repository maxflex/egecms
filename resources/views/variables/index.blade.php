@extends('app')
@section('title', 'Переменные')
@section('controller', 'VariablesIndex')

@section('title-right')
    {{ link_to_route('variables.create', 'добавить переменную') }}
@endsection

@section('content')
    <table class="table">
        <tr ng-repeat="model in IndexService.page.data">
            <td>
                <a href='variables/@{{ model.id }}/edit'>@{{ model.name }}</a>
            </td>
            <td>
                @{{ model.desc }}
            </td>
        </tr>
    </table>
    @include('modules.pagination')
@stop
