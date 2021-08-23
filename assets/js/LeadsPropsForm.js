demand_tags_tagify = new Tagify(document.getElementById('demand_tags'), {
    whitelist : LeadsPropsFormData.tags,
    enforceWhitelist:true,
    editTags      : false,
    dropdown : {
            searchKeys    : ["label"], 
            classname     : "color-blue",
            enabled       : 0, 
            maxItems      : -1,             // show the dropdown immediately on focus
            position      : "absolute",         // place the dropdown near the typed text
            closeOnSelect : false,          // keep the dropdown open after selecting a suggestion
            highlightFirst: true,
    },
    templates: {
        dropdownItemNoMatch: function(data) {
            return `<div class='${this.settings.classNames.dropdownItem}' tabindex="0" role="option">
                No se encontraron resultados para : <strong>${data.value}</strong>
            </div>`
        }
    }
});

jQuery(document).ready(function () {
    jQuery('#area_min,#area_max').mask('#', {reverse: true});
    jQuery('#price_max').mask('000.000.000.000.000', {reverse: true});

});

jQuery('#leads-props-form').submit(function (e) { 
    e.preventDefault();
    
    let _data = jQuery(this).serialize();

    jQuery.ajax({
        type: "POST",
        url: LeadsPropsFormData.ajax_url,
        data: {
            action : LeadsPropsFormData.ajax_action,
            _data : _data,
        },
        beforeSend: function(){
            jQuery('#leads-props-form').addClass('loading');
        },
        success: function (response) {

            jQuery( '#leads-props-form' ).each(function(){
                this.reset();
            });

            swal({
                title : "Tu solicitud ha sido registrada con éxito",
                icon : "success",
                buttons: {
                    catch: {
                      text: "Salir y continuar",
                      value: "exit",
                    },
                  },
            })
            .then(function(value){
                window.location = LeadsPropsExtraData.redirect_link;
            });
        },
        error: function(error){
            swal({
                title : "Ha ocurrido un error en tu solicitud",
                text : error.responseJSON.data,
                icon : 'error',
                buttons: {
                    catch: {
                      text: "Salir",
                      value: "exit",
                    },
                  },
            });
        },
        complete: function(){
            jQuery('#leads-props-form').removeClass('loading');
        }
    });

    
});