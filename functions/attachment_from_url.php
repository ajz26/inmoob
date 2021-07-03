<?php

add_filter( 'get_attached_file', function( $file, $attachment_id ) {
	if ( empty( $file ) ) {
		$post = get_post( $attachment_id );
		if ( get_post_type( $post ) == 'attachment' ) {
			return $post->guid;
		}
	}
	return $file;
}, 10, 2 );


// add_external_media_without_import();

function add_external_media_without_import() {

    if(defined('DOING_AJAX')) return;

	$raw_urls = array(
        'https://inmoyael.com/assets/uploads/2021/07/image00021-600x400.jpeg',
        'https://inmoyael.com/assets/uploads/2021/07/image00013-scaled.jpeg',
    );


	$urls = array();

	foreach ( $raw_urls as $i => $raw_url ) {
		$urls[$i] = esc_url_raw( trim( $raw_url ) );
	}

	foreach ( $urls as $url ) {
   
        $image_size = @getimagesize( $url );
        if ( empty( $image_size ) ) {
            array_push( $failed_urls, $url );
            continue;
        }

        $width_of_the_image         =   $image_size[0];
        $height_of_the_image        =   $image_size[1];
        $response                   =   wp_remote_head( $url );

        if ( is_array( $response ) && isset( $response['headers']['content-type'] ) ) {
            $mime_type_of_the_image = $response['headers']['content-type'];
        } else {
            continue;
        }
		
		$filename   = wp_basename( $url );
		$attachment = array(
			'guid'              => $url,
			'post_mime_type'    => $mime_type_of_the_image,
			'post_title'        => preg_replace( '/\.[^.]+$/', '', $filename ),
		);
		$attachment_metadata = array(
			'width'     => $width_of_the_image,
			'height'    => $height_of_the_image,
			'file'      => $filename
        );
		$attachment_metadata['sizes']   = array( 'full' => $attachment_metadata );
		$attachment_id                  = wp_insert_attachment( $attachment );

		wp_update_attachment_metadata( $attachment_id, $attachment_metadata );

		array_push( $attachment_ids, $attachment_id );
	}

	$info['attachment_ids'] = $attachment_ids;
	$failed_urls_string     = implode( "\n", $failed_urls );
	$info['urls']           = $failed_urls_string;

	if ( ! empty( $failed_urls_string ) ) {
		$info['error'] = 'Failed to get info of the image(s).';
	}

	return $info;
}