jQuery(function($) {
    'use strict';

    $('[data-checkall]').on('click', function() {
        var checked = this.checked;

        $($(this).data('checkall')).find(':checkbox').each(function() {
            $(this).prop('checked', checked);
        });
    });
});
