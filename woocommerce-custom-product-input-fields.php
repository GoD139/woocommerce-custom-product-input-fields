<?php
/*
Plugin Name: Custom woocommerce fields
Plugin URI: http://fanboy.dk
description: Lets you enter when a product was originally released
Version: 1.0
Author: Benjamin Behrens
Author URI: http://benjaminbehrens.com
License: GPL2
*/


$productReleased = new productReleased();


/**
 *
 */
class productReleased
{

  private $releaseDate_id;
  private $trailerVideoLink;
  private $gameplayVideoLink;
  private $ETProduct;
  private $noMarkup;
  private $shippingCost;

    public function __construct() {

      $this->releaseDate_id = 'product_released_date';
      $this->trailerVideoLink = 'product_trailer_video_link';
      $this->gameplayVideoLink = 'product_gameplay_video_link';
      $this->ETProduct = '_disable_eet';
      $this->shippingCost = '_shipping_cost';
      


        //create field and make it savable
        
        
        //Product gameplay video
        add_action('woocommerce_product_options_general_product_data', array( $this,'cfwc_create_custom_gameplay_video_field') );
        add_action('woocommerce_process_product_meta', array( $this, 'add_custom_linked_gameplay_video_field_save' ));
        
        //Product trailer
        add_action('woocommerce_product_options_general_product_data', array( $this,'cfwc_create_custom_trailer_video_field') );
        add_action('woocommerce_process_product_meta', array( $this, 'add_custom_linked_trailer_video_field_save' ));
        
        //Product Release date
        add_action('woocommerce_product_options_general_product_data', array( $this,'cfwc_create_custom_release_date_field') );
        add_action('woocommerce_process_product_meta', array( $this, 'add_custom_linked_release_date_field_save' ));
        
        //EET PRODUCT
        add_action('woocommerce_product_options_general_product_data', array( $this,'cfwc_create_disable_eet_field') );
        add_action('woocommerce_process_product_meta', array( $this, 'add_custom_disable_eet_field_save' ));

        //shipping cost
        add_action('woocommerce_product_options_general_product_data', array( $this,'cfwc_create_shipping_cost_field') );
        add_action('woocommerce_process_product_meta', array( $this, 'add_custom_shipping_cost_field_save' ));


  	    add_shortcode( 'cpi_gameplay_video', array($this, 'custom_products_input_gameplay_video_shortcode') );
  	    add_shortcode( 'cpi_trailer_video', array($this, 'custom_products_input_trailer_video_shortcode') );
    }






    function cfwc_create_custom_release_date_field() {
     $args = array( 'id' => $this->releaseDate_id, 'label' => __( 'Products release date', 'cfwc' ), 'class' => 'cfwc-custom-field', 'type' => 'date', 'desc_tip' => true, 'description' => __( 'Enter products release date', 'ctwc' ), );
     woocommerce_wp_text_input( $args );
    }


    public function add_custom_linked_release_date_field_save( $post_id ) {

      if ( !( isset( $_POST['woocommerce_meta_nonce'], $_POST[ $this->releaseDate_id ] ) || wp_verify_nonce( sanitize_key( $_POST['woocommerce_meta_nonce'] ), 'woocommerce_save_data' ) ) ) {
        return false;
      }

      $product_release = sanitize_text_field(wp_unslash( $_POST[ $this->releaseDate_id ] ));
      update_post_meta($post_id,$this->releaseDate_id,esc_attr( $product_release ));
    }
    
    
    
    
    
    
    function cfwc_create_custom_trailer_video_field() {
     $args = array( 'id' => $this->trailerVideoLink, 'label' => __( 'Products trailer', 'cfwc' ), 'class' => 'cfwc-custom-field', 'type' => 'text', 'desc_tip' => true, 'description' => __( 'Enter trailer video', 'ctwc' ), );
     woocommerce_wp_text_input( $args );
    }


    public function add_custom_linked_trailer_video_field_save( $post_id ) {

      if ( !( isset( $_POST['woocommerce_meta_nonce'], $_POST[ $this->trailerVideoLink ] ) || wp_verify_nonce( sanitize_key( $_POST['woocommerce_meta_nonce'] ), 'woocommerce_save_data' ) ) ) {
        return false;
      }

      $product_release = $this->search_youtube_video_embed_replace(sanitize_text_field(wp_unslash( $_POST[ $this->trailerVideoLink ] )));
      update_post_meta($post_id,$this->trailerVideoLink,esc_attr( $product_release ));
    }
    
    
    
    
    function cfwc_create_shipping_cost_field() {
     $args = array( 'id' => $this->shippingCost, 'label' => __( 'Shipping cost', 'cfwc' ), 'class' => 'cfwc-custom-field', 'type' => 'text', 'desc_tip' => true, 'description' => __( 'Enter shipping cost', 'ctwc' ), );
     woocommerce_wp_text_input( $args );
    }


