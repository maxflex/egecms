angular
    .module 'Egecms'
    .controller 'PagesIndex', ($scope, $attrs, $timeout, IndexService, Page, FileUploader) ->
        bindArguments($scope, arguments)

        $scope.sortableOptions =
            update: (e, ui) ->
                $timeout ->
                    IndexService.page.data.forEach (model, index) ->
                        Page.update({id: model.id}, {position: index})
            axis: 'y'

        FileUploader.FileSelect.prototype.isEmptyAfterSelection = ->
            true

        $scope.uploader = new FileUploader
            url: 'pages/import'
            alias: 'pages'
            autoUpload: true
            method: 'post'
            removeAfterUpload: true
            onCompleteItem: (i, response, status) ->
                notifySuccess 'Импортирован' if status is 200
                notifyError 'Ошибка!' if status isnt 200
            onWhenAddingFileFailed  = (item, filter, options) ->
                if filter.name is "queueLimit"
                    this.clearQueue()
                    this.addToQueue(item)


        $scope.import = (e) ->
            e.preventDefault()
            $('#import-button').trigger 'click'
            return #parse:isecdom err fix

        angular.element(document).ready ->
            IndexService.init(Page, $scope.current_page, $attrs)
    .controller 'PagesForm', ($scope, $attrs, $timeout, FormService, Page) ->
        bindArguments($scope, arguments)
        angular.element(document).ready ->
            FormService.init(Page, $scope.id, $scope.model)
            FormService.dataLoaded.promise.then ->
                $scope.editor = ace.edit("editor")
                $scope.editor.getSession().setMode("ace/mode/html")
            FormService.beforeSave = ->
                FormService.model.html = $scope.editor.getValue()
