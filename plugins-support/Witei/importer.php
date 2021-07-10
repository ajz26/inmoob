<?php

// If the plug-in for background processes is not installed, then we will connect it from the vendor folder
if ( ! class_exists( 'WP_Async_Request' ) AND ! class_exists( 'WP_Background_Process' ) ) {
	$wp_background_processing_path = OBSER_FRAMEWORK_DIR_PATH . 'vendor/wp-background-processing/wp-background-processing.php';
	if ( file_exists( $wp_background_processing_path ) ) {
		require_once $wp_background_processing_path;
	}
	unset( $wp_background_processing_path );
}


add_action('admin_bar_menu', function ($admin_bar){

    $admin_bar->add_menu( array(
        'id'    => 'inmoob_reimport_properties',
        'title' => "Importar propiedades",
    ));

}, 100);



if ( class_exists( 'WP_Background_Process' ) AND ! class_exists( 'Inmoob_witei_importer' ) ) {

	class Inmoob_witei_importer extends WP_Background_Process {

		protected $heuristic_data;
		protected $prefix = 'CCOM';
		protected $action = 'Inmoob_witei_importer';

		private function get_data_key() {
			return $this->identifier . '_data';
		}

		public function set_stats_data( $count ) {
                update_option(
                    $this->get_data_key(), array(
                    'created' => date( 'U' ),
                    'count_tasks' => (int) $count,
                )
			);

			return $this;
		}


		public function get_stats_data() {
			if ( $stats_data = get_option( $this->get_data_key() ) ) {
				if ( ! empty( $stats_data['count_tasks'] ) ) {
					$batch = $this->get_batch();
					$outstanding_tasks = count( $batch->data );
					$stats_data['completed_tasks'] = 0;
					if ( $stats_data['count_tasks'] > $outstanding_tasks AND $outstanding_tasks ) {
						$stats_data['completed_tasks'] = $stats_data['count_tasks'] - $outstanding_tasks;
					} elseif ( $stats_data['count_tasks'] != $outstanding_tasks ) {
						$stats_data['completed_tasks'] = $stats_data['count_tasks'];
					}
				}

				return $stats_data;
			}

			return array();
		}


		protected function task( $json ) {

            $path = Inmoob\Api\Endpoints\Witei\Create::get_path();


            $request   = new WP_REST_Request( 'POST', $path );
            $request->set_header( 'content-type', 'application/json' );
            $request->set_body( json_decode($json) );

			$res = Inmoob\Api\Endpoints\Witei\Create::callback($request);

			error_log($res->ID);

			return FALSE;
		}

		protected function complete() {
			parent::complete();
			error_log('complete');
			delete_option( $this->get_data_key() );
		}

	}

	global $Inmoob_witei_importer;

    $Inmoob_witei_importer = new Inmoob_witei_importer();

}

add_action('wp_ajax_reimport_witei_props','reimport_witei_props');

function reimport_witei_props(){

	global $Inmoob_witei_importer;

	if ( $Inmoob_witei_importer instanceof Inmoob_witei_importer ) {

		$token  = 'c90576fc9b004ecba94e2ac4f9bcc866';
        $url    = 'https://witei.com/api/v1/houses/?status=available';
        $args   = array(
            'headers' => array(
            'Authorization' => "Bearer {$token}"
            )
        );
        
        // Send remote request
        $request = wp_remote_get($url, $args);
        
        // Retrieve information
        $response_code      = wp_remote_retrieve_response_code($request);
        $response_message   = wp_remote_retrieve_response_message($request);
        $response_body      = wp_remote_retrieve_body($request);

        if (is_wp_error($request) ) {
            return new WP_Error($response_code, $response_message, $response_body);
        }
        $response_body  = json_decode($response_body) ?: array();

        $props          = isset($response_body->results) ? $response_body->results : array();
		
        
        foreach ( $props as $prop ) {
            $json   = json_encode($prop,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
			$Inmoob_witei_importer->push_to_queue( $json );
		}
	
		if (isset($response_body->count) && $response_body->count >= 1 ) {
			error_log('iniciar');
            
			$Inmoob_witei_importer->save()->dispatch();

			$Inmoob_witei_importer->set_stats_data( $response_body->count );

		}
		
		wp_die($props);
	}

	wp_die(0);

}

