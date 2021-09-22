<?php

namespace Inmoob\Shortcodes;

use Inmoob\Classes\Api;
use OBSER\Classes\Settings;
use Inmoob\Classes\Shortcode;
use Inmoob\Witei\Contacts\Contact;
use Inmoob\Classes\Mails\Notification;
use Inmoob\Shortcodes\SearchForm\Select;
use function Inmoob\Witei\Functions\get_property_tags;
use function Inmoob\Witei\Functions\get_property_types;

class LeadsPropsForm extends Shortcode {




    static $shortcode       = "inmoob_leads_props_form";

    public static function enquee_styles(){
        return array(
            'inmoobstrap' => array(
                'src'   => INMOOB_CORE_PLUGIN_DIR_URL . 'assets/css/inmoobstrap.css',
            ),
            'tagify' => array(
                'src'   => INMOOB_CORE_PLUGIN_DIR_URL . 'assets/css/tagify.css',
            ),
        );
    }

    public static function enquee_scripts(){
        return array(
            'sweetalert' => array(
                'src'   => INMOOB_CORE_PLUGIN_DIR_URL . 'assets/js/sweetalert.js',
                'deps'  => array('jquery'),
                'in_footer'   => true,
            ),
            'tagify' => array(
                'src'   => INMOOB_CORE_PLUGIN_DIR_URL . 'assets/js/jQuery.tagify.min.js',
                'deps'  => array('jquery'),
                'in_footer'   => false,
            ),
            'LeadsPropsForm' => array(
                'src'   => INMOOB_CORE_PLUGIN_DIR_URL . 'assets/js/LeadsPropsForm.js',
                'deps'  => array('jquery'),
                'in_footer'   => false,
            ),
            'mask' => array(
                'src'   => INMOOB_CORE_PLUGIN_DIR_URL . 'assets/js/jquery.mask.js',
                'deps'  => array('jquery'),
                'in_footer'   => false,
            ),
           
        );
    }


    public static function after_register(){

        add_action('wp_ajax_save_lead',[__CLASS__,'save_lead']);
        add_action('wp_ajax_nopriv_save_lead',[__CLASS__,'save_lead']);

    }

    public static function localize_script(){

        return array(
            'LeadsPropsForm' => array(
                'object_name'   => 'LeadsPropsFormData',
                'l10n'          => array(
                    'ajax_url'          => admin_url('admin-ajax.php'),
                    'tags'              => self::get_tags(),
                    'redirect_link'     => self::get_redirect_link(),
                    'ajax_action'       => 'save_lead',
                ),
                
            ),
        );
    }

    static function generate_css(){}

    static function get_tags(){
        $tags = (array)Api::get_terms_select('property_tags_taxonomy');

        return array_map(function($tag){
             $tag->value = $tag->label;
             unset($tag->meta);
             unset($tag->label);
             return $tag;
        },$tags);

    }

    static function get_redirect_link(){
        
        $redirect = self::get_atts('redirect');

        $redirect = vc_build_link($redirect);

        return $redirect['url'] ?: null;

    }


    static function send_email($params = null){
        
        if(!$params) return false;

    }

    static function save_lead(){

        $data   = isset($_POST['_data']) && !empty($_POST['_data']) ? $_POST['_data'] : null;
        $params = array();

        parse_str($data, $params);

        if(!$params){
            return wp_send_json_error('Error al procesar la información, inténtalo de nuevo, o si el error persiste, contáctanos.',403);
        }

        $lead_data      = self::parse_lead($params);

        $contact        = new Contact($lead_data);
        $create_contact = $contact->insert_contact();

        if( is_wp_error( $create_contact ) ) {
            
            $error = $create_contact->get_error_data();

            if(isset($error['id'])){
                $contact->id    = $error['id'];
                $witei_contact  = $contact->get_contact($contact->id);
                $contact        = $contact->update_contact($witei_contact);
            }

        }

        if(isset($contact->errors)){
            return wp_send_json_error($contact->errors,400);
        }

        $mail_params = self::parse_mail($lead_data);
        self::send_mail($mail_params);

        if(!isset($contact->id)){
            return wp_send_json_error(array('error' => 'Error al registrar petición'),500);
        }

        wp_send_json_success(compact('contact'), 201);

    }

