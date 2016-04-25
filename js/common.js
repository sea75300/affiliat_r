jQuery.noConflict();
jQuery(function() {   

    jQuery('.buttons').button();    
    jQuery('.afltr-navigation .buttons').button({
        icons: {
            primary: "ui-icon-home"
        },
        text: true
    }).next().button({        
        icons: {
            primary: "ui-icon-link"
        },
        text: true
    }).next().button({        
        icons: {
            primary: "ui-icon-tag"
        },
        text: true
    }).next().button({        
        icons: {
            primary: "ui-icon-image"
        },
        text: true
    }).next().button({        
        icons: {
            primary: "ui-icon-wrench"
        },
        text: true
    }).next().button({
        icons: {
            primary: "ui-icon-arrowrefresh-1-e"
        },
        text: false
    }).next().button({
        icons: {
            primary: "ui-icon-power"
        },
        text: false
    });
    
    jQuery('a.buttons.show-upload-dialog').button({
        icons: {
            primary: "ui-icon-transferthick-e-w"
        },
        text: true
    });
    jQuery('.buttons.afltr-add-btn').button({
        icons: {
            primary: "ui-icon-document"
        },
        text: true
    });  
    jQuery('.savebtn').button({
        icons: {
            primary: "ui-icon-disk"
        },
        text: true
    }); 
    jQuery('.resetbtn').button({
        icons: {
            primary: "ui-icon-arrowreturnthick-1-w"
        },
        text: false
    });     
    jQuery('.submitbtn.submdelete').button({
        icons: {
            primary: "ui-icon-trash"
        },
        text: false
    });     
    jQuery('.submitbtn.submmail').button({
        icons: {
            primary: "ui-icon-mail-closed"
        },
        text: true
    });         
    jQuery('.afltr-options-btns').button({
        icons: {
            primary: "ui-icon-folder-open"
        },
        text: true
    }).next('.afltr-options-btns').button({        
        icons: {
            primary: "ui-icon-note"
        }
    });  
    jQuery('.afltr-update-btn').button({
        icons: {
            primary: "ui-icon-refresh"
        },
        text: true
    });       
    
    jQuery('.tabs').tabs();
    jQuery( document ).tooltip();

    jQuery('#afltr-checkbox-selectall').click(function(){
        if(jQuery('#afltr-checkbox-selectall').prop('checked'))        
            jQuery('.afltr-checkbox').prop('checked', true);
        else
            jQuery('.afltr-checkbox').prop('checked', false);
    });    

    jQuery('.show-upload-dialog').click(function() {        
        jQuery('.afltr-dialog').dialog({
            width: 500,
            modal: true,
            show: {
                effect: "fade",
                duration: 500
            },
            hide: {
                effect: "fade",
                duration: 500
            },
            buttons: [
                {
                    text: dialogUploadButtonDescr,
                    icons: {
                        primary: "ui-icon-disk"
                    },
                    click: function() {
                        jQuery('#submupload').trigger('click');
                    }
                },
                {
                    text: dialogResetButtonDescr,
                    icons: {
                        primary: "ui-icon-arrowreturnthick-1-w"
                    },             
                    click: function() {
                        jQuery('#subreset').trigger('click');
                    }
                },                            
            ]            
        });
    });
    
    jQuery('.show-integration-dialog').button({
        icons: {
            primary: "ui-icon-script"
        },
        text: true
    }).click(function() {        
        jQuery('.afltr-dialog-integration').dialog({
            width: 800,
            modal: true,
            show: {
                effect: "fade",
                duration: 500
            },
            hide: {
                effect: "fade",
                duration: 500
            }
        });
    });    
    
    jQuery('.afltr-messagebox.fadeout').delay(5000).fadeOut('slow');
    
    jQuery('#afltr-clear-cache').click(function() {        
        jQuery.get(
            "index.php?module=system/cache",
            function( data ) {
                jQuery( "#afltr-message-div" ).fadeIn().html( data ).delay(5000).fadeOut('slow');
            }
        );
        return false;
    });
    
    jQuery('.afltr-ui-select').selectmenu();
    jQuery('#optionstimeZone').selectmenu().selectmenu("menuWidget").addClass("afltr-ui-select-overflow");
    jQuery('#integration-textonly').selectmenu({
        appendTo: ".afltr-dialog-integration",
        change: function() {
            updateIntegrationText();
        }        
    });
    
    jQuery('#optionssystemMode').selectmenu({
        change: function() {
            jQuery('#iframecsstr').fadeToggle(750);   
        }
    });

    jQuery('#afltr-updater-show-details').click(function() {
        jQuery('#afltr-updater-show-details-list').fadeToggle();
    });

    
    var lbInstance = jQuery( '.afltr-file-liste-link' ).imageLightbox({
        onStart: function() { closeButton(lbInstance); },
        onEnd:   function() { closeButtonOff(); activityIndicatorOff(); },
        onLoadEnd: function() { posCloseButton(); },
        enableKeyboard: false
    });

});

closeButton = function(instance) {
    jQuery( '<a id="imagelightbox-close" href="">close</a>' ).appendTo( 'body' ).on( 'click', function(){ jQuery( this ).remove(); instance.quitImageLightbox(); return false; });
    jQuery('#imagelightbox-close').button({ icons: { primary: "ui-icon-closethick" }, text: false });
}

closeButtonOff = function() { jQuery('.ui-widget-overlay').remove();jQuery( '#imagelightbox-close' ).remove(); }

activityIndicatorOff = function() {
    jQuery('.ui-widget-overlay').remove();
    jQuery('#imagelightbox-loading').remove();
}

posCloseButton = function() {    
    
    var el = jQuery('.ui-widget-overlay');
    if(typeof el[0] == 'undefined') {
        jQuery('#imagelightbox').wrap('<div class="ui-widget-overlay"></div>');
        var imgPos = jQuery('#imagelightbox').position();    
        jQuery('#imagelightbox-close').css('left', imgPos.left + jQuery('#imagelightbox').width() + 16);
        jQuery('#imagelightbox-close').css('top', imgPos.top + (jQuery('#imagelightbox').height() / 4) - 4);            
    }    
}