angular.module 'Egecms'
    .service 'AceService', ->
        this.initEditor = (FormService, minLines = 30) ->
            this.editor = ace.edit("editor")
            this.editor.getSession().setMode("ace/mode/html")
            this.editor.getSession().setUseWrapMode(true)
            this.editor.setOptions
                minLines: minLines
                maxLines: Infinity
            this.editor.commands.addCommand
                name: 'save',
                bindKey:
                    win: 'Ctrl-S'
                    mac: 'Command-S'
                exec: (editor) ->
                    FormService.edit()
        this
