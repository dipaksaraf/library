<?php
/*
 * Plugin Name: Easy Digital Downloads - Force account creation by category or tag
 * Description: Forces the customer to create an account at checkout if a download in the cart has a specific download category or tag
 * Author: Andrew Munro
 * Version: 1.0
 */
function sumobi_edd_force_account_creation_by_download_category_or_tag( $ret ) {

	// download categories that the download must belong to before account creation is forced
	$categories_to_search = array( 'cat1', 'cat2', 'cat3' );

	// download tags that the download must belong to before account creation is forced
	$tags_to_search       = array( 'tag1', 'tag2' );

	// get our cart contents
	$cart = edd_get_cart_contents();

	if ( $cart ) {
		// create an array with all our download IDs
		$download_ids = wp_list_pluck( $cart, 'id' );

		if ( $download_ids ) {
			// loop through IDs and check if they belong to any of the categories or tags
			foreach ( $download_ids as $id ) {
				if ( has_term( $categories_to_search, 'download_category', $id ) || has_term( $tags_to_search, 'download_tag', $id ) ) {
					// found one, force account creation
					$ret = (bool) true;
				}
			}
		}
	}

	return $ret;

}
add_filter( 'edd_no_guest_checkout', 'sumobi_edd_force_account_creation_by_download_category_or_tag' );