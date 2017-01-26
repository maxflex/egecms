{{-- ПОИСК --}}
<div id="search-app" class="modal" role="dialog" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
          <div class="row">
              <div class="col-sm-6">
                  <select class='selectpicker'>
                      <option v-for='option in options' :value='option.value'>
                          @{{ option.title }}
                      </option>
                  </select>
              </div>
              <div class="col-sm-6"></div>
          </div>
      </div>
      <div class="modal-footer center">
        <button type="button" class="btn btn-primary" v-on:click="addLink()">Поиск</button>
      </div>
    </div>
  </div>
</div>
