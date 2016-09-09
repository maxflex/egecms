<div class="row mbs">
    <div class="col-sm-12">
        @include('modules.input', ['title' => 'ключевая фраза', 'model' => 'keyphrase'])
    </div>
</div>
<div class="row mbs">
    <div class="col-sm-6">
        @include('modules.input', ['title' => 'отображаемый URL', 'model' => 'url'])
    </div>
    <div class="col-sm-6">
        @include('modules.input', ['title' => 'title', 'model' => 'title'])
    </div>
</div>
<div class="row mbs">
    <div class="col-sm-12">
        @include('modules.input', ['title' => 'h1', 'model' => 'h1'])
    </div>
</div>
<div class="serp">
    <div class="row mb">
        <div class="col-sm-3">
            <label class="no-margin-bottom">предметы</label>
            <ng-multi object='{{ fact('subjects', 'name') }}' label='name' model='FormService.model.subjects' none-text='выберите предметы'></ng-multi>
        </div>
        <div class="col-sm-3">
            <label class="no-margin-bottom">выезд</label>
            <ng-select model='FormService.model.place' object="{{ fact('places', 'title') }}" label='title' none-text='не указано'></ng-select>
        </div>
        <div class="col-sm-3">
            <label class="no-margin-bottom">метро</label>
            <ng-select model='FormService.model.station_id' object="{{ fact('stations', 'title') }}" label='title' none-text='не указано' live-search='true'></ng-select>
        </div>
        <div class="col-sm-3">
            <label class="no-margin-bottom">сортировка</label>
            <ng-select model='FormService.model.sort' object="Sort" label='title' none-text='не указано'></ng-select>
        </div>
    </div>
</div>
<div class="row mbs">
    <div class="col-sm-12">
        <label>содержание раздела</label>
        <div id='editor' style="height: 500px">@{{ FormService.model.html }}</div>
    </div>
</div>