    public function add_custom_shipping_cost_field_save( $post_id ) {

      if ( !( isset( $_POST['woocommerce_meta_nonce'], $_POST[ $this->shippingCost ] ) || wp_verify_nonce( sanitize_key( $_POST['woocommerce_meta_nonce'] ), 'woocommerce_save_data' ) ) ) {
        return false;
      }

      $product_release = $this->search_youtube_video_embed_replace(sanitize_text_field(wp_unslash( $_POST[ $this->shippingCost ] )));
      update_post_meta($post_id,$this->shippingCost,esc_attr( $product_release ));
    }





    function cfwc_create_custom_gameplay_video_field() {
     $args = array( 'id' => $this->gameplayVideoLink, 'label' => __( 'Products gameplay video', 'cfwc' ), 'class' => 'cfwc-custom-field', 'type' => 'text', 'desc_tip' => true, 'description' => __( 'Enter gameplay video', 'ctwc' ), );
     woocommerce_wp_text_input( $args );
    }


    public function add_custom_linked_gameplay_video_field_save( $post_id ) {

      if ( !( isset( $_POST['woocommerce_meta_nonce'], $_POST[ $this->gameplayVideoLink ] ) || wp_verify_nonce( sanitize_key( $_POST['woocommerce_meta_nonce'] ), 'woocommerce_save_data' ) ) ) {
        return false;
      }

      $product_release = $this->search_youtube_video_embed_replace(sanitize_text_field(wp_unslash( $_POST[ $this->gameplayVideoLink ] )));
      update_post_meta($post_id,$this->gameplayVideoLink,esc_attr( $product_release ));
    }






    function cfwc_create_disable_eet_field() {
      
      woocommerce_wp_checkbox( array(
        'id' => $this->ETProduct,
        'label' => __( 'Disable ET product info', 'cfwc' ), 
        'class' => 'cfwc-custom-field', 
        'desc_tip' => true, 
        'description' => __( 'Does so ET don\'t update weight/price', 'ctwc' )
    ));
      
     // $args = array( 'id' => $this->ETProduct, 'label' => __( 'Is ET product', 'cfwc' ), 'class' => 'cfwc-custom-field', 'type' => 'checkbox', 'desc_tip' => true, 'description' => __( 'Indicates its an ET product', 'ctwc' ), );
     // woocommerce_wp_text_input( $args );
    }


    public function add_custom_disable_eet_field_save( $post_id ) {
      $engrave_text_option = isset( $_POST[ $this->ETProduct ] ) ? 'yes' : 'no';
      update_post_meta($post_id,$this->ETProduct,esc_attr( $engrave_text_option ));
    }
    
    
    
    
    









	function custom_products_input_gameplay_video_shortcode( $atts ) {
		if ( ! empty( get_post_meta( get_the_ID(), 'product_gameplay_video_link', true ) ) ) {
			echo ' <span class="gameplay_video_single_product"><h3>Gameplay</h3></span>
		<div class="embed-responsive embed-responsive-16by9">
							<iframe  class="embed-responsive-item" src="' . get_post_meta( get_the_ID(), 'product_gameplay_video_link', true ) . '?rel=0&controls=1&amp;showinfo=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
						</div>';
		}


	}

	function custom_products_input_trailer_video_shortcode( $atts ) {
		if ( ! empty( get_post_meta( get_the_ID(), 'product_trailer_video_link', true ) ) ) {
			echo ' <span class="gameplay_video_single_product"><h3>Trailer</h3></span>
		<div class="embed-responsive embed-responsive-16by9">
							<iframe  class="embed-responsive-item" src="' . get_post_meta( get_the_ID(), 'product_trailer_video_link', true ) . '?rel=0&controls=1&amp;showinfo=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
						</div>';
		}


	}

	function search_youtube_video_embed_replace($string){
    	return str_replace('watch?v=','embed/',$string);
	}


  


}
