<?php
namespace Inmoob\Witei\Contacts;
use OBSER\Classes\Settings;
use stdClass;

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
    public      $errors;

    protected   $witei_api_key;
    private     $url    = 'https://witei.com/api/v1/contacts/';
   

    function __construct($data){
        $this->witei_api_key   =  Settings::get_setting('inmoob-settings','witei_api_key') ?: null;

        $this->data = $data;

        $this->parse_data();
    } 


    function set_error($errors){
        $errors = json_decode($errors,true);
        foreach($errors AS $error => $message){
            $this->errors[$error] = is_array($message) && count($message) > 1 ? $message : $message[0];
        }
    }




    public function insert_contact(){
        
        error_log(var_export($this->witei_api_key,true) );


        if(!isset($this->witei_api_key)){
            return false;
        }

        $json   = json_encode($this,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);

        $res    = wp_remote_post($this->url,array(
                'headers' => array(
                    'Authorization' => "Bearer {$this->witei_api_key}"
                ),
                'body'       => json_decode($json,true),
            )
        );

        $response_code      = wp_remote_retrieve_response_code($res);
        $response_message   = wp_remote_retrieve_response_message($res);
        $response_body      = wp_remote_retrieve_body($res);
        $response_body      = json_decode($response_body,true) ?: new stdClass;


        if (is_wp_error($res) || $response_code >= 400 || isset($response_body->id) ) {
            return new \WP_Error($response_code, $response_message,$response_body);
        }

        $this->id   = isset($response_body->id) && !empty($response_body->id) ? $response_body->id : null;
        
        // $this->remove_null_props();
        
        // if(!isset($this->id)){
            return $response_body;
        // }



    }

    function get_contact(int $id){

        $res    = wp_remote_get("{$this->url}/{$id}/",array(
            'headers' => array(
                'Authorization' => "Bearer {$this->witei_api_key}"
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
        $date  = new \DateTime();
        $date  = $date->format('d-m-y');
        foreach($contact AS $field => $value){

            if(!isset($value)) continue;

            if(isset($this->$field)){
                switch($field){
                    case 'name':
                    case 'firstname':
                    case 'Firstname':
                    case 'phone':
                    case 'alias':
                    case 'email':
                        unset($this->$field);
                    break; 
                    case 'message':
                        $field = 'notes';
                    case 'notes':
                        $this->$field   = "Nota creada desde la web: {$date} \r\n {$this->$field} \r\n";
                        $this->$field   = $this->handler_value($value,$this->$field,false);
                    break;
                    default: 
                        $this->$field = $this->handler_value($value,$this->$field); 
                }
            }

        }

        $json   = json_encode($this,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
        $res    = wp_remote_request("{$this->url}/{$this->id}/",array(
            'headers' => array(
                'Authorization' => "Bearer {$this->witei_api_key}"
            ),
            'method'     => 'PUT',
            'body'       => json_decode($json,true),
        ));



        $response_code      = wp_remote_retrieve_response_code($res);
        $response_message   = wp_remote_retrieve_response_message($res);
        $response_body      = wp_remote_retrieve_body($res);

        if (is_wp_error($res) || $response_code >= 400 ) {

            $this->set_error($response_body);

            return new \WP_Error($response_code, $response_message, $response_body);
        }

        $response_body  = json_decode($response_body) ?: array();

        if(!is_wp_error($res) && ($res['response']['code'] == 200 || $res['response']['code'] == 201)) {
            return $response_body;
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
            
            switch($key){
                
                case 'Firstname' : 
                case 'firstname' : 
                case 'your-name' : 
                $key = 'name';
                break; 
                case 'message' : 
                    $key = 'notes';
                break; 
            }

            if(property_exists($this,$key)){
                $this->$key = $val;
            }
        }



    }

    function remove_null_props(){

        $props = get_object_vars($this);
        unset($this->data);
        unset($this->witei_api_key);
        unset($this->url);
        
        
        foreach($props AS $prop => $value){

            if(!isset($this->$prop)){
                unset($this->$prop);
            }

        }

    }

}