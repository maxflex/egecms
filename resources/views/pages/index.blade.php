@extends('app')
@section('title', 'Разделы')
@section('controller', 'PagesIndex')

@section('title-right')
    {{ link_to_route('pages.export', 'экспорт') }}
    {{ link_to_route('pages.import', 'импорт', [], ['ng-click'=>'import($event)']) }}
    {{ link_to_route('pages.create', 'добавить раздел') }}
@endsection

@section('content')
    <div class="import-upload-container ng-hide">
        <input id="import-button" accept=".xls" type="file" nv-file-select uploader="uploader"/><br/>
    </div>

    <table class="table reverse-borders">
        <tbody ui-sortable='sortableOptions' ng-model="IndexService.page.data" >
            <tr ng-repeat="model in IndexService.page.data">
                <td>
                    <a href="pages/@{{ model.id }}/edit">@{{ model.keyphrase }}</a>
                </td>
                <td style="text-align: right">
                    <a href="{{ config('app.web-url') }}@{{ model.url }}" target="_blank">просмотреть страницу на сайте</a>
                </td>
            </tr>
        </tbody>
    </table>
    @include('modules.pagination')
@stop
