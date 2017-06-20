angular
    .module 'Egecms'
    .controller 'PagesIndex', ($scope, $attrs, $timeout, IndexService, Page, Published, ExportService) ->
        bindArguments($scope, arguments)
        ExportService.init({controller: 'pages'})

        angular.element(document).ready ->
            IndexService.init(Page, $scope.current_page, $attrs, false)

    .controller 'PagesForm', ($scope, $http, $attrs, $timeout, FormService, AceService, Page, Published, UpDown, Anchor) ->
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

        $scope.addLinkDialog = ->
            $scope.link_text = AceService.editor.getSelectedText()
            $('#link-manager').modal 'show'

        $scope.search = (input, promise)->
            $http.post('api/pages/search', {q: input}, {timeout: promise})
                .then (response) ->
                    return response

        $scope.searchSelected = (selectedObject) ->
            $scope.link_page_id = selectedObject.originalObject.id if selectedObject isnt undefined
            $scope.$broadcast('angucomplete-alt:changeInput', 'page-search', $scope.link_page_id.toString())

        $scope.searchSelected2 = (selectedObject) ->
            FormService.model.anchor_page_id = selectedObject.originalObject.id if selectedObject isnt undefined

        $scope.$watch 'FormService.model.anchor_page_id', (newVal, oldVal) ->
            return if newVal is undefined
            if newVal is null
                $scope.$broadcast('angucomplete-alt:clearInput', 'page-search-2')
            else
                $scope.$broadcast('angucomplete-alt:changeInput', 'page-search-2', newVal.toString())
            $timeout -> $scope.$apply()

        $scope.addLink = ->
            link = "<a href='[link|#{$scope.link_page_id}]'>#{$scope.link_text}</a>"
            $scope.link_page_id = undefined
            $scope.$broadcast('angucomplete-alt:clearInput')
            AceService.editor.session.replace(AceService.editor.selection.getRange(), link)
            $('#link-manager').modal 'hide'

        $scope.$watch 'FormService.model.station_id', (newVal, oldVal) ->
            $timeout -> $('#sort').selectpicker('refresh')
