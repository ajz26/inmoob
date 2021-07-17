<?php
namespace Inmoob\Witei\Contacts;

class Contact {

    public      $id;
    private     $data;
    public      $name;
    public      $alias;
    public      $email;
    public      $email_alt;
    public      $phone;
    public      $phone_alt;
    public      $street;
    public      $city;
    public      $nif;
    public      $creator        = "web@inmoob.com";
    public      $commercial     = "web@inmoob.com";
    public      $source         = "web";
    public      $contact_kind   = "client";
    public      $house_set;
    public      $houserelationship_set;
    public      $notes;
    public      $rating;
    public      $pipeline_stage;
    public      $status;
    public      $kind;
    public      $for_rent;
    public      $rent_price_min;
    public      $rent_price_max;
    public      $for_sale;
    public      $sale_price_min;
    public      $sale_price_max;
    public      $bedrooms_min;
    public      $bedrooms_max;
    public      $bathrooms_min;
    public      $bathrooms_max;
    public      $area_min;
    public      $area_max;
    public      $floor_min;
    public      $floor_max;
    public      $area_window_min;
    public      $area_window_max;
    public      $ceiling_height_min;
    public      $ceiling_height_max;
    public      $demand_ne_lat;
    public      $demand_ne_lng;
    public      $demand_sw_lat;
    public      $demand_sw_lng;
    public      $areas;
    public      $demand_tags;
    public      $preferred_language_code = 'es';
    public      $related;
    public      $property_partner;
    public      $collaborator;
    public      $created;
    public      $is_iddle;
    public      $blocked;

    private     $token  = 'e2343a00c523436698d768bd39003348';
    private     $url    = 'https://witei.com/api/v1/contacts/';
   

    function __construct($data){
        $this->data     = $data;
        $this->parse_data();
        $this->insert_contact();
        $this->remove_null_props();
    }

    function insert_contact(){

        $json = json_encode($this,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
        $res    = wp_remote_post($this->url,array(
            'headers' => array(
                'Authorization' => "Bearer {$this->token}"
            ),
            'body'       => $this,
        ));
        $response_code      = wp_remote_retrieve_response_code($res);
        $response_message   = wp_remote_retrieve_response_message($res);
        $response_body      = wp_remote_retrieve_body($res);


        if (is_wp_error($res) ) {
            return new \WP_Error($response_code, $response_message, $response_body);
        }

        $response_body  = json_decode($response_body) ?: array();
        
        if(!is_wp_error($res) && ($res['response']['code'] == 200 || $res['response']['code'] == 201)) {
            return $response_body->id;
        }

        $this->id   = isset($response_body->id) && !empty($response_body->id) ? $response_body->id : null;
        
        if(!isset($this->id)){
            return null;
        }

        $contact = $this->get_contact($this->id);

        $contact = $this->update_contact($contact);
            
    }

    function get_contact(int $id){

        $res    = wp_remote_get("{$this->url}/{$id}/",array(
            'headers' => array(
                'Authorization' => "Bearer {$this->token}"
            ),
        ));

        $response_code      = wp_remote_retrieve_response_code($res);
        $response_message   = wp_remote_retrieve_response_message($res);
        $response_body      = wp_remote_retrieve_body($res);

        if (is_wp_error($res) ) {
            return new WP_Error($response_code, $response_message, $response_body);
        }

        $contact  = json_decode($response_body) ?: array();

        return $contact;
    }

    function update_contact($contact){

        foreach($contact AS $field => $value){
            if(!isset($value)) continue;

            if(isset($this->$field)){
                switch($field){
                    case 'name':
                    case 'phone':
                    case 'alias':
                        unset($this->$field);
                    break; 
                    case 'notes':
                        $this->$field = $this->handler_value($value,$this->$field,false); 
                    break;
                    default: 
                        $this->$field = $this->handler_value($value,$this->$field); 
                }
            }

        }


        $res    = wp_remote_request("{$this->url}/{$this->id}/",array(
            'headers' => array(
                'Authorization' => "Bearer {$this->token}"
            ),
            'method'     => 'PUT',
            'body'       => $this,
        ));

        $response_code      = wp_remote_retrieve_response_code($res);
        $response_message   = wp_remote_retrieve_response_message($res);
        $response_body      = wp_remote_retrieve_body($res);

        if (is_wp_error($res) ) {
            return new \WP_Error($response_code, $response_message, $response_body);
        }

        $response_body  = json_decode($response_body) ?: array();

        if(!is_wp_error($res) && ($res['response']['code'] == 200 || $res['response']['code'] == 201)) {
            return $response_body->id;
        }else{
            return null;
        }

    }


    function handler_value($old_value, $new_value, $override = true){

        switch(true){
            case (is_array($old_value) ? true : false);
                $new_value = $override ? $new_value : array_merge($old_value,$new_value); 
            break;

            case (!is_array($old_value) ? true : false);
                    $new_value = $override ? $new_value : "{$old_value} \n {$new_value}"; 
            break;
        } 

        return $new_value;

    }

    function parse_data(){
        $data     = $this->data;

        foreach($data AS $key => $val){ 
            if(property_exists($this,$key)){
                $this->$key = $val;
            }
        }

    }

    function remove_null_props(){

        $props = get_object_vars($this);
        unset($this->data);
        unset($this->token);
        unset($this->url);
        
        
        foreach($props AS $prop => $value){

            if(!isset($this->$prop)){
                unset($this->$prop);
            }

        }

    }

}