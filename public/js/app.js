(function() {
  var indexOf = [].indexOf || function(item) { for (var i = 0, l = this.length; i < l; i++) { if (i in this && this[i] === item) return i; } return -1; };

  angular.module("Egecms", ['ngSanitize', 'ngResource', 'ngAnimate', 'ui.sortable', 'ui.bootstrap', 'angular-ladda', 'angularFileUpload', 'ngTagsInput']).config([
    '$compileProvider', function($compileProvider) {
      return $compileProvider.aHrefSanitizationWhitelist(/^\s*(https?|ftp|mailto|chrome-extension|sip):/);
    }
  ]).filter('cut', function() {
    return function(value, wordwise, max, nothing, tail) {
      var lastspace;
      if (nothing == null) {
        nothing = '';
      }
      if (!value) {
        return nothing;
      }
      max = parseInt(max, 10);
      if (!max) {
        return value;
      }
      if (value.length <= max) {
        return value;
      }
      value = value.substr(0, max);
      if (wordwise) {
        lastspace = value.lastIndexOf(' ');
        if (lastspace !== -1) {
          if (value.charAt(lastspace - 1) === '.' || value.charAt(lastspace - 1) === ',') {
            lastspace = lastspace - 1;
          }
          value = value.substr(0, lastspace);
        }
      }
      return value + (tail || '…');
    };
  }).filter('hideZero', function() {
    return function(item) {
      if (item > 0) {
        return item;
      } else {
        return null;
      }
    };
  }).directive('convertToNumber', function() {
    return {
      require: 'ngModel',
      link: function(scope, element, attrs, ngModel) {
        ngModel.$parsers.push(function(val) {
          return parseInt(val, 10);
        });
        return ngModel.$formatters.push(function(val) {
          if (val || val === 0) {
            return '' + val;
          } else {
            return '';
          }
        });
      }
    };
  }).run(function($rootScope, $q) {
    $rootScope.dataLoaded = $q.defer();
    $rootScope.frontendStop = function(rebind_masks) {
      if (rebind_masks == null) {
        rebind_masks = true;
      }
      $rootScope.frontend_loading = false;
      $rootScope.dataLoaded.resolve(true);
      if (rebind_masks) {
        return rebindMasks();
      }
    };
    $rootScope.range = function(min, max, step) {
      var i, input;
      step = step || 1;
      input = [];
      i = min;
      while (i <= max) {
        input.push(i);
        i += step;
      }
      return input;
    };
    $rootScope.toggleEnum = function(ngModel, status, ngEnum, skip_values, allowed_user_ids, recursion) {
      var ref, ref1, ref2, status_id, statuses;
      if (skip_values == null) {
        skip_values = [];
      }
      if (allowed_user_ids == null) {
        allowed_user_ids = [];
      }
      if (recursion == null) {
        recursion = false;
      }
      if (!recursion && (ref = parseInt(ngModel[status]), indexOf.call(skip_values, ref) >= 0) && (ref1 = $rootScope.$$childHead.user.id, indexOf.call(allowed_user_ids, ref1) < 0)) {
        return;
      }
      statuses = Object.keys(ngEnum);
      status_id = statuses.indexOf(ngModel[status].toString());
      status_id++;
      if (status_id > (statuses.length - 1)) {
        status_id = 0;
      }
      ngModel[status] = statuses[status_id];
      if (indexOf.call(skip_values, status_id) >= 0 && (ref2 = $rootScope.$$childHead.user.id, indexOf.call(allowed_user_ids, ref2) < 0)) {
        return $rootScope.toggleEnum(ngModel, status, ngEnum, skip_values, allowed_user_ids, true);
      }
    };
    $rootScope.toggleEnumServer = function(ngModel, status, ngEnum, Resource) {
      var status_id, statuses, update_data;
      statuses = Object.keys(ngEnum);
      status_id = statuses.indexOf(ngModel[status].toString());
      status_id++;
      if (status_id > (statuses.length - 1)) {
        status_id = 0;
      }
      update_data = {
        id: ngModel.id
      };
      update_data[status] = status_id;
      return Resource.update(update_data, function() {
        return ngModel[status] = statuses[status_id];
      });
    };
    $rootScope.formatDateTime = function(date) {
      return moment(date).format("DD.MM.YY в HH:mm");
    };
    $rootScope.formatDate = function(date, full_year) {
      if (full_year == null) {
        full_year = false;
      }
      if (!date) {
        return '';
      }
      return moment(date).format("DD.MM.YY" + (full_year ? "YY" : ""));
    };
    $rootScope.dialog = function(id) {
      $("#" + id).modal('show');
    };
    $rootScope.closeDialog = function(id) {
      $("#" + id).modal('hide');
    };
    $rootScope.ajaxStart = function() {
      ajaxStart();
      return $rootScope.saving = true;
    };
    $rootScope.ajaxEnd = function() {
      ajaxEnd();
      return $rootScope.saving = false;
    };
    $rootScope.findById = function(object, id) {
      return _.findWhere(object, {
        id: parseInt(id)
      });
    };
    $rootScope.total = function(array, prop, prop2) {
      var sum;
      if (prop2 == null) {
        prop2 = false;
      }
      sum = 0;
      $.each(array, function(index, value) {
        var v;
        v = value[prop];
        if (prop2) {
          v = v[prop2];
        }
        return sum += v;
      });
      return sum;
    };
    $rootScope.deny = function(ngModel, prop) {
      return ngModel[prop] = +(!ngModel[prop]);
    };
    return $rootScope.formatBytes = function(bytes) {
      if (bytes < 1024) {
        return bytes + ' Bytes';
      } else if (bytes < 1048576) {
        return (bytes / 1024).toFixed(1) + ' KB';
      } else if (bytes < 1073741824) {
        return (bytes / 1048576).toFixed(1) + ' MB';
      } else {
        return (bytes / 1073741824).toFixed(1) + ' GB';
      }
    };
  });

}).call(this);

