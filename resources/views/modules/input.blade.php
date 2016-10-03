<div class="field-container">
  <input @if(isset($keyup)) ng-keyup='{{ $keyup }}' @endif type="text" class="field form-control" required placeholder="{{ $title }}" ng-model='FormService.model.{{ $model }}' ng-model-options="{ allowInvalid: true }">
  <label class="floating-label">{{ $title }}</label>
</div>
