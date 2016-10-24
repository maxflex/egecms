angular
    .module 'Egecms'
    .controller 'TagsIndex', ($scope, $attrs, IndexService, ExportService, Tag) ->
        bindArguments($scope, arguments)
        ExportService.init
            controller: 'tags'

        angular.element(document).ready ->
            IndexService.init(Tag, $scope.current_page, $attrs)
    .controller 'TagsForm', ($scope, $attrs, $timeout, FormService, Tag) ->
        bindArguments($scope, arguments)
        angular.element(document).ready ->
            FormService.init(Tag, $scope.id, $scope.model)