(function() {


}).call(this);

(function() {
  angular.module('Egecms').controller('LoginCtrl', function($scope, $http) {
    angular.element(document).ready(function() {
      return $scope.l = Ladda.create(document.querySelector('#login-submit'));
    });
    return $scope.checkFields = function() {
      $scope.l.start();
      ajaxStart();
      $scope.in_process = true;
      return $http.post('login', {
        login: $scope.login,
        password: $scope.password
      }).then(function(response) {
        if (response.data === true) {
          return location.reload();
        } else {
          $scope.in_process = false;
          ajaxEnd();
          $scope.l.stop();
          return notifyError("Неправильная пара логин-пароль");
        }
      });
    };
  });

}).call(this);

(function() {
  angular.module('Egecms').controller('PagesIndex', function($scope, $attrs, $timeout, IndexService, Page, Published, Tag, ExportService) {
    bindArguments($scope, arguments);
    ExportService.init({
      controller: 'pages'
    });
    angular.element(document).ready(function() {
      return IndexService.init(Page, $scope.current_page, $attrs, false);
    });
    return $scope.loadTags = function(text) {
      return Tag.autocomplete({
        text: text
      }).$promise;
    };
  }).controller('PagesForm', function($scope, $http, $attrs, $timeout, FormService, AceService, Page, Published, UpDown, Tag) {
    var empty_useful;
    bindArguments($scope, arguments);
    empty_useful = {
      text: null,
      page_id_field: null
    };
    angular.element(document).ready(function() {
      FormService.init(Page, $scope.id, $scope.model);
      FormService.dataLoaded.promise.then(function() {
        if (!FormService.model.useful || !FormService.model.useful.length) {
          FormService.model.useful = [angular.copy(empty_useful)];
        }
        return AceService.initEditor(FormService, 15);
      });
      return FormService.beforeSave = function() {
        return FormService.model.html = AceService.editor.getValue();
      };
    });
    $scope.generateUrl = function(event) {
      return $http.post('/api/translit/to-url', {
        text: FormService.model.keyphrase
      }).then(function(response) {
        FormService.model.url = response.data;
        return $scope.checkExistance('url', {
          target: $(event.target).closest('div').find('input')
        });
      });
    };
    $scope.checkExistance = function(field, event) {
      return Page.checkExistance({
        id: FormService.model.id,
        field: field,
        value: FormService.model[field]
      }, function(response) {
        var element;
        element = $(event.target);
        if (response.exists) {
          FormService.error_element = element;
          return element.addClass('has-error').focus();
        } else {
          FormService.error_element = void 0;
          return element.removeClass('has-error');
        }
      });
    };
    $scope.checkUsefulExistance = function(field, event, value) {
      return Page.checkExistance({
        id: FormService.model.id,
        field: field,
        value: value
      }, function(response) {
        var element;
        element = $(event.target);
        if (!value || response.exists) {
          FormService.error_element = void 0;
          return element.removeClass('has-error');
        } else {
          FormService.error_element = element;
          return element.addClass('has-error').focus();
        }
      });
    };
    $scope.addUseful = function() {
      return FormService.model.useful.push(angular.copy(empty_useful));
    };
    $scope.$watch('FormService.model.station_id', function(newVal, oldVal) {
      return $timeout(function() {
        return $('#sort').selectpicker('refresh');
      });
    });
    return $scope.loadTags = function(text) {
      return Tag.autocomplete({
        text: text
      }).$promise;
    };
  });

}).call(this);

