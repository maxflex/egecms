angular
    .module 'Egecms'
    .controller 'VariablesIndex', ($scope, $attrs, $timeout, IndexService, Variable, VariableGroup) ->
        bindArguments($scope, arguments)
        angular.element(document).ready ->
            IndexService.init(Variable, $scope.current_page, $attrs)

        $scope.dnd = {}

        $scope.dragStart = (variable_id) ->
            $timeout ->
                console.log('drag start', variable_id)
                $scope.dnd.variable_id = variable_id

        $scope.dragEnd = ->
            console.log('drag end')
            $scope.dnd.variable_id = null

        $scope.dragLeave = ->
            console.log('drag leave')

        $scope.drop = (group_id) ->
            if group_id is null
                variable_id = $scope.dnd.variable_id
                VariableGroup.save {variable_id: variable_id}, (response) ->
                    $scope.groups.push(response)
                    IndexService.page.data.find (variable) ->
                        variable.id is variable_id
                    .group_id = response.id

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
