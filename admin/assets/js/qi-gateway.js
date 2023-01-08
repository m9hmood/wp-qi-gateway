jQuery(document).ready(function ($) {
    $('#qi-gateway-disclaimer').show();
    $('#qi-card-accept-button').click(function () {
        $.post(ajaxurl, {
            action: 'qi_gateway_accept_action',
        }, function (response) {
            location.reload();
        });
    });
    $('#qi-card-reject-button').click(function () {
        // Deactivate the plugin
        $.post(ajaxurl, {
            action: 'qi_gateway_reject_action',
        }, function (response) {
            location.reload();
        });
    });
});
