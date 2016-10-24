@extends('app')
@section('title', 'Тэги')
@section('controller', 'TagsIndex')

@section('title-right')
    <span ng-click='ExportService.exportDialog()'>экспорт</span>
    {{ link_to_route('pages.import', 'импорт', [], ['ng-click'=>'ExportService.import($event)']) }}
    {{ link_to_route('tags.create', 'добавить тэг') }}
@endsection

@section('content')
    <table class="table">
        <tr ng-repeat="model in IndexService.page.data">
            <td>
                <a href='tags/@{{ model.id }}/edit'>@{{ model.text }}</a>
            </td>
        </tr>
    </table>
    <pagination style="margin-top: 30px"
        ng-hide='IndexService.page.last_page <= 1'
        ng-model="IndexService.current_page"
        ng-change="IndexService.pageChanged()"
        total-items="IndexService.page.total"
        max-size="IndexService.max_size"
        items-per-page="IndexService.page.per_page"
        first-text="«"
        last-text="»"
        previous-text="«"
        next-text="»"
    ></pagination>
    {{-- @include('modules.pagination') --}}
    @include('modules._export_dialog')
@stop
