angular
    .module 'Egecms'
    .controller 'VariablesIndex', ($scope, $attrs, IndexService, Variable, VariableGroup, GroupService) ->
        bindArguments($scope, arguments)
        angular.element(document).ready ->
            IndexService.init(Variable, $scope.current_page, $attrs)

    .controller 'VariablesForm', ($scope, $attrs, $timeout, FormService, AceService, Variable) ->
        bindArguments($scope, arguments)
        angular.element(document).ready ->
            FormService.init(Variable, $scope.id, $scope.model)
            FormService.dataLoaded.promise.then ->
                AceService.initEditor(FormService, 30)
            FormService.beforeSave = ->
                FormService.model.html = AceService.editor.getValue()
