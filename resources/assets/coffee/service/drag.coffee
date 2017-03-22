angular
    .module 'Egecms'
    .service 'DragService', (GroupService) ->
        @isDragging = false
        @dragData = {}

        updateState = (state) =>
            @isDragging = state
            scope.$apply()

        @drop = (event) ->
            GroupService.transfer @dragData.item_id, $(event.target).data('group-id')
            @dragData = {}
            $(event.target).removeClass 'active'
            updateState false

        @dragEnter = (event) ->
            event.preventDefault()
            $(event.target).addClass 'active'

        @dragLeave = (event) ->
            event.preventDefault()
            $(event.target).removeClass 'active'

        @dragOver = (event) ->
            event.preventDefault()

        @dragStart = (event) ->
            $target = $ event.target
            @dragData =
                group_id: $target.data 'group-id'
                item_id:  $target.data 'item-id'
            $target.css opacity: .3
            updateState true

        @dragEnd = (event) ->
            $(event.target).css opacity: 1
            updateState false

        @sameGroupItem = (group_id) ->
            return true if not group_id and not @dragData.group_id
            @dragData?.group_id is group_id

        @