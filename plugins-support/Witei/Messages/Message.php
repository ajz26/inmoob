<?php
namespace Inmoob\Witei\Messages;

class Message {


    public      $contact_id;
    public      $conversation_id;
    public      $title;
    public      $body_html;
    private     $token  = 'e2343a00c523436698d768bd39003348';
    private     $url    = 'https://witei.com/api/v1/link/messages/';

    function __construct($contact_id,$conversation_id,$title = null,$body_html = ''){
        $this->conversation_id      = $conversation_id;
        $this->title                = $title;
        $this->contact_id           = $contact_id;
        $this->body_html            = $body_html;
        $this->save_message();
    }


    function save_message(){

        $res    = wp_remote_post($this->url,array(
            'headers' => array(
                'Authorization' => "Bearer {$this->token}"
            ),
            'body'       => $this,
        ));
        $response_code      = wp_remote_retrieve_response_code($res);
        $response_message   = wp_remote_retrieve_response_message($res);
        $response_body      = wp_remote_retrieve_body($res);

        error_log(var_export($response_body,true));

        if (is_wp_error($res) ) {
            return new \WP_Error($response_code, $response_message, $response_body);
        }

        $response_body  = json_decode($response_body) ?: array();
        
        if(!is_wp_error($res) && ($res['response']['code'] == 200 || $res['response']['code'] == 201)) {
            return $response_body->pk;
        }

        $this->pk   = isset($response_body->pk) && !empty($response_body->pk) ? $response_body->pk : null;
        
        if(!isset($this->pk)){
            return null;
        }

        $contact = $this->get_contact($this->pk);

        $contact = $this->update_contact($contact);
            
    }





}