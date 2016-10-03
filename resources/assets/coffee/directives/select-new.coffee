angular.module 'Egecms'
    .directive 'ngSelectNew', ->
        restrict: 'E'
        replace: true
        scope:
            object: '='
            model: '='
            noneText: '@'
            label: '@'
        templateUrl: 'directives/select-new'
        controller: ($scope, $element, $attrs, $timeout) ->
            # выбираем первое значение по умолчанию, если нет noneText
            if not $scope.noneText
                $scope.model = _.first Object.keys($scope.object)

            $timeout ->
                $($element).selectpicker()
            , 500