(function() {
  angular.module('Egecms').controller('TagsIndex', function($scope, $attrs, IndexService, ExportService, Tag) {
    bindArguments($scope, arguments);
    ExportService.init({
      controller: 'tags'
    });
    return angular.element(document).ready(function() {
      return IndexService.init(Tag, $scope.current_page, $attrs);
    });
  }).controller('TagsForm', function($scope, $attrs, $timeout, FormService, Tag) {
    bindArguments($scope, arguments);
    return angular.element(document).ready(function() {
      return FormService.init(Tag, $scope.id, $scope.model);
    });
  });

}).call(this);

(function() {
  angular.module('Egecms').controller('VariablesIndex', function($scope, $attrs, IndexService, Variable) {
    bindArguments($scope, arguments);
    return angular.element(document).ready(function() {
      return IndexService.init(Variable, $scope.current_page, $attrs);
    });
  }).controller('VariablesForm', function($scope, $attrs, $timeout, FormService, AceService, Variable) {
    bindArguments($scope, arguments);
    return angular.element(document).ready(function() {
      FormService.init(Variable, $scope.id, $scope.model);
      FormService.dataLoaded.promise.then(function() {
        return AceService.initEditor(FormService, 30);
      });
      return FormService.beforeSave = function() {
        return FormService.model.html = AceService.editor.getValue();
      };
    });
  });

}).call(this);

(function() {


}).call(this);

(function() {


}).call(this);

(function() {
  angular.module('Egecms').directive('ngCounter', function($timeout) {
    return {
      restrict: 'A',
      link: function($scope, $element, $attrs) {
        var counter;
        $($element).parent().append("<span class='input-counter'></span>");
        counter = $($element).parent().find('.input-counter');
        $($element).on('keyup', function() {
          return counter.text($(this).val().length || '');
        });
        return $timeout(function() {
          return $($element).keyup();
        }, 500);
      }
    };
  });

}).call(this);

(function() {


}).call(this);

(function() {


}).call(this);

(function() {
  angular.module('Egecms').directive('ngMulti', function() {
    return {
      restrict: 'E',
      replace: true,
      scope: {
        object: '=',
        model: '=',
        label: '@',
        noneText: '@'
      },
      templateUrl: 'directives/ngmulti',
      controller: function($scope, $element, $attrs, $timeout) {
        return $timeout(function() {
          return $($element).selectpicker({
            noneSelectedText: $scope.noneText
          });
        }, 100);
      }
    };
  });

}).call(this);

(function() {
  angular.module('Egecms').directive('orderBy', function() {
    return {
      restrict: 'E',
      replace: true,
      scope: {
        options: '='
      },
      templateUrl: 'directives/order-by',
      link: function($scope, $element, $attrs) {
        var IndexService, local_storage_key, syncIndexService;
        IndexService = $scope.$parent.IndexService;
        local_storage_key = 'sort-' + IndexService.controller;
        syncIndexService = function(sort) {
          IndexService.sort = sort;
          IndexService.current_page = 1;
          return IndexService.loadPage();
        };
        $scope.sort = localStorage.getItem(local_storage_key);
        if ($scope.sort === null) {
          $scope.setSort(0);
        } else {
          syncIndexService($scope.sort);
        }
        return $scope.setSort = function(sort) {
          $scope.sort = sort;
          localStorage.setItem(local_storage_key, sort);
          return syncIndexService(sort);
        };
      }
    };
  });

}).call(this);

(function() {


}).call(this);

(function() {


}).call(this);

(function() {
  angular.module('Egecms').directive('plural', function() {
    return {
      restrict: 'E',
      scope: {
        count: '=',
        type: '@',
        noneText: '@'
      },
      templateUrl: 'directives/plural',
      controller: function($scope, $element, $attrs, $timeout) {
        $scope.textOnly = $attrs.hasOwnProperty('textOnly');
        $scope.hideZero = $attrs.hasOwnProperty('hideZero');
        return $scope.when = {
          'age': ['год', 'года', 'лет'],
          'student': ['ученик', 'ученика', 'учеников'],
          'minute': ['минуту', 'минуты', 'минут'],
          'hour': ['час', 'часа', 'часов'],
          'day': ['день', 'дня', 'дней'],
          'meeting': ['встреча', 'встречи', 'встреч'],
          'score': ['балл', 'балла', 'баллов'],
          'rubbles': ['рубль', 'рубля', 'рублей'],
          'lesson': ['занятие', 'занятия', 'занятий'],
          'client': ['клиент', 'клиента', 'клиентов'],
          'mark': ['оценки', 'оценок', 'оценок'],
          'request': ['заявка', 'заявки', 'заявок']
        };
      }
    };
  });

}).call(this);

