jQuery(document).on('click','#wp-admin-bar-inmoob_reimport_properties',function (e) { 
    alert('adasd');
    e.preventDefault();
    jQuery.ajax({
        type: "POST",
        url: "/wp-admin/admin-ajax.php",
        data: {
            action : 'reimport_witei_props'
        },
        success: function (response) {
            console.log(response);     
        }
    });
});
