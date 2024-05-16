/*!
 * Super Simple WYSIWYG Editor - v0.8.18
 * Summernote - https://summernote.org
 * 
 * Copyright 2013- Alan Hong and other contributors
 * Summernote may be freely distributed under the MIT license.
 * 
 * Date: 2023-02-17T14:30Z
 */

(function webpackUniversalModuleDefinition(root, factory) {
  if (typeof exports === 'object' && typeof module === 'object')
    module.exports = factory();
  else if (typeof define === 'function' && define.amd)
    define([], factory);
  else {
    var a = factory();
    for (var i in a) (typeof exports === 'object' ? exports : root)[i] = a[i];
  }
})(window, function() {
  return (function(modules) { // webpackBootstrap
    var installedModules = {};

    function __webpack_require__(moduleId) {
      if (installedModules[moduleId]) {
        return installedModules[moduleId].exports;
      }
      var module = installedModules[moduleId] = {
        i: moduleId,
        l: false,
        exports: {}
      };

      modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);

      module.l = true;

      return module.exports;
    }

    __webpack_require__.m = modules;
    __webpack_require__.c = installedModules;
    __webpack_require__.d = function(exports, name, getter) {
      if (!__webpack_require__.o(exports, name)) {
        Object.defineProperty(exports, name, {
          enumerable: true,
          get: getter
        });
      }
    };

    __webpack_require__.r = function(exports) {
      if (typeof Symbol !== 'undefined' && Symbol.toStringTag) {
        Object.defineProperty(exports, Symbol.toStringTag, {
          value: 'Module'
        });
      }
      Object.defineProperty(exports, '__esModule', {
        value: true
      });
    };

    __webpack_require__.t = function(value, mode) {
      if (mode & 1) value = __webpack_require__(value);
      if (mode & 8) return value;
      if ((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
      var ns = Object.create(null);
      __webpack_require__.r(ns);
      Object.defineProperty(ns, 'default', {
        enumerable: true,
        value: value
      });
      if (mode & 2 && typeof value != 'string')
        for (var key in value) __webpack_require__.d(ns, key, function(key) {
          return value[key];
        }.bind(null, key));
      return ns;
    };

    __webpack_require__.n = function(module) {
      var getter = module && module.__esModule ?
        function getDefault() {
          return module['default'];
        } :
        function getModuleExports() {
          return module;
        };
      __webpack_require__.d(getter, 'a', getter);
      return getter;
    };

    __webpack_require__.o = function(object, property) {
      return Object.prototype.hasOwnProperty.call(object, property);
    };

    __webpack_require__.p = "";

    return __webpack_require__(__webpack_require__.s = 21);
  })(
    /************************************************************************/
    ({
      21:
      /***/ function(module, exports) {

        (function($) {
          $.extend($.summernote.lang, {
            'he-IL': {
              font: {
                bold: 'מודגש',
                italic: 'נטוי',
                underline: 'קו תחתון',
                clear: 'נקה עיצוב',
                height: 'גובה',
                name: 'גופן',
                strikethrough: 'קו חוצה',
                subscript: 'כתב תחתי',
                superscript: 'כתב עילי',
                size: 'גודל גופן'
              },
              image: {
                image: 'תמונה',
                insert: 'הוסף תמונה',
                resizeFull: 'גודל מלא',
                resizeHalf: 'להקטין לחצי',
                resizeQuarter: 'להקטין לרבע',
                floatLeft: 'יישור לשמאל',
                floatRight: 'יישור לימין',
                floatNone: 'ישר',
                shapeRounded: 'Shape: Rounded',
                shapeCircle: 'Shape: Circle',
                shapeThumbnail: 'Shape: Thumbnail',
                shapeNone: 'Shape: None',
                dragImageHere: 'גרור תמונה לכאן',
                dropImage: 'Drop image or Text',
                selectFromFiles: 'בחר מתוך קבצים',
                maximumFileSize: 'Maximum file size',
                maximumFileSizeError: 'Maximum file size exceeded.',
                url: 'נתיב לתמונה',
                remove: 'הסר תמונה',
                original: 'Original'
              },
              video: {
                video: 'סרטון',
                videoLink: 'קישור לסרטון',
                insert: 'הוסף סרטון',
                url: 'קישור לסרטון',
                providers: '(YouTube, Vimeo, Vine, Instagram, DailyMotion או Youku)'
              },
              link: {
                link: 'קישור',
                insert: 'הוסף קישור',
                unlink: 'הסר קישור',
                edit: 'ערוך',
                textToDisplay: 'טקסט להציג',
                url: 'קישור',
                openInNewWindow: 'פתח בחלון חדש'
              },
              table: {
                table: 'טבלה',
                addRowAbove: 'Add row above',
                addRowBelow: 'Add row below',
                addColLeft: 'Add column left',
                addColRight: 'Add column right',
                delRow: 'Delete row',
                delCol: 'Delete column',
                delTable: 'Delete table'
              },
              hr: {
                insert: 'הוסף קו'
              },
              style: {
                style: 'עיצוב',
                p: 'טקסט רגיל',
                blockquote: 'ציטוט',
                pre: 'קוד',
                h1: 'כותרת 1',
                h2: 'כותרת 2',
                h3: 'כותרת 3',
                h4: 'כותרת 4',
                h5: 'כותרת 5',
                h6: 'כותרת 6'
              },
              lists: {
                unordered: 'רשימת תבליטים',
                ordered: 'רשימה ממוספרת'
              },
              options: {
                help: 'עזרה',
                fullscreen: 'מסך מלא',
                codeview: 'תצוגת קוד'
              },
              paragraph: {
                paragraph: 'פסקה',
                outdent: 'הקטן כניסה',
                indent: 'הגדל כניסה',
                left: 'יישור לשמאל',
                center: 'יישור למרכז',
                right: 'יישור לימין',
                justify: 'מיושר'
              },
              color: {
                recent: 'צבע טקסט אחרון',
                more: 'עוד צבעים',
                background: 'צבע רקע',
                foreground: 'צבע טקסט',
                transparent: 'שקוף',
                setTransparent: 'קבע כשקוף',
                reset: 'איפוס',
                resetToDefault: 'אפס לברירת מחדל'
              },
              shortcut: {
                shortcuts: 'קיצורי מקלדת',
                close: 'סגור',
                textFormatting: 'עיצוב הטקסט',
                action: 'פעולה',
                paragraphFormatting: 'סגנונות פסקה',
                documentStyle: 'עיצוב המסמך',
                extraKeys: 'קיצורים נוספים'
              },
              help: {
                'insertParagraph': 'Insert Paragraph',
                'undo': 'Undoes the last command',
                'redo': 'Redoes the last command',
                'tab': 'Tab',
                'untab': 'Untab',
                'bold': 'Set a bold style',
                'italic': 'Set a italic style',
                'underline': 'Set a underline style',
                'strikethrough': 'Set a strikethrough style',
                'removeFormat': 'Clean a style',
                'justifyLeft': 'Set left align',
                'justifyCenter': 'Set center align',
                'justifyRight': 'Set right align',
                'justifyFull': 'Set full align',
                'insertUnorderedList': 'Toggle unordered list',
                'insertOrderedList': 'Toggle ordered list',
                'outdent': 'Outdent on current paragraph',
                'indent': 'Indent on current paragraph',
                'formatPara': 'Change current block\'s format as a paragraph(P tag)',
                'formatH1': 'Change current block\'s format as H1',
                'formatH2': 'Change current block\'s format as H2',
                'formatH3': 'Change current block\'s format as H3',
                'formatH4': 'Change current block\'s format as H4',
                'formatH5': 'Change current block\'s format as H5',
                'formatH6': 'Change current block\'s format as H6',
                'insertHorizontalRule': 'Insert horizontal rule',
                'linkDialog.show': 'Show Link Dialog'
              },
              history: {
                undo: 'בטל פעולה',
                redo: 'בצע שוב'
              },
              specialChar: {
                specialChar: 'SPECIAL CHARACTERS',
                select: 'Select Special characters'
              }
            }
          });
        })(jQuery);

        /***/
      }
    })
  );
});
