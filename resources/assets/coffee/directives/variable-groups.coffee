angular.module 'Egecms'
    .directive 'variableGroups', ->
         restrict: 'E'
         templateUrl: 'directives/variable-groups'
         controller: ($scope, VariableGroup, GroupService) ->
              bindArguments $scope, arguments

              $scope.modal = $('#variable-group-modal')

              $scope.create = ->
                  $scope.GroupService.create()
                  $scope.modal.modal 'hide'
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

              #drag handlers
              $scope.isDragging = false
              $scope.draggingItem = null

              $scope.drop = (event, target_group) ->
                  GroupService.transfer @draggingItem, target_group
                  $(event.target).removeClass 'active'
                  $scope.isDragging = false

              $scope.dragEnter = (event) ->
                  event.preventDefault()
                  $(event.target).addClass 'active'

              $scope.dragLeave = (event) ->
                  event.preventDefault()
                  $(event.target).removeClass 'active'

              $scope.dragOver = (event) ->
                  event.preventDefault()

              $scope.dragStart = (event, variable) ->
                  $scope.draggingItem = variable
                  $(event.target).addClass 'dragging'
                  $scope.isDragging = true

              $scope.dragEnd = (event) ->
                  $scope.draggingItem = null
                  $scope.isDragging = false
                  $(event.target).removeClass('dragging').find('a').blur()

              $scope.sameGroupItem = (group_id) ->
                  return true if not group_id and not $scope.draggingItem?.group_id
                  $scope.draggingItem.group_id is group_id