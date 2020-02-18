/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/web/app/mu-plugins";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./scripts/Components/NSIContactForm.jsx":
/*!***********************************************!*\
  !*** ./scripts/Components/NSIContactForm.jsx ***!
  \***********************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _NsiContactFormField__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./NsiContactFormField */ "./scripts/Components/NsiContactFormField.jsx");
function _typeof(obj) { "@babel/helpers - typeof"; if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

function _extends() { _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; }; return _extends.apply(this, arguments); }

function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance"); }

function _iterableToArray(iter) { if (Symbol.iterator in Object(iter) || Object.prototype.toString.call(iter) === "[object Arguments]") return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) { for (var i = 0, arr2 = new Array(arr.length); i < arr.length; i++) { arr2[i] = arr[i]; } return arr2; } }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

function _possibleConstructorReturn(self, call) { if (call && (_typeof(call) === "object" || typeof call === "function")) { return call; } return _assertThisInitialized(self); }

function _getPrototypeOf(o) { _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) { return o.__proto__ || Object.getPrototypeOf(o); }; return _getPrototypeOf(o); }

function _assertThisInitialized(self) { if (self === void 0) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function"); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, writable: true, configurable: true } }); if (superClass) _setPrototypeOf(subClass, superClass); }

function _setPrototypeOf(o, p) { _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) { o.__proto__ = p; return o; }; return _setPrototypeOf(o, p); }



var NSIContactForm =
/*#__PURE__*/
function (_React$Component) {
  _inherits(NSIContactForm, _React$Component);

  function NSIContactForm(props) {
    var _this;

    _classCallCheck(this, NSIContactForm);

    _this = _possibleConstructorReturn(this, _getPrototypeOf(NSIContactForm).call(this, props));
    _this.state = {
      message: null,
      fields: [],
      progress: 1
    };

    _this.getFields();

    _this.progressChange = _this.progressChange.bind(_assertThisInitialized(_this));
    return _this;
  }

  _createClass(NSIContactForm, [{
    key: "getFields",
    value: function getFields() {
      var _this2 = this;

      jQuery.ajax({
        url: nsi_contact_form.fields_rest_route + this.props.formid,
        method: 'get',
        xhrFields: {
          onprogress: this.progressChange
        },
        success: function success(datas) {
          _this2.setState({
            fields: datas.fields.map(function (field) {
              switch (field.type) {
                case 'checkbox':
                case 'radio':
                  field.value = {};

                  for (var choice in field.choices) {
                    field.value[field.choices[choice].name] = false;
                  }

                  ;
                  break;

                case 'select':
                  field.value = field.choices[0].name;

                default:
                  field.values = null;
              }

              return field;
            }),
            message: null,
            progress: null
          });
        }
      });
    }
  }, {
    key: "onFieldChange",
    value: function onFieldChange(event, key) {
      var fields = _toConsumableArray(this.state.fields);

      switch (fields[key].type) {
        case 'checkbox':
          fields[key].value[event.currentTarget.value] = event.currentTarget.checked;
          break;

        case 'radio':
          for (var val in fields[key].value) {
            fields[key].value[val] = false;

            if (event.currentTarget.value == val && event.currentTarget.checked) {
              fields[key].value[val] = true;
            }
          }

          break;

        case 'file':
          fields[key].value = event.currentTarget.files[0];
          break;

        default:
          fields[key].value = event.currentTarget.value;
      }

      console.log(fields);
      this.setState({
        fields: fields
      });
    }
  }, {
    key: "onSubmit",
    value: function onSubmit(event) {
      var _this3 = this;

      event.preventDefault();
      this.setState({
        progress: 1
      });

      if (nsi_contact_form.recaptcha_public && grecaptcha) {
        grecaptcha.execute(nsi_contact_form.recaptcha_public, {
          action: 'homepage'
        }).then(function (token) {
          _this3.sendForm(token);
        });
      } else {
        this.sendForm();
      }
    }
  }, {
    key: "sendForm",
    value: function sendForm(token) {
      var _this4 = this;

      var data = new FormData();
      var _iteratorNormalCompletion = true;
      var _didIteratorError = false;
      var _iteratorError = undefined;

      try {
        for (var _iterator = this.state.fields[Symbol.iterator](), _step; !(_iteratorNormalCompletion = (_step = _iterator.next()).done); _iteratorNormalCompletion = true) {
          var field = _step.value;

          switch (field.type) {
            case 'file':
              if (field.value) {
                data.append(field.uuid, field.value, field.value.name);
              } else {
                data.append(field.uuid, null);
              }

              break;

            default:
              data.append(field.uuid, field.value);
          }
        }
      } catch (err) {
        _didIteratorError = true;
        _iteratorError = err;
      } finally {
        try {
          if (!_iteratorNormalCompletion && _iterator["return"] != null) {
            _iterator["return"]();
          }
        } finally {
          if (_didIteratorError) {
            throw _iteratorError;
          }
        }
      }

      if (token) {
        data.append('recaptcha_response', token);
      }

      console.log(data);
      jQuery.ajax({
        url: nsi_contact_form.ajax_url,
        method: 'post',
        data: data,
        cache: false,
        processData: false,
        contentType: false,
        async: true,
        xhr: function xhr() {
          var myXhr = jQuery.ajaxSettings.xhr();
          console.log(myXhr);

          if (myXhr.upload) {
            myXhr.upload.addEventListener('progress', _this4.progressChange, false);
          }

          return myXhr;
        },
        success: function success(datas) {
          _this4.setState({
            progress: null,
            fields: [],
            message: React.createElement("div", {
              className: "alert alert-".concat(datas.data.type)
            }, React.createElement("strong", null, datas.data.title), React.createElement("br", null), datas.data.message)
          });
        }
      });
    }
  }, {
    key: "progressChange",
    value: function progressChange(evt) {
      console.log(evt);

      if (evt.lengthComputable) {
        var newValue = evt.loaded / evt.total * 100;
        this.setState({
          progress: newValue
        });
      }
    }
  }, {
    key: "render",
    value: function render() {
      var _this5 = this;

      var _this$state = this.state,
          message = _this$state.message,
          fields = _this$state.fields,
          progress = _this$state.progress;

      if (progress) {
        return React.createElement("progress", {
          value: progress,
          max: "100"
        });
      } else {
        var ret = [];

        if (message) {
          ret.push(message);
        }

        ret.push(React.createElement("form", {
          onSubmit: function onSubmit(e) {
            return _this5.onSubmit(e);
          }
        }, fields.map(function (attr, index) {
          return React.createElement(_NsiContactFormField__WEBPACK_IMPORTED_MODULE_0__["default"], _extends({
            key: index,
            onChange: function onChange(e, k) {
              _this5.onFieldChange(e, k);
            },
            index: index
          }, attr));
        })));
        return ret;
      }
    }
  }]);

  return NSIContactForm;
}(React.Component);