    static function parse_lead(array $params){

        if(isset($params['demand_tags'])){

            $temp_tags = [];

            $params['demand_tags'] = json_decode(stripslashes($params['demand_tags']));

            foreach($params['demand_tags']  AS $tag){
                // $demand_tags_slug = get_property_tags()[$tag->val]['value'];
                $temp_tags[] =  isset($tag->value) ? $tag->value : null;
            }

            $params['demand_tags'] = $temp_tags;
        }

        if(isset($params['price_max'])){
            $params['price_max'] = str_replace([',','.'],'',$params['price_max']);
        }

        if($params['gestion_type'] == 'alquiler'){
            $params['for_rent'] = 1;
            $params['rent_price_min']     = 0; 
            $params['rent_price_max']     = $params['price_max']; 
        }

        if($params['gestion_type'] == 'venta'){
            $params['for_sale']         = 1;
            $params['sale_price_min']   = 0; 
            $params['sale_price_max']   = $params['price_max']; 
        }

        $params['notes'] = isset($params['notes']) ? $params['notes'] : "\r\n____\r\n DETALLES :\r\n";


        if(isset($params['demand_tags']) && !empty($params['demand_tags'])){

            $tags = array_column($params['demand_tags'],'value');
            $tags = implode(',',$params['demand_tags']);
            $params['notes'] .= "Características: \r\n --{$tags} \r\n";
        }


        if(isset($params['property_zone']) && !empty($params['property_zone'])){
            $params['notes'] .= "ZONA: \r\n --{$params['property_zone']} \r\n";
        }

        if(isset($params['profile']) && !empty($params['profile'])){
            $params['notes'] .= "DETALLE DE PERFIL: \r\n --{$params['profile']} \r\n";
        }

        if(isset($params['property_details']) && !empty($params['property_details'])){
            $params['notes'] .= "--DETALLE DE PROPIEDAD: \r\n --{$params['property_details']} \r\n";
        }

        $params['notes'] .= "\r\n____\r\n";

        return $params;

    }

    static function parse_mail(array $params){

        $name              =  isset($params['name'])               && !empty($params['name'])               ? $params['name']               : null;
        $phone             =  isset($params['phone'])              && !empty($params['phone'])              ? $params['phone']              : null;
        $email             =  isset($params['email'])              && !empty($params['email'])              ? $params['email']              : null;
        $kind              =  isset($params['kind'])               && !empty($params['kind'])               ? $params['kind']               : null;
        $gestion_type      =  isset($params['gestion_type'])       && !empty($params['gestion_type'])       ? $params['gestion_type']       : null;
        $property_zone     =  isset($params['property_zone'])      && !empty($params['property_zone'])      ? $params['property_zone']      : null;
        $bedrooms_min      =  isset($params['bedrooms_min'])       && !empty($params['bedrooms_min'])       ? $params['bedrooms_min']       : null;
        $bedrooms_max      =  isset($params['bedrooms_max'])       && !empty($params['bedrooms_max'])       ? $params['bedrooms_max']       : null;
        $bathrooms_min     =  isset($params['bathrooms_min'])      && !empty($params['bathrooms_min'])      ? $params['bathrooms_min']      : null;
        $bathrooms_max     =  isset($params['bathrooms_max'])      && !empty($params['bathrooms_max'])      ? $params['bathrooms_max']      : null;
        $area_min          =  isset($params['area_min'])           && !empty($params['area_min'])           ? $params['area_min']           : null;
        $area_max          =  isset($params['area_max'])           && !empty($params['area_max'])           ? $params['area_max']           : null;
        $price_max         =  isset($params['price_max'])          && !empty($params['price_max'])          ? $params['price_max']          : null;
        $demand_tags       =  isset($params['demand_tags'])        && !empty($params['demand_tags'])        ? $params['demand_tags']        : null;
        $property_details  =  isset($params['property_details'])   && !empty($params['property_details'])   ? $params['property_details']   : null;
        $profile           =  isset($params['profile'])            && !empty($params['profile'])            ? $params['profile']            : null;

        $demand_tags_values = implode(',',$demand_tags);

        $params['content'] = "
        <h2>Nueva solicitud de busqueda de inmueble</h2><br>
        <b>Nombre:</b> {$name}.<br>\n
        <b>Teléfono:</b> {$phone}.<br>\n
        <b>Email:</b> {$email}.<br>\n 
        <b>Tipo:</b> {$kind}.<br>\n
        <b>Tipo de Gestión:</b> {$gestion_type}.<br>\n
        <b>Zona:</b> {$property_zone}.<br>\n
        <b>Mínimo de Hab:</b> {$bedrooms_min}.<br>\n
        <b>Máximo de Hab:</b> {$bedrooms_max}.<br>\n
        <b>Mínimo de Baños:</b> {$bathrooms_min}.<br>\n
        <b>Máximo de Baños:</b> {$bathrooms_max}.<br>\n
        <b>Área min:</b> {$area_min}.<br>\n
        <b>Área max:</b> {$area_max}.<br>\n
        <b>Precio max:</b> {$price_max}.<br>\n
        <b>Etiquetas:</b> {$demand_tags_values}.<br>\n
        <b>Detalles de propiedad:</b> {$property_details}.<br>\n
        <b>Detalles de perfil:</b> {$profile}.<br>\n";
        return $params;
    }


