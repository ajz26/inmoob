<?php

namespace Inmoob\Classes\Mails;

use OBSER\Classes\Mails\Controller;

class Notification extends Controller{

    protected ?string  $templates_dir = INMOOB_CORE_PLUGIN_DIR_PATH ."/Mails/templates/";

    function before_construct(){

        add_filter('obser_mail',[$this,'override_content'],0,2);

    }

    function override_content($html,$template){
        return override_inmoob_data($html);
    }
}