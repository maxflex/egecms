angular.module 'Egecms'
    .service 'AceService', ->
        this.initEditor = (minLines = 30) ->
            this.editor = ace.edit("editor")
            this.editor.getSession().setMode("ace/mode/html")
            this.editor.getSession().setUseWrapMode(true)
            this.editor.setOptions
                minLines: minLines
                maxLines: Infinity
        this
