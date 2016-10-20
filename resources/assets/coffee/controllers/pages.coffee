angular
    .module 'Egecms'
    .controller 'PagesIndex', ($scope, $attrs, $timeout, IndexService, Page, Published, FileUploader, Tag) ->
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
            return

        $scope.export = (e)->
            e.preventDefault()
            $scope.exporting = true
            $scope.export_dialog = bootbox.dialog
                message: $ '#export-modal'
                closeButton: true
                onEscape: ->
                    $scope.exporting = false
                    return true
                buttons:
                    'export':
                        label: 'Экспорт',
                        callback: ->
                            $scope.exporting = false
            return



        angular.element(document).ready ->
            IndexService.init(Page, $scope.current_page, $attrs)

        $scope.loadTags = (text) ->
            Tag.autocomplete({text: text}).$promise

    .controller 'PagesForm', ($scope, $http, $attrs, $timeout, FormService, AceService, Page, Published, UpDown, Tag) ->
        bindArguments($scope, arguments)
        angular.element(document).ready ->
            FormService.init(Page, $scope.id, $scope.model)
            FormService.dataLoaded.promise.then ->
                AceService.initEditor(FormService, 15)
            FormService.beforeSave = ->
                FormService.model.html = AceService.editor.getValue()

        $scope.generateUrl = (event) ->
            $http.post '/api/translit/to-url',
                text: FormService.model.keyphrase
            .then (response) ->
                FormService.model.url = response.data
                $scope.checkExistance 'url',
                    target: $(event.target).closest('div').find('input')

        $scope.checkExistance = (field, event) ->
            Page.checkExistance
                id: FormService.model.id
                field: field
                value: FormService.model[field]
            , (response) ->
                element = $(event.target)
                if response.exists
                    FormService.error_element = element
                    element.addClass('has-error').focus()
                else
                    FormService.error_element = undefined
                    element.removeClass('has-error')

        $scope.loadTags = (text) ->
            Tag.autocomplete({text: text}).$promise
