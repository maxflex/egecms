<div id="variable-group-modal" class="modal" role="dialog" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="field-container">
                    <input type="text" class="field form-control" required placeholder="название группы" ng-model='GroupService.model.name'>
                    <label class="floating-label">название группы</label>
                </div>
            </div>
            <div class="modal-footer center">
                <div class="row">
                    <div class="col-sm-12 center">
                        <button ng-if="GroupService.model.id" class="btn btn-primary" style='width: 150px' ng-click="update()" ng-disabled="GroupService.saving">сохранить</button>
                        <button ng-if="!GroupService.model.id" class="btn btn-primary" style='width: 150px' ng-click="create()" ng-disabled="GroupService.saving">создать</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="add-group">
    <a class="link link-like" ng-click="add()"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Создать группу</a>
</div>

<div ng-repeat="group in GroupService.all()" class="variable-groups">
    <div class="variable-group" ng-show="group.id || GroupService.hasChild(group.id)">
        <div class="droppable"
             ng-show="DragService.isDragging && !DragService.sameGroupItem(group.id)"
             ondragenter="scope.DragService.dragEnter(event)"
             ondragleave="scope.DragService.dragLeave(event)"
             ondragover="scope.DragService.dragOver(event)"
             ondrop="scope.DragService.drop(event)"
             data-group-id="@{{group.id}}"
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
            <tr class="draggable-item"
                draggable="true"
                ondragstart="scope.DragService.dragStart(event)"
                ondragend="scope.DragService.dragEnd(event)"
                data-item-id="@{{ variable.id }}"
                data-group-id="@{{ variable.group_id }}"
                ng-repeat="variable in GroupService.getChild(group.id)">
                <td>
                    <a href='variables/@{{ variable.id }}/edit'>@{{ variable.name }}</a>
                </td>
                <td>
                    @{{ variable.desc }}
                </td>
            </tr>
        </table>
    </div>
</div>