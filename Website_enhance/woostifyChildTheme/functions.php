<?php
/**
 * Woostify Child Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Woostify Child Theme
 * @since 1.0.0
 */
add_action( 'elementor_pro/forms/new_record', function( $record, $ajax_handler ) {
	
	$hewitt_db = new wpdb(SecondDB_USER, SecondDB_PASSWORD, SecondDB_NAME, SecondDB_HOST);
    
    $raw_fields = $record->get( 'fields' );
    $fields = [];
    foreach ( $raw_fields as $id => $field ) {
        $fields[ $id ] = $field['value'];
    }
    
   //global $wpdb;
    $output['success'] = $hewitt_db->insert('demo', array( 'name' => $fields['name'], 'email' => $fields['email'], 'message' => $fields['message']));
    
    $ajax_handler->add_response_data( true, $output );
    
}, 10, 2);