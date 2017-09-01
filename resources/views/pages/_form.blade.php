<div class="row mbs">
    <div class="col-sm-6">
        @include('modules.input', ['title' => 'ключевая фраза', 'model' => 'keyphrase'])
    </div>
    <div class="col-sm-6">
        <div class="field-container">
            <div class="input-group">
                <input type="text" ng-keyup="checkExistance('url', $event)" class="field form-control" required
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
</div>

<div class="row mbs">
    <div class="col-sm-12">
        @include('modules.input', [
            'title' => 'title',
            'model' => 'title',
            'attributes' => [
                'ng-counter' => true,
            ]
        ])
    </div>
</div>

<div class="row mbs">
    <div class="col-sm-6">
        @include('modules.input', [
            'title' => 'h1 вверху',
            'model' => 'h1',
            'attributes' => [
                'ng-counter' => true,
            ]
        ])
    </div>
    <div class="col-sm-6">
        @include('modules.input', [
            'title' => 'h1 внизу',
            'model' => 'h1_bottom',
            'attributes' => [
                'ng-counter' => true,
            ]
        ])
    </div>
</div>

<div class="row mbs">
    <div class="col-sm-12">
        <label class="no-margin-bottom label-opacity">публикация страницы</label>
        <ng-select-new model='FormService.model.published' object="Published" label="title" convert-to-number></ng-select-new>
    </div>
</div>

<div class="row mbs">
    <div class="col-sm-4">
        @include('modules.input', ['title' => 'anchor', 'model' => 'anchor'])
    </div>
    <div class="col-sm-4">
        <label class="no-margin-bottom label-opacity">блок</label>
        <ng-select-new model='FormService.model.anchor_block_id' object="Anchor" label="title" convert-to-number none-text='выберите блок'></ng-select-new>
    </div>
    <div class="col-sm-4" ng-show='FormService.model.anchor_block_id == 4'>
        <label class="no-margin-bottom label-opacity">номер раздела</label>
        <div angucomplete-alt id='page-search-2'
              placeholder="номер раздела"
              pause="500"
              selected-object="searchSelected2"
              remote-api-handler='search'
              title-field="title"
              minlength="3"
              text-searching='поиск...'
              text-no-results='не найдено'
              input-class="form-control form-control-small"
              match-class="highlight">
          </div>
          <img src='img/svg/cross.svg' class='cross-inside-input' ng-show='FormService.model.anchor_page_id' ng-click="FormService.model.anchor_page_id = null">
    </div>
</div>
<div class="row mbs">
    <div class="col-sm-12">
        @include('modules.input', ['title' => 'meta keywords', 'model' => 'keywords'])
    </div>
</div>
<div class="row mbs">
    <div class="col-sm-12">
        @include('modules.input', [
            'title' => 'meta description',
            'model' => 'desc',
            'textarea' => true,
            'attributes' => [
                'ng-counter' => true,
            ]
        ])
    </div>
</div>

<div class="serp">
    <div class="row mb">
        <div class="col-sm-4">
            <label class="no-margin-bottom label-opacity">предметы</label>
            <ng-multi object='{{ fact('subjects', 'name') }}' label='name' model='FormService.model.subjects' none-text='выберите предметы'></ng-multi>
        </div>
        <div class="col-sm-4">
            <label class="no-margin-bottom label-opacity">приоритет</label>
            <select class='form-control selectpicker' ng-model='FormService.model.priority' convert-to-number>
                <option ng-repeat='priority in {{ fact('priorities', null, 'position') }}' value='@{{ priority.id }}'>@{{ priority.title }}</option>
            </select>
        </div>
        <div class="col-sm-4" ng-show="FormService.model.priority == 2 || FormService.model.priority == 3">
            <label class="no-margin-bottom label-opacity">метро</label>
            <ng-select-new model='FormService.model.station_id' object="{{ fact('stations', 'title', 'title') }}" label='title' none-text='не указано' live-search='true' convert-to-number></ng-select-new>
        </div>
    </div>
    <div class="row mb">
        <div class="col-sm-12">
            @include('modules.input', ['title' => 'скрытый фильтр', 'model' => 'hidden_filter'])
        </div>
    </div>
</div>
<div class="row mbb">
    <div class="col-sm-12">
        <label>содержание раздела</label>
        <label class="pull-right" style='top: 3px; position: relative'>
            <span class='link-like' ng-click='addLinkDialog()'>добавить ссылку</span>
        </label>
        <div class="top-links pull-right">
            <span ng-repeat="option in options" class="link-like ng-binding ng-scope" ng-class="{'active': $index == sort}" ng-click="setSort($index)">по алфавиту</span>
            <span ng-repeat="option in options" class="link-like ng-binding ng-scope active" ng-class="{'active': $index == sort}" ng-click="setSort($index)">по времени сохранения</span>
        </div>
        <div id='editor' style="height: 500px">@{{ FormService.model.html }}</div>
    </div>
</div>
@include('pages._modals')
