angular.module 'Egecms'
    .directive 'variableGroups', ->
         restrict: 'E'
         templateUrl: 'directives/variable-groups'
         controller: ($scope, VariableGroup, GroupService, DragService) ->
              bindArguments $scope, arguments

              $scope.modal = $('#variable-group-modal')

              $scope.create = ->
                  $scope.GroupService.create()
                  $scope.modal.modal 'hide'
                  $scope.GroupService.model = {}
                  return false

              $scope.update = ->
                  $scope.GroupService.update()
                  $scope.modal.modal 'hide'

              $scope.edit = (model) ->
                  $scope.add model

              $scope.delete = (model) ->
                  $scope.GroupService.delete model

              $scope.add = (model) ->
                  $scope.GroupService.model = _.clone model if model
                  $scope.modal.modal 'show'
                  $('input', $scope.modal).focus()
                  return false