(function() {


}).call(this);

(function() {
  angular.module('Egecms').directive('ngSelectNew', function() {
    return {
      restrict: 'E',
      replace: true,
      scope: {
        object: '=',
        model: '=',
        noneText: '@',
        label: '@',
        field: '@'
      },
      templateUrl: 'directives/select-new',
      controller: function($scope, $element, $attrs, $timeout) {
        var value;
        if (!$scope.noneText) {
          value = _.first(Object.keys($scope.object));
          if ($scope.field) {
            value = $scope.object[value][$scope.field];
          }
          $scope.model = value;
        }
        return $timeout(function() {
          return $($element).selectpicker();
        }, 500);
      }
    };
  });

}).call(this);

(function() {
  angular.module('Egecms').directive('ngSelect', function() {
    return {
      restrict: 'E',
      replace: true,
      scope: {
        object: '=',
        model: '=',
        noneText: '@',
        label: '@',
        field: '@'
      },
      templateUrl: 'directives/ngselect',
      controller: function($scope, $element, $attrs, $timeout) {
        if (!$scope.noneText) {
          if ($scope.field) {
            $scope.model = $scope.object[_.first(Object.keys($scope.object))][$scope.field];
          } else {
            $scope.model = _.first(Object.keys($scope.object));
          }
        }
        return $timeout(function() {
          return $($element).selectpicker();
        }, 150);
      }
    };
  });

}).call(this);

(function() {


}).call(this);

(function() {


}).call(this);

(function() {


}).call(this);

(function() {


}).call(this);

(function() {
  angular.module('Egecms').value('Published', [
    {
      id: 0,
      title: 'не опубликовано'
    }, {
      id: 1,
      title: 'опубликовано'
    }
  ]).value('UpDown', [
    {
      id: 1,
      title: 'вверху'
    }, {
      id: 2,
      title: 'внизу'
    }
  ]);

}).call(this);

(function() {
  angular.module('Egecms').service('AceService', function() {
    this.initEditor = function(FormService, minLines) {
      if (minLines == null) {
        minLines = 30;
      }
      this.editor = ace.edit("editor");
      this.editor.getSession().setMode("ace/mode/html");
      this.editor.getSession().setUseWrapMode(true);
      this.editor.setOptions({
        minLines: minLines,
        maxLines: Infinity
      });
      return this.editor.commands.addCommand({
        name: 'save',
        bindKey: {
          win: 'Ctrl-S',
          mac: 'Command-S'
        },
        exec: function(editor) {
          return FormService.edit();
        }
      });
    };
    return this;
  });

}).call(this);

