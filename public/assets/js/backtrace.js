/**
 * Created by travis on 5/19/2016.
 */

'use strict';

!function () {
  var $handlerToggle = $('#backtrace-toggle-error-handler');

  $handlerToggle
    .on('click', function () {
      var self = this;
      var xhr = $.ajax('/backtrace/toggle-handler?backtraceoff', {
        dataType: 'json'
      });

      this.disabled = true;

      xhr.done(function (response) {
        self.disabled = false;

        if (response.currentValue) {
          $handlerToggle.addClass('btn-danger')
            .removeClass('btn-success');
        }
        else {
          $handlerToggle.removeClass('btn-danger')
            .addClass('btn-success');
        }

        $handlerToggle
          .attr(
            'data-original-title',
            $handlerToggle.data(response.currentValue ? 'on-msg' : 'off-msg')
          )
          .tooltip('fixTitle');
      });

      xhr.fail(function () {
        $handlerToggle.addClass('error');
      });

      xhr.always(function () {
        setTimeout(function () {
          self.disabled = false;
          $handlerToggle.removeClass('error');
        }, 500);
      });
    });
}();
