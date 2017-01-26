initSearch = ->
    $('.search-icon').on 'click', -> $('#search-app').modal('show')
    new Vue
        el: '#search-app'
        data:
            options: [
                {title: 'test 1', value: 1}
                {title: 'test 2', value: 2}
            ]
