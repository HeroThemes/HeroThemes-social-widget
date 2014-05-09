jQuery(document).ready(function($){
    $('.ht-social-widget-color-picker').wpColorPicker({
        change: function(event, ui){
            htColorPickerChange(event, ui);
        },
    });

    //make the control list sortable
    $('#ht-social-widget-list').sortable({
        revert: "invalid",
        cursor: "move" ,
        helper: "clone",
        handle: ".ht-icon-preview",
        placeholder : "sortable-placeholder",
        change: function(event, ui) {
        },
        stop: function( event, ui ) {
            reorderSocialItems();
        },
        start: function( event, ui ) {
            //can add text placeholder here if required
        }
    });

    //make the enable/selector list sortable
    $('#ht-social-widget-selector-list').sortable({
        revert: "invalid",
        cursor: "move" ,
        helper: "clone",
        placeholder : "sortable-placeholder",
        change: function(event, ui) {
        },
        stop: function( event, ui ) {
            reorderSocialEnable();
        },
        start: function( event, ui ) {
            //can add text placeholder here if required
        }
    });

    

    //sort on load
    sortListByOrder();
    function sortListByOrder(){
        ul = $('ul#ht-social-widget-list '),
        li = ul.children('li');
        
        li.detach().sort(function(a,b) {
            return $(a).find('.ht-social-widget-item-order input').val() - $(b).find('.ht-social-widget-item-order input').val();  
        });
        
        ul.append(li);
    }

    //sort on load
    sortEnableListByOrder();
    function sortEnableListByOrder(){
        ul = $('ul#ht-social-widget-selector-list'),
        li = ul.children('li');
        
        li.detach().sort(function(a,b) {
            return $(a).data('order') - $(b).data('order');  
              });
        
        ul.append(li);
        
    }

    
    //initialize reset buttons on load
    initializeResetButtons();
    function initializeResetButtons(){
        $('.ht-social-widget-item-reset a').click(function(){
            var buttonClicked = $(this);
            if(buttonClicked.length>0){
                var itemToReset = buttonClicked.data('value');
                resetItem(itemToReset);
            }
        });
    }

    function resetItem(itemID){
        console.log('resetting->'+itemID);

        //loaded into htSocialDefaults as array
        //style
        
        var styleInput = $('select[name="ht_social_widget_options['+itemID+'][style]"]');
        var defaultStyle = htSocialDefaults[itemID]['color'];
        if(styleInput.length>0){
            styleInput.val(defaultStyle);
            //trigger change event
            styleInput.trigger('change');
        }

        //text
        var textColorInput = $('input[name="ht_social_widget_options['+itemID+'][color]"]');
        var defaultTextColor = htSocialDefaults[itemID]['color'];
        if(textColorInput.length>0){
            textColorInput.val(defaultTextColor);
            //trigger change event
            textColorInput.trigger('change');
        }
            
        //background
        var backgroundColorInput = $('input[name="ht_social_widget_options['+itemID+'][background]"]');
        var defaultBackgroundColor = htSocialDefaults[itemID]['background'];
        if(backgroundColorInput.length>0){
            backgroundColorInput.val(defaultBackgroundColor);
            //trigger change event
            backgroundColorInput.trigger('change');
        }

        //url

        //update
        updatePreview(itemID);
    }


    function updatePreview(itemID){
        var style, textColor, backgroundColor;
        //style
        var styleInput = $('select[name="ht_social_widget_options['+itemID+'][style]"]');
        if(styleInput.length>0)
            style = styleInput.val();
        //text color
        var textColorInput = $('input[name="ht_social_widget_options['+itemID+'][color]"]');
        if(textColorInput.length>0)
            textColor = textColorInput.val();
        //background color
        var backgroundColorInput = $('input[name="ht_social_widget_options['+itemID+'][background]"]');
        if(backgroundColorInput.length>0)
            backgroundColor = backgroundColorInput.val();

        //symbol 
        var symbol = $('#ht-social-item-'+itemID+' span.symbol');
        var providerID = htSocialDefaults[itemID]['provider_id'];
        symbol.css('background-color', backgroundColor);
        symbol.css('color', textColor);
        if(style==undefined || style==null || style=="")
            style="";
        symbol.html(style + providerID);

    }

    function htColorPickerChange(event, ui){
        var target = event.target;
        var key = $(target).data('key');
        updatePreview(key);
    }

    $('.ht-social-widget-style-select select').on('change', function(){
        var key = $(this).data('key');
        console.log('changed->'+key);
        updatePreview(key);   
    });

    $('.ht-social-widget-item-enable').on('click', function(){
        //get id
        var key = $(this).data('key');
        toggleEnabled(key);

    });




    function toggleEnabled(itemID){
        console.log('toggling->'+itemID);
        var itemEnable = $('#ht-social-widget-item-enable-'+itemID);
        console.log(itemEnable);
        enabled = itemEnable.hasClass('enabled');
        if(enabled){
            
            itemEnable.removeClass('enabled');
        } else {
            
            itemEnable.addClass('enabled');
        }
        showEnabledDetails();
    }

    showEnabledDetails();
    function showEnabledDetails(){
        socialItems = $('li.ht-social-widget-item-enable');
        if(socialItems.length>0){
            socialItems.each(function( index ) {
              var item = $(this);
              var key = item.data('key');
              //is enabled
              if(item.hasClass('enabled')){
                //hide details
                console.log('enabled->'+key);
                $('li#ht-social-item-'+key).show("show");
                //enabled
                var enabledInput = $('input[name="ht_social_widget_options['+key+'][enabled]"]');
                enabledInput.prop('checked', true);
              } else {
                console.log('not enabled->'+key);
                $('li#ht-social-item-'+key).hide("slow");
                var enabledInput = $('input[name="ht_social_widget_options['+key+'][enabled]"]');
                enabledInput.prop('checked', false);
              }
            });
        }
    }

    //drag and drop controls
    function reorderSocialItems(){
        var socialItems = $('ul#ht-social-widget-list li');

        if(socialItems.length>0){
            socialItems.each(function( index ) {
              var item = $(this);
              var key = item.data('key');
              console.log(item);
              var orderInput  = item.find('.ht-social-widget-item-order input');
              if(orderInput.length>0){
                orderInput.val(index);
              }
              //enable list
              $('#ht-social-widget-item-enable-'+key).data('order', index);

            });
            sortEnableListByOrder();
        }
    }


    //the drag/drop interface
    function reorderSocialEnable(){
        var socialItems = $('ul#ht-social-widget-selector-list li');

        if(socialItems.length>0){
            socialItems.each(function( index ) {

                
              var item = $(this);
              //key
              var key = item.data('key');
              //set new order
              item.data('order', index);
              console.log(item);
              //the control
              var control = $('li#ht-social-item-'+key);

              var orderInput  = control.find('.ht-social-widget-item-order input');
              if(orderInput.length>0){
                orderInput.val(index);
              }
            });
        };
        sortListByOrder();
    }

    //enable click
    $('.ht-social-widget-item-enabled input').on('click', function(e, ui){
        var item = $(this);
        //key
        var key = item.data('key');
        e.preventDefault();
        toggleEnabled(key);
    });



    
});