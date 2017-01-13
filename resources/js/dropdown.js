$(document).on('ajaxComplete ready', function () {

    // Initialize tag inputs.
    $('select[data-provides="multiple"]:not([data-initialized])').each(function () {

        $(this)
            .attr('data-initialized', '')
            .select2();
    });
});
