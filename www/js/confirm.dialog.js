/**
 * Confirm dialog plugin
 *
 * @copyright  Copyright (c) 2012 Jan Èervený
 * @license    BSD
 * @link       confirmdialog.redsoft.cz
 * @version    1.0
 */

(function ($, undefined) {

    $.nette.ext({
        load: function () {
            $('[data-confirm]').click(function (event) {
                var obj = this;
                event.preventDefault();
                event.stopImmediatePropagation();
                $('<div id="dConfirm" class="reveal-modal tiny" data-reveal></div>').appendTo('body');
                $('#dConfirm').html(
                  '<h3>' + $(obj).data('confirm-title') + '</h3>' +
                  '<p>' + $(obj).data('confirm-text') + '</p>' +
                  '<a id="dConfirmCancel" class="button secondary">Ne</a>&nbsp;' +
                  '<a id="dConfirmOk" class="button success">Ano</a>' +
                  '<a class="close-reveal-modal">&#215;</a>'
                );
                $('#dConfirmOk').on('click', function () {
                    var tagName = $(obj).prop("tagName");
                    if (tagName == 'INPUT') {
                        var form = $(obj).closest('form');
                        form.submit();
                    } else {
                        if ($(obj).data('ajax') == 'on') {
                            $.nette.ajax({
                                url: obj.href
                            });
                        } else {
                            document.location = obj.href;
                        }
                    }
                    $('#dConfirm').foundation('reveal', 'close');
                });
                $('#dConfirmCancel').on('click', function () {
                  $('#dConfirm').foundation('reveal', 'close');
                });
                $('#dConfirm').foundation('reveal', 'open');
                $(document).on('close.fndtn.reveal', '[data-reveal]', function () {
                  $('#dConfirm').remove();
                });
                return false;
            });
        }
    });

})(jQuery);
