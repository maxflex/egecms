(function() {
  var indexOf = [].indexOf || function(item) { for (var i = 0, l = this.length; i < l; i++) { if (i in this && this[i] === item) return i; } return -1; };

  angular.module("Egecms", ['ngSanitize', 'ngResource', 'ngAnimate', 'ui.sortable', 'ui.bootstrap', 'angular-ladda', 'angularFileUpload', 'angucomplete-alt', 'ngDrag']).config([
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
  var logout_interval;

  logout_interval = false;

  window.logoutCountdownClose = function() {
    clearInterval(logout_interval);
    logout_interval = false;
    return $('#logout-modal').modal('hide');
  };

  window.logoutCountdown = function() {
    var seconds;
    seconds = 60;
    $('#logout-seconds').html(seconds);
    $('#logout-modal').modal('show');
    return logout_interval = setInterval(function() {
      seconds--;
      $('#logout-seconds').html(seconds);
      if (seconds <= 1) {
        clearInterval(logout_interval);
        return setTimeout(function() {
          return location.reload();
        }, 1000);
      }
    }, 1000);
  };

  window.continueSession = function() {
    $.get("/auth/continue-session");
    return logoutCountdownClose();
  };

  window.listenToSession = function(app_key, user_id) {
    var channel, pusher;
    pusher = new Pusher(app_key, {
      cluster: 'eu'
    });
    channel = pusher.subscribe('session.' + user_id);
    return channel.bind("App\\Events\\LogoutSignal", function(data) {
      switch (data.action) {
        case 'notify':
          return logoutCountdown();
        case 'destroy':
          return redirect('/logout');
      }
    });
  };

}).call(this);

(function() {


}).call(this);

(function() {
  angular.module('Egecms').controller('LoginCtrl', function($scope, $http) {
    var loadImage;
    loadImage = function() {
      var img;
      $scope.image_loaded = false;
      img = new Image;
      img.addEventListener("load", function() {
        $('body').css({
          'background-image': "url(" + $scope.wallpaper.image_url + ")"
        });
        $scope.image_loaded = true;
        $scope.$apply();
        return setTimeout(function() {
          return $('#center').removeClass('animated').removeClass('fadeIn').removeAttr('style');
        }, 2000);
      });
      return img.src = $scope.wallpaper.image_url;
    };
    angular.element(document).ready(function() {
      var login_data;
      loadImage();
      $('input[autocomplete="off"]').each(function() {
        var id, input;
        input = this;
        id = $(input).attr('id');
        $(input).removeAttr('id');
        return setTimeout(function() {
          return $(input).attr('id', id);
        }, 2000);
      });
      $scope.l = Ladda.create(document.querySelector('#login-submit'));
      if ($scope.logged_user) {
        $scope.login = $scope.logged_user.email;
      }
      login_data = $.cookie("login_data");
      if (login_data !== void 0) {
        login_data = JSON.parse(login_data);
        $scope.login = login_data.login;
        $scope.password = login_data.password;
        $scope.sms_verification = true;
        return $scope.$apply();
      }
    });
    $scope.enter = function($event) {
      if ($event.keyCode === 13) {
        return $scope.checkFields();
      }
    };
    $scope.clearLogged = function() {
      $scope.logged_user = null;
      $scope.login = '';
      return $.removeCookie('logged_user');
    };
    $scope.goLogin = function() {
      if ($scope.preview) {
        return;
      }
      return $http.post('login', {
        login: $scope.login,
        password: $scope.password,
        code: $scope.code,
        captcha: grecaptcha.getResponse()
      }).then(function(response) {
        grecaptcha.reset();
        if (response.data === true) {
          $.removeCookie('login_data');
          location.reload();
        } else if (response.data === 'sms') {
          $scope.in_process = false;
          $scope.l.stop();
          $scope.sms_verification = true;
          $.cookie("login_data", JSON.stringify({
            login: $scope.login,
            password: $scope.password
          }), {
            expires: 1 / (24 * 60) * 2,
            path: '/'
          });
        } else {
          $scope.in_process = false;
          $scope.l.stop();
          $scope.error = "Неправильная пара логин-пароль";
        }
        return $scope.$apply();
      });
    };
    return $scope.checkFields = function() {
      if ($scope.preview) {
        return;
      }
      $scope.l.start();
      $scope.in_process = true;
      if (grecaptcha.getResponse() === '') {
        return grecaptcha.execute();
      } else {
        return $scope.goLogin();
      }
    };
  });

}).call(this);

(function() {
  angular.module('Egecms').controller('PagesIndex', function($scope, $attrs, $timeout, IndexService, Page, Published, ExportService) {
    bindArguments($scope, arguments);
    ExportService.init({
      controller: 'pages'
    });
    return angular.element(document).ready(function() {
      return IndexService.init(Page, $scope.current_page, $attrs, false);
    });
  }).controller('PagesForm', function($scope, $http, $attrs, $timeout, FormService, AceService, Page, Published, UpDown, Anchor) {
    bindArguments($scope, arguments);
    angular.element(document).ready(function() {
      FormService.init(Page, $scope.id, $scope.model);
      FormService.dataLoaded.promise.then(function() {
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
    $scope.addLinkDialog = function() {
      $scope.link_text = AceService.editor.getSelectedText();
      return $('#link-manager').modal('show');
    };
    $scope.search = function(input, promise) {
      return $http.post('api/pages/search', {
        q: input
      }, {
        timeout: promise
      }).then(function(response) {
        return response;
      });
    };
    $scope.searchSelected = function(selectedObject) {
      if (selectedObject !== void 0) {
        $scope.link_page_id = selectedObject.originalObject.id;
      }
      return $scope.$broadcast('angucomplete-alt:changeInput', 'page-search', $scope.link_page_id.toString());
    };
    $scope.searchSelected2 = function(selectedObject) {
      if (selectedObject !== void 0) {
        return FormService.model.anchor_page_id = selectedObject.originalObject.id;
      }
    };
    $scope.$watch('FormService.model.anchor_page_id', function(newVal, oldVal) {
      if (newVal === void 0) {
        return;
      }
      if (newVal === null) {
        $scope.$broadcast('angucomplete-alt:clearInput', 'page-search-2');
      } else {
        $scope.$broadcast('angucomplete-alt:changeInput', 'page-search-2', newVal.toString());
      }
      return $timeout(function() {
        return $scope.$apply();
      });
    });
    $scope.addLink = function() {
      var link;
      link = "<a href='[link|" + $scope.link_page_id + "]'>" + $scope.link_text + "</a>";
      $scope.link_page_id = void 0;
      $scope.$broadcast('angucomplete-alt:clearInput');
      AceService.editor.session.replace(AceService.editor.selection.getRange(), link);
      return $('#link-manager').modal('hide');
    };
    return $scope.$watch('FormService.model.station_id', function(newVal, oldVal) {
      return $timeout(function() {
        return $('#sort').selectpicker('refresh');
      });
    });
  });

}).call(this);

(function() {
  angular.module('Egecms').controller('SassIndex', function($scope, $attrs, IndexService, Sass) {
    bindArguments($scope, arguments);
    return angular.element(document).ready(function() {
      return IndexService.init(Sass, $scope.current_page, $attrs);
    });
  }).controller('SassForm', function($scope, FormService, AceService, Sass) {
    bindArguments($scope, arguments);
    return angular.element(document).ready(function() {
      FormService.init(Sass, $scope.id, $scope.model);
      FormService.dataLoaded.promise.then(function() {
        return AceService.initEditor(FormService, 30, 'editor', 'ace/mode/css');
      });
      return FormService.beforeSave = function() {
        return FormService.model.text = AceService.editor.getValue();
      };
    });
  });

}).call(this);

(function() {
  angular.module('Egecms').controller('SearchIndex', function($scope, $attrs, $timeout, IndexService, Page, Published, ExportService) {
    bindArguments($scope, arguments);
    ExportService.init({
      controller: 'pages'
    });
    return angular.element(document).ready(function() {
      return IndexService.init(Page, $scope.current_page, $attrs, false);
    });
  });

}).call(this);

(function() {
  angular.module('Egecms').controller('VariablesIndex', function($scope, $attrs, $timeout, IndexService, Variable, VariableGroup) {
    bindArguments($scope, arguments);
    angular.element(document).ready(function() {
      return IndexService.init(Variable, $scope.current_page, $attrs);
    });
    $scope.dnd = {};
    $scope.dragStart = function(variable_id) {
      return $timeout(function() {
        console.log('drag start', variable_id);
        return $scope.dnd.variable_id = variable_id;
      });
    };
    $scope.drop = function(group_id) {
      var variable_id;
      if (group_id === -1) {
        variable_id = $scope.dnd.variable_id;
        VariableGroup.save({
          variable_id: variable_id
        }, function(response) {
          $scope.groups.push(response);
          return IndexService.page.data.find(function(variable) {
            return variable.id === variable_id;
          }).group_id = response.id;
        });
      } else if (group_id) {
        Variable.update({
          id: $scope.dnd.variable_id,
          group_id: group_id
        });
        IndexService.page.data.find(function(variable) {
          return variable.id === $scope.dnd.variable_id;
        }).group_id = group_id;
      }
      return $scope.dnd = {};
    };
    $scope.getVariables = function(group_id) {
      if (IndexService.page) {
        return IndexService.page.data.filter(function(d) {
          return d.group_id === group_id;
        });
      }
    };
    $scope.getVariable = function(variable_id) {
      return _.findWhere(IndexService.page.data, {
        id: parseInt(variable_id)
      });
    };
    $scope.removeGroup = function(group) {
      return bootbox.confirm("Вы уверены, что хотите удалить группу «" + group.title + "»", function(response) {
        if (response === true) {
          VariableGroup.remove({
            id: group.id
          });
          $scope.groups = removeById($scope.groups, group.id);
          return _.where(IndexService.page.data, {
            group_id: group.id
          }).forEach(function(variable) {
            return variable.group_id = null;
          });
        }
      });
    };
    return $scope.onEdit = function(id, event) {
      return VariableGroup.update({
        id: id,
        title: $(event.target).text()
      });
    };
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
  angular.module('Egecms').directive('editable', function() {
    return {
      restrict: 'A',
      link: function($scope, $element, $attrs) {
        return $element.on('click', function(event) {
          return $element.attr('contenteditable', 'true').focus();
        }).on('keydown', function(event) {
          var ref;
          if ((ref = event.keyCode) === 13 || ref === 27) {
            event.preventDefault();
            return $element.blur();
          }
        }).on('blur', function(event) {
          $scope.onEdit($element.attr('editable'), event);
          return $element.removeAttr('contenteditable');
        });
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
        $element.selectpicker({
          noneSelectedText: $scope.noneText
        });
        return $scope.$watchGroup(['model', 'object'], function(newVal) {
          if (newVal) {
            return $element.selectpicker('refresh');
          }
        });
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
        $scope.setSort = function(sort) {
          $scope.sort = sort;
          localStorage.setItem(local_storage_key, sort);
          return syncIndexService(sort);
        };
        $scope.sort = localStorage.getItem(local_storage_key);
        if ($scope.sort === null) {
          return $scope.setSort(0);
        } else {
          return syncIndexService($scope.sort);
        }
      }
    };
  });

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
  angular.module('Egecms').directive('search', function() {
    return {
      restrict: 'E',
      templateUrl: 'directives/search',
      scope: {},
      link: function() {
        return $('.search-icon').on('click', function() {
          return $('#search-app').modal('show');
        });
      },
      controller: function($scope, $timeout, $http, Published, FactoryService) {
        bindArguments($scope, arguments);
        $scope.conditions = [];
        $scope.options = [
          {
            title: 'ключевая фраза',
            value: 'keyphrase',
            type: 'text'
          }, {
            title: 'отображаемый URL',
            value: 'url',
            type: 'text'
          }, {
            title: 'title',
            value: 'title',
            type: 'text'
          }, {
            title: 'публикация',
            value: 'published',
            type: 'published'
          }, {
            title: 'h1 вверху',
            value: 'h1',
            type: 'text'
          }, {
            title: 'h1 внизу',
            value: 'h1_bottom',
            type: 'text'
          }, {
            title: 'meta keywords',
            value: 'keywords',
            type: 'text'
          }, {
            title: 'meta description',
            value: 'desc',
            type: 'text'
          }, {
            title: 'предметы',
            value: 'subjects',
            type: 'subjects'
          }, {
            title: 'приоритет',
            value: 'priority',
            type: 'priority'
          }, {
            title: 'метро',
            value: 'station_id',
            type: 'station_id'
          }, {
            title: 'скрытый фильтр',
            value: 'hidden_filter',
            type: 'text'
          }, {
            title: 'содержание раздела',
            value: 'html',
            type: 'textarea'
          }
        ];
        $scope.getOption = function(condition) {
          return $scope.options[condition.option];
        };
        $scope.addCondition = function() {
          $scope.conditions.push({
            option: 0
          });
          return $timeout(function() {
            return $('.selectpicker').selectpicker();
          });
        };
        $scope.addCondition();
        $scope.selectControl = function(condition) {
          condition.value = null;
          switch ($scope.getOption(condition).type) {
            case 'published':
              return condition.value = 0;
            case 'subjects':
              if ($scope.subjects === void 0) {
                return FactoryService.get('subjects', 'name').then(function(response) {
                  return $scope.subjects = response.data;
                });
              }
              break;
            case 'priority':
              if ($scope.priorities === void 0) {
                return FactoryService.get('priorities', 'title').then(function(response) {
                  return $scope.priorities = response.data;
                });
              }
              break;
            case 'station_id':
              if ($scope.stations === void 0) {
                return FactoryService.get('stations', 'title', 'title').then(function(response) {
                  return $scope.stations = response.data;
                });
              }
          }
        };
        return $scope.search = function() {
          var search;
          search = {};
          $scope.conditions.forEach(function(condition) {
            return search[$scope.getOption(condition).value] = condition.value;
          });
          if (search.hasOwnProperty('html')) {
            search.html = search.html.substr(0, 200);
          }
          $.cookie('search', JSON.stringify(search), {
            expires: 365,
            path: '/'
          });
          ajaxStart();
          $scope.searching = true;
          return window.location = 'search';
        };
      }
    };
  });

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
          if (!$scope.model) {
            $scope.model = value;
          }
        }
        $timeout(function() {
          return $element.selectpicker({
            noneSelectedText: $scope.noneText
          });
        }, 100);
        return $scope.$watchGroup(['model', 'object'], function(newVal) {
          if (newVal) {
            return $timeout(function() {
              return $element.selectpicker('refresh');
            });
          }
        });
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
  ]).value('Anchor', [
    {
      id: 1,
      title: 'главная – блок 1'
    }, {
      id: 2,
      title: 'главная – блок 2'
    }, {
      id: 3,
      title: 'главная – блок 3'
    }, {
      id: 4,
      title: 'раздел...'
    }
  ]);

}).call(this);

(function() {
  var apiPath, countable, updatable;

  angular.module('Egecms').factory('Variable', function($resource) {
    return $resource(apiPath('variables'), {
      id: '@id'
    }, updatable());
  }).factory('VariableGroup', function($resource) {
    return $resource(apiPath('variables/groups'), {
      id: '@id'
    }, updatable());
  }).factory('Sass', function($resource) {
    return $resource(apiPath('sass'), {
      id: '@id'
    }, updatable());
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

(function() {
  angular.module('Egecms').service('AceService', function() {
    this.initEditor = function(FormService, minLines, id, mode) {
      if (minLines == null) {
        minLines = 30;
      }
      if (id == null) {
        id = 'editor';
      }
      if (mode == null) {
        mode = 'ace/mode/html';
      }
      this.editor = ace.edit(id);
      this.editor.getSession().setMode(mode);
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
    this.max_size = 10;
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
      })(this), function(response) {
        notifyError(response.data);
        this.saving = false;
        return ajaxEnd();
      });
    };
    this.create = function() {
      if (!beforeSave()) {
        return;
      }
      return this.model.$save().then((function(_this) {
        return function(response) {
          return redirect(modelName() + ("/" + response.id + "/edit"));
        };
      })(this), (function(_this) {
        return function(response) {
          _this.saving = false;
          ajaxEnd();
          return _this.onCreateError(response);
        };
      })(this));
    };
    return this;
  });

}).call(this);

(function() {
  angular.module('Egecms').service('ExportService', function($rootScope, FileUploader) {
    bindArguments(this, arguments);
    this.export_fields = [];
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
      window.location = "/" + this.controller + "/export?fields=" + (this.export_fields.join(','));
      $('#export-modal').modal('hide');
      return false;
    };
    return this;
  });

}).call(this);

(function() {
  angular.module('Egecms').service('FactoryService', function($http) {
    this.get = function(table, select, orderBy) {
      if (select == null) {
        select = null;
      }
      if (orderBy == null) {
        orderBy = null;
      }
      return $http.post('api/factory', {
        table: table,
        select: select,
        orderBy: orderBy
      });
    };
    return this;
  });

}).call(this);

//# sourceMappingURL=app.js.map
