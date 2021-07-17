<?php


add_action( 'wpcf7_before_send_mail',
  function( $contact_form, $abort, $submission ) {

    $values_list = $_POST; 
    $values_str = implode(", ", $values_list);


    $contact        = new Inmoob\Witei\Contacts\Contact($values_list);
    $conversation   = new Inmoob\Witei\Messages\Conversation($contact->id);
    $message        = new Inmoob\Witei\Messages\Message($contact->id,$conversation->pk, 'este es el titulo del mensaje','aqui va el html');

    error_log(var_export($message,true));
    // error_log(json_encode($new));
    // Obteniendo información del usuario a través del campo «your-email»
    $tu_email = $submission->get_posted_data( 'tu-email' );
    
    // Obteniendo información del usuario a través del campo «your-message»
    $tu_mensaje = $submission->get_posted_data( 'tu-mensaje' );
    

    var_export(false);
    // Haz algunas cosas productivas aquí
  },
  10, 3
);