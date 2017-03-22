angular.module 'Egecms'
    .service 'GroupService', ($timeout, Variable, VariableGroup, FormService, IndexService) ->
        _.extendOwn @, FormService
        IndexService.loaded.promise.then => @children = IndexService.page.data

        @empty = {id: null, name:'не указана'}
        @model  = new VariableGroup
        @groups = VariableGroup.query()

        @afterRequest = ->
            @saving = false
            ajaxEnd()

        @update = ->
            @model.$update().then =>
                original_value = _.find @groups, id: @model.id
                _.extend original_value, @model
                @model = new Variable
                @afterRequest()

        @create = ->
            @model.$save(@model).then (response) =>
                @groups.push response
                @model = new Variable
                @afterRequest()

        @delete = (model) ->
            @model = model if model
            @model.$delete().then =>
                @groups = _.without @groups, @model
                _.where @children, group_id: @model.id
                    .map (child) =>
                        child.group_id = null

                @afterRequest()

        @hasChild = (group_id) ->
            return @getChild(group_id).length

        @getChild = (group_id) ->
            return [] if not (@children and @children.length)
            _.where @children, {group_id: group_id}

        @all = (fake_group = true) ->
            (groups = _.clone @groups).push @empty if fake_group
            _.sortBy groups, (g) -> if g.id then g.id else 1000

        @transfer = (child_id, group_id) ->
            child = _.find @children, id: child_id
            _.extend child, group_id: group_id or null
            (new Variable child).$update()

        @