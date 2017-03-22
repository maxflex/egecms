@include('directives.variable-group-form')

<div class="add-group">
    <a class="link link-like" ng-click="add()"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Создать группу</a>
</div>

<div ng-repeat="group in GroupService.all()" class="variable-groups">
    <div class="variable-group" ng-show="group.id || GroupService.hasChild(group.id)">
        <div class="droppable"
             ng-show="isDragging && !sameGroupItem(group.id)"
             ng-dragenter="dragEnter($event)"
             ng-dragleave="dragLeave($event)"
             ng-dragover="dragOver($event)"
             ng-drop="drop($event, group)"
        ></div>
        <div class="caption">
            @{{ group.name }}
            <span class="pull-right">
                <span aria-hidden="true" class="glyphicon glyphicon-pencil" ng-click="edit(group)" ng-show="group.id"></span>
                <span aria-hidden="true" class="glyphicon glyphicon-remove" ng-click="delete(group)" ng-show="group.id"></span>
                <span aria-hidden="true" class="glyphicon"
                      ng-class="{'glyphicon-menu-up': !group.collapsed, 'glyphicon-menu-down': group.collapsed}"
                      ng-click="group.collapsed = !group.collapsed"
                ></span>
            </span>
        </div>
        <table class="table" ng-class="{'no-margin-bottom': !GroupService.hasChild(group.id)}" ng-hide="group.collapsed">
            <tr ng-repeat="variable in GroupService.getChild(group.id)"
                draggable="true"
                ng-dragstart="dragStart($event, variable)"
                ng-dragend="dragEnd($event)"
            >
                <td>
                    <a draggable="false" href='variables/@{{ variable.id }}/edit'>@{{ variable.name }}</a>
                </td>
                <td>
                    @{{ variable.desc }}
                </td>
            </tr>
        </table>
    </div>
</div>