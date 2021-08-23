<?php


add_action( 'wpcf7_before_send_mail',
  function( $contact_form, $abort, $submission ) {

    $values_list = $_POST; 


    $contact        = new Inmoob\Witei\Contacts\Contact($values_list);
    
    $create_contact = $contact->insert_contact();

    if( is_wp_error( $create_contact ) ) {
        
        $error = $create_contact->get_error_data();

        if(isset($error['id'])){
            $contact->id    = $error['id'];
            $witei_contact  = $contact->get_contact($contact->id);
            $contact        = $contact->update_contact($witei_contact);
        }
        
    }

    
    // // $conversation   = new Inmoob\Witei\Messages\Conversation($contact->id);
    // // $message        = new Inmoob\Witei\Messages\Message($contact->id,$conversation->pk, 'este es el titulo del mensaje','aqui va el html');

    // // error_log(var_export($message,true));
    // // error_log(json_encode($new));
    // // Obteniendo información del usuario a través del campo «your-email»
    // $tu_email = $submission->get_posted_data( 'tu-email' );
    
    // // Obteniendo información del usuario a través del campo «your-message»
    // $tu_mensaje = $submission->get_posted_data( 'tu-mensaje' );
    

    // var_export(false);
    // // Haz algunas cosas productivas aquí
  },
  10, 3
);