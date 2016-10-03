angular
    .module 'Egecms'
    .controller 'VariablesIndex', ($scope, $attrs, IndexService, Variable) ->
        bindArguments($scope, arguments)
        angular.element(document).ready ->
            IndexService.init(Variable, $scope.current_page, $attrs)

    .controller 'VariablesForm', ($scope, $attrs, $timeout, FormService, Variable) ->
        bindArguments($scope, arguments)
        angular.element(document).ready ->
            FormService.init(Variable, $scope.id, $scope.model)
            FormService.dataLoaded.promise.then ->
                $scope.editor = ace.edit("editor")
                mode = if FormService.model.html[0] is '{' then 'json' else 'html'
                $scope.editor.getSession().setMode("ace/mode/#{mode}")
                $scope.editor.getSession().setUseWrapMode(true)
                $scope.editor.setOptions
                    minLines: 30
                    maxLines: Infinity
            FormService.beforeSave = ->
                FormService.model.html = $scope.editor.getValue()