    static function send_mail(array $data){

        $name       =  isset($data['name'])      && !empty($data['name'])    ? $data['name']     : null;
        $email      =  isset($data['email'])     && !empty($data['email'])   ? $data['email']    : null;
        $mail_to    =  Settings::get_setting('inmoob-settings','mail_to');
        $name_to    =  Settings::get_setting('inmoob-settings','business_name');
        $mail       = new Notification(
            'leads2',
            [ // mail_from
                'name' => 'Web',
                'email' => 'no-reply@web.com',
            ],[ // reply_to
                'name' => $name,
                'email' => $email,
            ],[// mail_to
                'name' =>  $name_to,
                'email' => $mail_to,
            ],
            'Nueva solicitud de busqueda',
            $data
        );

        $send = ($html = $mail->prepare()) ? $mail->send() : false;

        return $send;
        

        
    }

    static function output($atts, $content){

        
        wp_localize_script('LeadsPropsForm','LeadsPropsExtraData',array(
            'redirect_link'     => self::get_redirect_link(),
        ));

        $gestion_types  = Select::gen_options_html(Api::get_terms_select('gestion_types_taxonomy'));
        $property_types = Select::gen_options_html(get_property_types());
        $min_max        = Select::gen_options_html(Api::create_range_options(0,10,1));

        $info_legal     = self::get_atts('info_legal',' Conforme al RGPD y la LOPDGDD, {{settings:business_name}} tratará los datos facilitados, con la finalidad de incluirlo en la base de datos de potenciales clientes y facilitar la información sobre inmuebles que se adapten a sus requerimientos. Siempre que nos lo autorice previamente, enviaremos información relacionada con los productos y los servicios ofrecidos por {{settings:business_name}} , Podrá ejercer, si lo desea, los derechos de acceso, rectificación, supresión, y demás reconocidos en la normativa mencionada. Para obtener más información acerca de cómo estamos tratando sus datos, acceda a nuestra política de privacidad.'); 

        $check_legal    = self::get_atts('check_legal',' ENTIENDO Y ACEPTO el tratamiento de mis datos tal y como se describe anteriormente y se explica con mayor detalle en la Política de Privacidad. (Su negativa a facilitarnos la autorización implicará la imposibilidad de tratar sus datos con la finalidad indicada).'); 

        return "<div class='inmoobstrap inmoob-form-app'>
        <div class='container'>
            <form id='leads-props-form' action='' class='search_props'>
            <div class='row justify-content-between align-items-stretch mb-3'>
            <div class='col-12 mb-2'><h2>Datos personales</h2> </div>
            <div class='col-12 col-md-4 '>
                <label for='name'> <span>¿Cual es tu nombre?</span>
                    <input type='text' class='name' name='name' id='name' placeholder='Nombre completo' required>
                </label>
            </div>
            
            <div class='col-12 col-md-4 '>
                <label for='phone'> <span>¿Cual es tu teléfono?</span>
                    <input type='tel' class='phone' name='phone' id='phone' placeholder='Teléfono movil' required>
                </label>
            </div>

            <div class='col-12 col-md-4 '>
                <label for='email'> <span>¿Cual es tu email?</span>
                    <input type='email' class='email' name='email' id='email' placeholder='Correo electrónico' required>
                </label>
            </div>


            </div>
            <hr class='mt-4 mb-3'>
            <div class='row justify-content-between align-items-stretch mb-2'>
            <div class='col-12 mb-2'><h2>¿Qué estas buscando?</h2> </div>
                    <div class='col-12 col-md-6'>
                        <label for='kind'> <span>Tipo de propiedad</span>
                            <select name='kind' id='kind'>
                                {$property_types}
                            </select>
                        </label>
                    </div>
                    <div class='col-12 col-md-6'>
                        <label for='gestion_type'> <span>&nbsp;</span>
                            <select name='gestion_type' id='gestion_type'>
                                {$gestion_types}
                            </select>
                        </label>
                    </div>
                </div>
                <div class='row'>
                <div class='col-12 col-md-12 my-2'>
                        <label for='property_zone'> <span>¿Donde lo quieres?</span>
                            <textarea class='property_zone' name='property_zone' id='property_zone' placeholder='Zonas de interes' rows='1'></textarea>
                            <small>Indica la zona donde buscas tu propiedad</small>
                        </label>
                    </div>
                    <div class='col-12 col-md-3'>
                        <label for='bedrooms_min'> <span>Mínimo de habitaciones</span>
                            <select name='bedrooms_min' id='bedrooms_min'>
                                {$min_max}
                            </select>
                        </label>
                    </div>
                    <div class='col-12 col-md-3'>
                        <label for='bedrooms_max'> <span>Máximo de habitaciones</span>
                            <select name='bedrooms_max' id='bedrooms_max'>
                                {$min_max}
                            </select>
                        </label>
                    </div>

                    <div class='col-12 col-md-3'>
                    <label for='bathrooms_min'> <span>Mínimo de baños</span>
                        <select name='bathrooms_min' id='bathrooms_min'>
                            {$min_max}
                        </select>
                        </label>
                    </div>
                    <div class='col-12 col-md-3'>
                        <label for='bathrooms_max'> <span>Máximo de baños</span>
                            <select name='bathrooms_max' id='bathrooms_max'>
                                {$min_max}
                            </select>
                        </label>
                    </div>
                </div>

                <div class='row justify-content-start align-items-stretch my-3'>
                    
                    <div class='col-12 col-md-3'>
                        <label for='area_min'> <span>Tamaño mínimo (m²)</span>
                            <input name='area_min' id='area_min' placeholder='Área mínima'/>
                        </label>
                    </div>
                    <div class='col-12 col-md-3'>
                        <label for='area_max'> <span>Tamaño máximo (m²)</span>
                            <input name='area_max' id='area_max' placeholder='Área máxima'/>
                        </label>
                    </div>
                    <div class='col-12 col-md-3'>
                        <label for='price_max'> <span>Precio máximo en €</span>
                            <input name='price_max' id='price_max' placeholder='Precio max' />
                        </label>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-12 mb-3'>
                        <label for='demand_tags'><span>Características deseadas.</span>
                        </label>
                        <input name='demand_tags' class='mb-2' id='demand_tags' placeholder='Selecciona varias características'>
                        <small>Selecciona las características deseadas de tu próxima propiedad.</small>
                    </div>

                    <div class='col-12 mb-3'>
                        <label for='property_details'><span>Coméntanos mas información sobre tu propiedad ideal.</span>
                        <textarea name='property_details' id='property_details' cols='30' rows='2' placeholder='Describe lo que debe tener tu próximo hogar'></textarea>
                        <small>Selecciona las características deseadas de tu próxima propiedad.</small>
                        </label>
                    </div>
                </div>
                
                <hr class='my-2'>


                <div class='row'>
                    <div class='col-12 mb-3'>
                        <label for='profile'><span>Háblanos más sobre ti.</span>
                        <textarea name='profile' class='mb-2' id='profile' cols='30' rows='4'></textarea>
                        <small>Indícanos si estás fuera de españa y en caso de ser así, ¿de donde eres y cuando llegas a la ciudad de Valencia?.</small>
                        </label>
                    </div>
                </div>

                <hr class='my-2'>

                <div class='row'>

                    <div class='col-12'>
                        <h2 class='legal-texts'>Términos y condiciones</h2>

                            <div class='info-legal my-2'>
                            <small>{$info_legal}</small>
                            </div>    
                            <label for='legal'>
                                <input type='checkbox' name='legal' id='legal' required>
                                {$check_legal}
                            </label>
                        </div>
                </div>
    
                <div class='row mt-5'>
                    <div class='col-12 my-2'>
                        <button type='submit'>Voy a tener exito</button>
                    </div>
                </div>
            </form>
        </div>
    </div>";
        
    }


}