/* harmony default export */ __webpack_exports__["default"] = (NSIContactForm);

/***/ }),

/***/ "./scripts/Components/NsiContactFormField.jsx":
/*!****************************************************!*\
  !*** ./scripts/Components/NsiContactFormField.jsx ***!
  \****************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return NsiContactFormField; });
function _typeof(obj) { "@babel/helpers - typeof"; if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

function _extends() { _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; }; return _extends.apply(this, arguments); }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

function _possibleConstructorReturn(self, call) { if (call && (_typeof(call) === "object" || typeof call === "function")) { return call; } return _assertThisInitialized(self); }

function _assertThisInitialized(self) { if (self === void 0) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return self; }

function _getPrototypeOf(o) { _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) { return o.__proto__ || Object.getPrototypeOf(o); }; return _getPrototypeOf(o); }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function"); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, writable: true, configurable: true } }); if (superClass) _setPrototypeOf(subClass, superClass); }

function _setPrototypeOf(o, p) { _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) { o.__proto__ = p; return o; }; return _setPrototypeOf(o, p); }

var NsiContactFormField =
/*#__PURE__*/
function (_React$Component) {
  _inherits(NsiContactFormField, _React$Component);

  function NsiContactFormField() {
    _classCallCheck(this, NsiContactFormField);

    return _possibleConstructorReturn(this, _getPrototypeOf(NsiContactFormField).apply(this, arguments));
  }

  _createClass(NsiContactFormField, [{
    key: "render",
    value: function render() {
      var _this = this;

      var attr = {};
      this.props.attributes.map(function (attribute) {
        attr[attribute.name] = attribute.content;
      });

      switch (this.props.type) {
        case 'text':
        case 'email':
          return React.createElement("div", {
            className: "field-group"
          }, React.createElement("label", {
            htmlFor: this.props.uuid
          }, this.props.name), React.createElement("input", _extends({
            type: this.props.type,
            value: this.props.value,
            onChange: function onChange(e) {
              _this.props.onChange(e, _this.props.index);
            },
            id: this.props.uuid,
            name: this.props.uuid
          }, attr, {
            required: this.props.required
          })));

        case 'file':
          return React.createElement("div", {
            className: "field-group"
          }, React.createElement("label", {
            htmlFor: this.props.uuid
          }, this.props.name), React.createElement("input", _extends({
            type: this.props.type,
            onChange: function onChange(e) {
              _this.props.onChange(e, _this.props.index);
            },
            id: this.props.uuid,
            name: this.props.uuid
          }, attr, {
            required: this.props.required
          })));

        case 'textarea':
          return React.createElement("div", {
            className: "field-group"
          }, React.createElement("label", {
            htmlFor: this.props.uuid
          }, this.props.name), React.createElement("textarea", _extends({
            id: this.props.uuid,
            value: this.props.value,
            name: this.props.uuid,
            onChange: function onChange(e) {
              _this.props.onChange(e, _this.props.index);
            }
          }, attr)));

        case 'select':
          return React.createElement("div", {
            className: "field-group"
          }, React.createElement("label", {
            htmlFor: this.props.uuid
          }, this.props.name), React.createElement("select", _extends({
            id: this.props.uuid,
            name: this.props.uuid,
            value: this.props.value,
            onChange: function onChange(e) {
              _this.props.onChange(e, _this.props.index);
            }
          }, attr), this.props.choices.map(function (choice, index) {
            return React.createElement("option", {
              key: index
            }, choice.name);
          })));

        case 'checkbox':
        case 'radio':
          return React.createElement("div", {
            className: "field-group"
          }, React.createElement("label", {
            htmlFor: this.props.uuid
          }, this.props.name), this.props.choices.map(function (choice, index) {
            return React.createElement("div", {
              className: "input-group",
              key: index
            }, React.createElement("input", _extends({
              id: "".concat(_this.props.uuid, "_").concat(index),
              onChange: function onChange(e) {
                _this.props.onChange(e, _this.props.index);
              },
              type: _this.props.type,
              name: _this.props.uuid + '[]',
              value: choice.name,
              checked: _this.props.value[choice.name]
            }, attr)), React.createElement("label", {
              htmlFor: "".concat(_this.props.uuid, "_").concat(index)
            }, choice.name));
          }));

        case 'button':
          return React.createElement("div", {
            className: "field-group"
          }, React.createElement("button", _extends({
            type: attr.type ? attr.type : 'submit'
          }, attr), this.props.name));

        case 'hidden':
          return null;
      }
    }
  }]);

  return NsiContactFormField;
}(React.Component);



