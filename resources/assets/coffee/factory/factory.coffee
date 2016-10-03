angular.module('Egecms')
    .value 'Published', ['не опубликовано', 'опубликовано']
    .value 'UpDown', [
        {id: 1, title: 'вверху'},
        {id: 2, title: 'внизу'},
    ]
