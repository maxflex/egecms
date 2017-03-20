angular.module('Egecms')
    .factory 'Variable', ($resource) ->
        $resource apiPath('variables'), {id: '@id'}, updatable()

    .factory 'Sass', ($resource) ->
        $resource apiPath('sass'), {id: '@id'}, updatable()

    .factory 'Page', ($resource) ->
        $resource apiPath('pages'), {id: '@id'},
            update:
                method: 'PUT'
            checkExistance:
                method: 'POST'
                url: apiPath('pages', 'checkExistance')

apiPath = (entity, additional = '') ->
    "api/#{entity}/" + (if additional then additional + '/' else '') + ":id"


updatable = ->
    update:
        method: 'PUT'
countable = ->
    count:
        method: 'GET'
