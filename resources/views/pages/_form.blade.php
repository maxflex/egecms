<div class="row mbs">
    <div class="col-sm-12">
        @include('modules.input', ['title' => 'ключевая фраза', 'model' => 'keyphrase'])
    </div>
</div>
<div class="row mbs">
    <div class="col-sm-4">
        <div class="field-container">
            <div class="input-group">
                <input ng-keyup="checkExistance('url', $event)" type="text" class="field form-control" required
                       placeholder="отображаемый URL" ng-model='FormService.model.url'
                       ng-model-options="{ allowInvalid: true }">
               <label class="floating-label">отображаемый URL</label>
               <span class="input-group-btn">
                   <button class="btn btn-default" type="button" ng-disabled="!FormService.model.keyphrase" ng-click="generateUrl($event)">
                       <span class="glyphicon glyphicon-refresh no-margin-right"></span>
                   </button>
               </span>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        @include('modules.input', ['title' => 'title', 'model' => 'title', 'keyup' => 'checkExistance(\'title\', $event)'])
    </div>
    <div class="col-sm-4">
        <label class="no-margin-bottom">публикация</label>
        <select class="form-control" bs-select ng-model='FormService.model.published' ng-options="+(index) as title for (index, title) in Published"></select>
    </div>
</div>
<div class="row mbs">
    <div class="col-sm-4">
        <label class="no-margin-bottom">макет</label>
        <ng-select-new model='FormService.model.variable_id' object='{{ App\Models\Variable::getLight() }}' label='name' none-text='не указано'></ng-select>
    </div>
    <div class="col-sm-4">
        <label class="no-margin-bottom">seo desktop</label>
        <ng-select model='FormService.model.seo_desktop' object="UpDown" label='title' none-text='не указано'></ng-select>
    </div>
    <div class="col-sm-4">
        <label class="no-margin-bottom">seo mobile</label>
        <ng-select model='FormService.model.seo_mobile' object="UpDown" label='title' none-text='не указано'></ng-select>
    </div>
</div>
<div class="row mbs">
    <div class="col-sm-12">
        @include('modules.input', ['title' => 'h1', 'model' => 'h1'])
    </div>
</div>
<div class="row mbs">
    <div class="col-sm-12">
        @include('modules.input', ['title' => 'ключевые слова', 'model' => 'keywords'])
    </div>
</div>
<div class="row mbs">
    <div class="col-sm-12">
        @include('modules.input', ['title' => 'описание', 'model' => 'desc'])
    </div>
</div>
<div class="row mbs">
    <div class="col-sm-12">
        <label class="no-margin-bottom">тэги</label>
        <tags-input ng-model="FormService.model.tags" display-property="text" add-from-autocomplete-only="true" placeholder="добавьте тэг">
            <auto-complete source='{{ \App\Models\Tag::all() }}'></auto-complete>
        </tags-input>
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
            <label class="no-margin-bottom">сортировка по</label>
            <ng-select model='FormService.model.sort' object="{{ fact('sort') }}" label='title'></ng-select>
        </div>
    </div>
</div>
<div class="row mbb">
    <div class="col-sm-12">
        <label>содержание раздела</label>
        <div id='editor' style="height: 500px">@{{ FormService.model.html }}</div>
    </div>
</div>