/***/ }),

/***/ "./scripts/main.jsx":
/*!**************************!*\
  !*** ./scripts/main.jsx ***!
  \**************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Components_NSIContactForm__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Components/NSIContactForm */ "./scripts/Components/NSIContactForm.jsx");

console.log(document.getElementsByClassName(nsi_contact_form.widget_class));
var _iteratorNormalCompletion = true;
var _didIteratorError = false;
var _iteratorError = undefined;

try {
  for (var _iterator = document.getElementsByClassName(nsi_contact_form.widget_class)[Symbol.iterator](), _step; !(_iteratorNormalCompletion = (_step = _iterator.next()).done); _iteratorNormalCompletion = true) {
    var item = _step.value;
    console.log(item);
    ReactDOM.render(React.createElement(_Components_NSIContactForm__WEBPACK_IMPORTED_MODULE_0__["default"], item.dataset), item);
  }
} catch (err) {
  _didIteratorError = true;
  _iteratorError = err;
} finally {
  try {
    if (!_iteratorNormalCompletion && _iterator["return"] != null) {
      _iterator["return"]();
    }
  } finally {
    if (_didIteratorError) {
      throw _iteratorError;
    }
  }
}

/***/ }),

/***/ "./styles/main.scss":
/*!**************************!*\
  !*** ./styles/main.scss ***!
  \**************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

// extracted by mini-css-extract-plugin

/***/ }),

/***/ 0:
/*!***************************************************!*\
  !*** multi ./scripts/main.jsx ./styles/main.scss ***!
  \***************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! ./scripts/main.jsx */"./scripts/main.jsx");
module.exports = __webpack_require__(/*! ./styles/main.scss */"./styles/main.scss");


/***/ })

/******/ });
//# sourceMappingURL=main.js.map