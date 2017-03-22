angular
    .module 'Egecms'
    .controller 'VariablesIndex', ($scope, $attrs, $timeout, IndexService, Variable) ->
        bindArguments($scope, arguments)
        angular.element(document).ready ->
            IndexService.init(Variable, $scope.current_page, $attrs)

        $scope.dnd = {}

        $scope.dragStart = (variable_id) ->
            $timeout ->
                console.log('drag start', variable_id)
                $scope.dnd.drag_id = variable_id

        $scope.dragEnd = ->
            console.log('drag end')
            $scope.dnd.drag_id = null

        $scope.getVariables = (group_id) ->
            if IndexService.page then IndexService.page.data.filter (d) ->
                d.group_id is group_id

    .controller 'VariablesForm', ($scope, $attrs, $timeout, FormService, AceService, Variable) ->
        bindArguments($scope, arguments)
        angular.element(document).ready ->
            FormService.init(Variable, $scope.id, $scope.model)
            FormService.dataLoaded.promise.then ->
                AceService.initEditor(FormService, 30)
            FormService.beforeSave = ->
                FormService.model.html = AceService.editor.getValue()
