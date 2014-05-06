jQuery(document).ready(function($){
    $('.ht-social-widget-color-picker').wpColorPicker();

    $('#ht-social-widget-list').sortable({
        revert: "invalid",
        cursor: "move" ,
        helper: "clone",
        placeholder : "sortable-placeholder",
        change: function(event, ui) {
        },
        stop: function( event, ui ) {
            syncListWithIDs();
            saveImageOrder();
        },
        start: function( event, ui ) {
            //can add text placeholder here if required
        }
    });
});