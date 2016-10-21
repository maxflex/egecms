<!-- Modal -->
<div id="export-modal" class="modal" role="dialog" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
          <select class='selectpicker' ng-model='export_field'>
              <option value='' selected>выберите поле для экспорта</option>
              <option disabled>──────────────</option>
              <option ng-repeat='field in exportable_fields' value='@{{ field }}'>@{{ field }}</option>
          </select>
      </div>
      <div class="modal-footer center">
        <button ng-disabled='!export_field' type="button" class="btn btn-primary" ng-click="export()">экспорт</button>
      </div>
    </div>
  </div>
</div>
