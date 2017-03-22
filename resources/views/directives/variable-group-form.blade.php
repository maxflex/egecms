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