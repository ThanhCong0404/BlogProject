(function(factory) {
  if (typeof define === 'function' && define.amd) {
    define(['jquery'], factory);
  } else if (typeof module === 'object' && module.exports) {
    module.exports = factory(require('jquery'));
  } else {
    factory(window.jQuery);
  }
}(function($) {
  const specialCharDataSet = [
    '&quot;', '&amp;', '&lt;', '&gt;', '&iexcl;', '&cent;',
    '&pound;', '&curren;', '&yen;', '&brvbar;', '&sect;',
    '&uml;', '&copy;', '&ordf;', '&laquo;', '&not;',
    '&reg;', '&macr;', '&deg;', '&plusmn;', '&sup2;',
    '&sup3;', '&acute;', '&micro;', '&para;', '&middot;',
    '&cedil;', '&sup1;', '&ordm;', '&raquo;', '&frac14;',
    '&frac12;', '&frac34;', '&iquest;', '&times;', '&divide;',
    '&fnof;', '&circ;', '&tilde;', '&ndash;', '&mdash;',
    '&lsquo;', '&rsquo;', '&sbquo;', '&ldquo;', '&rdquo;',
    '&bdquo;', '&dagger;', '&Dagger;', '&bull;', '&hellip;',
    '&permil;', '&prime;', '&Prime;', '&lsaquo;', '&rsaquo;',
    '&oline;', '&frasl;', '&euro;', '&image;', '&weierp;',
    '&real;', '&trade;', '&alefsym;', '&larr;', '&uarr;',
    '&rarr;', '&darr;', '&harr;', '&crarr;', '&lArr;',
    '&uArr;', '&rArr;', '&dArr;', '&hArr;', '&forall;',
    '&part;', '&exist;', '&empty;', '&nabla;', '&isin;',
    '&notin;', '&ni;', '&prod;', '&sum;', '&minus;',
    '&lowast;', '&radic;', '&prop;', '&infin;', '&ang;',
    '&and;', '&or;', '&cap;', '&cup;', '&int;',
    '&there4;', '&sim;', '&cong;', '&asymp;', '&ne;',
    '&equiv;', '&le;', '&ge;', '&sub;', '&sup;',
    '&nsub;', '&sube;', '&supe;', '&oplus;', '&otimes;',
    '&perp;', '&sdot;', '&lceil;', '&rceil;', '&lfloor;',
    '&rfloor;', '&loz;', '&spades;', '&clubs;', '&hearts;',
    '&diams;',
  ];

  $.summernote.plugins['specialchars'] = function(context) {
    const ui = $.summernote.ui;
    const $editor = context.layoutInfo.editor;
    const options = context.options;
    const lang = options.langInfo;

    const KEY = {
      UP: 38,
      DOWN: 40,
      LEFT: 37,
      RIGHT: 39,
      ENTER: 13,
    };

    const COLUMN_LENGTH = 15;
    const COLUMN_WIDTH = 35;

    let currentColumn = 0;
    let currentRow = 0;
    let totalColumn = 0;
    let totalRow = 0;

    const $dialog = ui.dialog({
      title: lang.specialChar.select,
      body: '',
    }).render();

    const makeSpecialCharSetTable = () => {
      const $table = $('<table/>');
      Array.from(specialCharDataSet).forEach((text, idx) => {
        const $td = $('<td/>').addClass('note-specialchar-node');
        const $tr = (idx % COLUMN_LENGTH === 0) ? $('<tr/>') : $table.find('tr').last();

        const $button = ui.button({
          callback: function($node) {
            $node.text(text).attr('title', text).attr('data-value', encodeURIComponent(text));
            $node.css({
              width: `${COLUMN_WIDTH}px`,
              'margin-right': '2px',
              'margin-bottom': '2px',
            });
          },
        }).render();

        $td.append($button);

        $tr.append($td);
        if (idx % COLUMN_LENGTH === 0) {
          $table.append($tr);
        }
      });

      totalRow = $table.find('tr').length;
      totalColumn = COLUMN_LENGTH;

      return $table;
    };

    const initialize = () => {
      const $container = options.dialogsInBody ? $(document.body) : $editor;

      const body = `<div class="form-group row-fluid">${makeSpecialCharSetTable()[0].outerHTML}</div>`;

      $dialog.find('.note-dialog-body').html(body);
    };

    const show = () => {
      const text = context.invoke('editor.getSelectedText');
      context.invoke('editor.saveRange');

      showSpecialCharDialog(text).then(selectChar => {
        context.invoke('editor.restoreRange');

        const $node = $('<span></span>').text(selectChar)[0];

        if ($node) {
          context.invoke('editor.insertNode', $node);
        }
      }).catch(() => {
        context.invoke('editor.restoreRange');
      });
    };

    const showSpecialCharDialog = text => {
      return new Promise((resolve, reject) => {
        const $specialCharDialog = $dialog;
        const $specialCharNode = $specialCharDialog.find('.note-specialchar-node');
        let $selectedNode = null;

        const addActiveClass = $target => {
          if (!$target) {
            return;
          }
          $target.find('button').addClass('active');
          $selectedNode = $target;
        };

        const removeActiveClass = $target => {
          $target.find('button').removeClass('active');
          $selectedNode = null;
        };

        const findNextNode = (row, column) => {
          let $nextNode = null;
          const lastRowColumnLength = $specialCharNode.length % totalColumn;

          if (row === 1 && column === 1 && lastRowColumnLength < currentColumn) {
            $nextNode = $specialCharNode.last();
          } else if (row === 1 && column === 1) {
            $nextNode = $specialCharNode.eq(column + lastRowColumnLength - 1);
          } else if (column === 1) {
            $nextNode = $specialCharNode.eq(($specialCharNode.length - totalColumn) + (row - 2) * totalColumn);
          } else {
            $nextNode = $selectedNode.nextElementSibling || $specialCharNode.first();
          }

          return $nextNode;
        };

        const arrowKeyHandler = keyCode => {
          if (KEY.LEFT === keyCode) {
            $selectedNode = $selectedNode.prev();
            if (!$selectedNode.length) {
              $selectedNode = $specialCharNode.last();
            }
          } else if (KEY.RIGHT === keyCode) {
            $selectedNode = $selectedNode.next();
            if (!$selectedNode.length) {
              $selectedNode = $specialCharNode.first();
            }
          } else if (KEY.UP === keyCode) {
            $selectedNode = $selectedNode.prevAll('tr').last().find('td:last-child');
            if (!$selectedNode.length) {
              $selectedNode = $specialCharNode.last();
            }
          } else if (KEY.DOWN === keyCode) {
            $selectedNode = $selectedNode.nextAll('tr').first().find('td:first-child');
            if (!$selectedNode.length) {
              $selectedNode = $specialCharNode.first();
            }
          }
        };

        const enterKeyHandler = () => {
          if (!$selectedNode) {
            return;
          }

          resolve(decodeURIComponent($selectedNode.find('button').attr('data-value')));
          $specialCharDialog.modal('hide');
        };

        const keyDownEventHandler = event => {
          event.preventDefault();
          const keyCode = event.keyCode;
          if (keyCode === undefined || keyCode === null) {
            return;
          }

          if (KEY.LEFT === keyCode || KEY.RIGHT === keyCode || KEY.UP === keyCode || KEY.DOWN === keyCode) {
            if (!$selectedNode) {
              addActiveClass($specialCharNode.eq(0));
              currentColumn = 1;
              currentRow = 1;
              return;
            }
            arrowKeyHandler(keyCode);
          } else if (KEY.ENTER === keyCode) {
            enterKeyHandler();
          }
        };

        removeActiveClass($specialCharNode);

        if (text) {
          for (let i = 0; i < $specialCharNode.length; i++) {
            const $checkNode = $($specialCharNode[i]);
            if ($checkNode.text().trim() === text) {
              addActiveClass($checkNode);
              currentColumn = i % COLUMN_LENGTH + 1;
              currentRow = Math.floor(i / COLUMN_LENGTH) + 1;
              break;
            }
          }
        }

        ui.onDialogShown($dialog, function() {
          $(document).on('keydown', keyDownEventHandler);

          $specialCharNode.on('click', function(event) {
            event.preventDefault();
            const $target = $(event.currentTarget);
            removeActiveClass($selectedNode);
            addActiveClass($target);
            $selectedNode = $target;
          });

          $dialog.find('button').tooltip();
        });

        ui.onDialogHidden($dialog, function() {
          $specialCharNode.off('click');

          $dialog.find('button').tooltip('destroy');

          $(document).off('keydown', keyDownEventHandler);

          if (deferred.state() === 'pending') {
            reject();
          }
        });

        initialize();
        ui.showDialog($dialog);
      });
    };

    context.memo('button.specialchars', function() {
      return ui.button({
        contents: '<i class="fa fa-font fa-flip-vertical">',
        tooltip: lang.specialChar.specialChar,
        click: function() {
          show();
        },
      }).render();
    });
  };
}));
