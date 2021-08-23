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
