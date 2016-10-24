angular
    .module 'Egecms'
    .controller 'PagesIndex', ($scope, $attrs, $timeout, IndexService, Page, Published, Tag, ExportService) ->
        bindArguments($scope, arguments)
        ExportService.init
            controller: 'pages'

        $scope.sortableOptions =
            update: (e, ui) ->
                $timeout ->
                    IndexService.page.data.forEach (model, index) ->
                        Page.update({id: model.id}, {position: index})
            axis: 'y'

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
