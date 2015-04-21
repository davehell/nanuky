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
                $('<div id="dConfirm" class="modal"></div>').appendTo('body');
                $('#dConfirm').html(
                  '<div class="modal-dialog"><div class="modal-content">'+
                  '<div class="modal-header">' +
                  '  <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>' +
                  '  <h3>' + $(obj).data('confirm-title') + '</h3>' +
                  '</div>' +
                  '<div class="modal-body">' +
                  '  <p>' + $(obj).data('confirm-text') + '</p>' +
                  '</div>' +
                  '<div class="modal-footer">' +
                  '  <a id="dConfirmCancel" class="btn btn-default">Ne</a>&nbsp;' +
                  '  <a id="dConfirmOk" class="btn btn-success">Ano</a>' +
                  '</div>' +
                  '</div></div>'
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
                    $('#dConfirm').modal('hide');
                });
                $('#dConfirmCancel').on('click', function () {
                  $('#dConfirm').modal('hide');
                });
                $('#dConfirm').modal('show');
                $('#dConfirm').on('hidden.bs.modal', function (e) {
                  $('#dConfirm').remove();
                })
                return false;
            });
        }
    });

})(jQuery);
