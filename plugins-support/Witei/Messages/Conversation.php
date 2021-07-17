<?php
namespace Inmoob\Witei\Messages;

class Conversation {


    public      $contact_id;
    public      $pk;
    private     $token  = 'e2343a00c523436698d768bd39003348';
    private     $url    = 'https://witei.com/api/v1/link/conversations/';

    function __construct($contact_id){
        $this->contact_id   = $contact_id;
        $this->create();
    }


    function create(){

        $res    = wp_remote_post($this->url,array(
                    'headers' => array(
                        'Authorization' => "Bearer {$this->token}"
                    ),
                    'body'       => $this,
                    )
                );

        $response_code      = wp_remote_retrieve_response_code($res);
        $response_message   = wp_remote_retrieve_response_message($res);
        $response_body      = wp_remote_retrieve_body($res);


        if (is_wp_error($res) ) {
            return new \WP_Error($response_code, $response_message, $response_body);
        }

        $response_body  = json_decode($response_body) ?: array();

        
        if(!is_wp_error($res) && ($res['response']['code'] == 200 || $res['response']['code'] == 201)) {
            $this->pk = $response_body->pk;
        }

        return $this->pk;

    }





}