(function() {
  angular.module('Egecms').service('IndexService', function($rootScope) {
    this.filter = function() {
      $.cookie(this.controller, JSON.stringify(this.search), {
        expires: 365,
        path: '/'
      });
      this.current_page = 1;
      return this.pageChanged();
    };
    this.max_size = 30;
    this.init = function(Resource, current_page, attrs, load_page) {
      if (load_page == null) {
        load_page = true;
      }
      $rootScope.frontend_loading = true;
      this.Resource = Resource;
      this.current_page = parseInt(current_page);
      this.controller = attrs.ngController.toLowerCase().slice(0, -5);
      this.search = $.cookie(this.controller) ? JSON.parse($.cookie(this.controller)) : {};
      if (load_page) {
        return this.loadPage();
      }
    };
    this.loadPage = function() {
      var params;
      params = {
        page: this.current_page
      };
      if (this.sort !== void 0) {
        params.sort = this.sort;
      }
      return this.Resource.get(params, (function(_this) {
        return function(response) {
          _this.page = response;
          return $rootScope.frontend_loading = false;
        };
      })(this));
    };
    this.pageChanged = function() {
      $rootScope.frontend_loading = true;
      this.loadPage();
      return this.changeUrl();
    };
    this.changeUrl = function() {
      return window.history.pushState('', '', this.controller + '?page=' + this.current_page);
    };
    return this;
  }).service('FormService', function($rootScope, $q, $timeout) {
    var beforeSave, modelLoaded, modelName;
    this.init = function(Resource, id, model) {
      this.dataLoaded = $q.defer();
      $rootScope.frontend_loading = true;
      this.Resource = Resource;
      this.saving = false;
      if (id) {
        return this.model = Resource.get({
          id: id
        }, (function(_this) {
          return function() {
            return modelLoaded();
          };
        })(this));
      } else {
        this.model = new Resource(model);
        return modelLoaded();
      }
    };
    modelLoaded = (function(_this) {
      return function() {
        $rootScope.frontend_loading = false;
        return $timeout(function() {
          _this.dataLoaded.resolve(true);
          return $('.selectpicker').selectpicker('refresh');
        });
      };
    })(this);
    beforeSave = (function(_this) {
      return function() {
        if (_this.error_element === void 0) {
          ajaxStart();
          if (_this.beforeSave !== void 0) {
            _this.beforeSave();
          }
          _this.saving = true;
          return true;
        } else {
          $(_this.error_element).focus();
          return false;
        }
      };
    })(this);
    modelName = function() {
      var l, model_name;
      l = window.location.pathname.split('/');
      model_name = l[l.length - 2];
      if ($.isNumeric(model_name)) {
        model_name = l[l.length - 3];
      }
      return model_name;
    };
    this["delete"] = function(event) {
      return bootbox.confirm("Вы уверены, что хотите " + ($(event.target).text()) + " #" + this.model.id + "?", (function(_this) {
        return function(result) {
          if (result === true) {
            beforeSave();
            return _this.model.$delete().then(function() {
              return redirect(modelName());
            });
          }
        };
      })(this));
    };
    this.edit = function() {
      if (!beforeSave()) {
        return;
      }
      return this.model.$update().then((function(_this) {
        return function() {
          _this.saving = false;
          return ajaxEnd();
        };
      })(this));
    };
    this.create = function() {
      if (!beforeSave()) {
        return;
      }
      return this.model.$save().then((function(_this) {
        return function(response) {
          return redirect(modelName() + ("/" + response.id + "/edit"));
        };
      })(this));
    };
    return this;
  });

}).call(this);

(function() {
  angular.module('Egecms').service('ExportService', function($rootScope, FileUploader) {
    bindArguments(this, arguments);
    this.init = function(options) {
      var onWhenAddingFileFailed;
      this.controller = options.controller;
      this.FileUploader.FileSelect.prototype.isEmptyAfterSelection = function() {
        return true;
      };
      return this.uploader = new this.FileUploader({
        url: this.controller + "/import",
        alias: 'imported_file',
        autoUpload: true,
        method: 'post',
        removeAfterUpload: true,
        onCompleteItem: function(i, response, status) {
          if (status === 200) {
            notifySuccess('Импортировано');
          }
          if (status !== 200) {
            return notifyError('Ошибка импорта');
          }
        }
      }, onWhenAddingFileFailed = function(item, filter, options) {
        if (filter.name === "queueLimit") {
          this.clearQueue();
          return this.addToQueue(item);
        }
      });
    };
    this["import"] = function(e) {
      e.preventDefault();
      $('#import-button').trigger('click');
    };
    this.exportDialog = function() {
      $('#export-modal').modal('show');
      return false;
    };
    this["export"] = function() {
      window.location = "/" + this.controller + "/export?field=" + this.export_field;
      $('#export-modal').modal('hide');
      return false;
    };
    return this;
  });

}).call(this);

(function() {
  var apiPath, countable, updatable;

  angular.module('Egecms').factory('Variable', function($resource) {
    return $resource(apiPath('variables'), {
      id: '@id'
    }, updatable());
  }).factory('Tag', function($resource) {
    return $resource(apiPath('tags'), {
      id: '@id'
    }, {
      update: {
        method: 'PUT'
      },
      autocomplete: {
        method: 'GET',
        url: apiPath('tags', 'autocomplete'),
        isArray: true
      }
    });
  }).factory('Page', function($resource) {
    return $resource(apiPath('pages'), {
      id: '@id'
    }, {
      update: {
        method: 'PUT'
      },
      checkExistance: {
        method: 'POST',
        url: apiPath('pages', 'checkExistance')
      }
    });
  });

  apiPath = function(entity, additional) {
    if (additional == null) {
      additional = '';
    }
    return ("api/" + entity + "/") + (additional ? additional + '/' : '') + ":id";
  };

  updatable = function() {
    return {
      update: {
        method: 'PUT'
      }
    };
  };

  countable = function() {
    return {
      count: {
        method: 'GET'
      }
    };
  };

}).call(this);

//# sourceMappingURL=app.js.map
