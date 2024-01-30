;(function($) {

    $('table.wp-list-table.contacts').on('click', 'a.submitdelete', function(e) {
        e.preventDefault();

        if (!confirm(sixAmDevs.confirm)) {
            return;
        }

        var self = $(this),
            id = self.data('id');

        // wp.ajax.send('sa-devs-delete-contact', {
        //     data: {
        //         id: id,
        //         _wpnonce: sixAmDevs.nonce
        //     }
        // })
        wp.ajax.post('sa-devs-delete-contact', {
            id: id,
            _wpnonce: sixAmDevs.nonce
        })
        .done(function(response) {

            self.closest('tr')
                .css('background-color', 'red')
                .hide(400, function() {
                    $(this).remove();
                });

        })
        .fail(function() {
            alert(sixAmDevs.error);
        });
    });

})(jQuery);
