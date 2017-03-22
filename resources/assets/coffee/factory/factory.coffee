angular.module('Egecms')
    .value 'Published', [
        {id:0, title: 'не опубликовано'},
        {id:1, title: 'опубликовано'},
    ]
    .value 'UpDown', [
        {id: 1, title: 'вверху'},
        {id: 2, title: 'внизу'},
    ]
    .value 'Anchor', [
        {id: 1, title: 'главная – блок 1'},
        {id: 2, title: 'главная – блок 2'},
        {id: 3, title: 'главная – блок 3'},
        {id: 4, title: 'главная – блок 4'},
        {id: 5, title: 'раздел...'},
    ]
