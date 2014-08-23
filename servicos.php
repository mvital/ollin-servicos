<?php
/*
Plugin Name: Serviços
Plugin URI: http://mariovital.com/
Description: Plugin especifico para a mostrar serviços -> excerto / ver mais -> descrição do Serviço.
Version: 0.1
Author: Mario Vital
Author URI: http://mariovital.com/
License: GPLv2
*/
?>
<?php

add_action( 'init', 'criar_servico' );

function criar_servico() {
    register_post_type( 'servicos',
        array(
            'labels' => array(
                'name' => 'Serviços',
                'singular_name' => 'Serviço',
                'add_new' => 'Adicionar Novo',
                'add_new_item' => 'Adiciona novo Serviço',
                'edit' => 'Editar',
                'edit_item' => 'Editar Serviço',
                'new_item' => 'Novo Serviço',
                'view' => 'Ver',
                'view_item' => 'Ver Serviços',
                'search_items' => 'Procurar Serviços',
                'not_found' => 'Não foi encontrado nenhum Serviço',
                'not_found_in_trash' => 'Não foi encontrado nenhum Serviço na Lixeira/trash',
                'parent' => 'sem msg'
            ),
 
            'public' => true,
            'menu_position' => 25,
            'supports' => array( 'title', 'editor', 'excerpt', 'thumbnail', 'custom-fields' ),
            'taxonomies' => array( '' ),
            'menu_icon' => plugins_url( 'images/icon16x16.png', __FILE__ ),
            'has_archive' => true
        )
    );
}


add_action( 'admin_init', 'my_admin' );

function my_admin() {
     add_meta_box( 'prfx_meta', __( 'Cor da caixa', 'prfx-textdomain' ), 'display_servicos_meta_box', 'servicos' );
   
}

function display_servicos_meta_box( $servicos ) {
    wp_nonce_field( basename( __FILE__ ), 'prfx_nonce' );
	$prfx_stored_meta = get_post_meta( $servicos->ID );
	?>
	<p>
		<label for="meta-color" class="prfx-row-title"><?php _e( 'Escolha a cor de fundo: ', 'prfx-textdomain' )?></label>
		<input name="meta-color" type="text" value="<?php if ( isset ( $prfx_stored_meta['meta-color'] ) ) echo $prfx_stored_meta['meta-color'][0]; ?>" class="meta-color" />
	</p>
	
	<p>
	    <label for="meta-image" class="prfx-row-title"><?php _e( 'Escolha a imagem para a "caixa":', 'prfx-textdomain' )?></label>
	    <input type="text" name="meta-image" id="meta-image" value="<?php if ( isset ( $prfx_stored_meta['meta-image'] ) ) echo esc_url( $prfx_stored_meta['meta-image'][0]); ?>" />
	    <input type="button" id="meta-image-button" class="button" value="<?php _e( 'Escolha / Upload', 'prfx-textdomain' )?>" />
	</p>
	<p>
	
	<?php
}
    

add_action( 'save_post', 'add_servicos_fields', 10, 2 );


function add_servicos_fields( $servicos_id, $servicos ) {
// Checks save status
	$is_autosave = wp_is_post_autosave( $servicos_id );
	$is_revision = wp_is_post_revision( $servicos_id );
	$is_valid_nonce = ( isset( $_POST[ 'prfx_nonce' ] ) && wp_verify_nonce( $_POST[ 'prfx_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
	// Exits script depending on save status
	if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
		return;
	}
 
	

	// Checks for input and saves if needed
	if( isset( $_POST[ 'meta-color' ] ) ) {
		update_post_meta( $servicos_id, 'meta-color', $_POST[ 'meta-color' ] );
		
	}
	// Checks for input and saves if needed
	if( isset( $_POST[ 'meta-image' ] ) ) {
	    update_post_meta( $servicos_id, 'meta-image', $_POST[ 'meta-image' ] );
	}
}

/**
 * Adds the meta box stylesheet when appropriate
 */
 

function servicos_admin_styles() {
	global $typenow;
	if( $typenow == 'servicos' ) {
		wp_enqueue_style( 'servicos_meta_box_styles', plugin_dir_url( __FILE__ ) . 'meta-box-styles.css' );
	}
}

add_action( 'admin_print_styles', 'servicos_admin_styles' );

/**
 * Adds color picker 
 */

function servicos_color_enqueue() {
	global $typenow;
	if( $typenow == 'servicos' ) {
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'meta-box-color-js', plugin_dir_url( __FILE__ ) . 'meta-box-color.js', array( 'wp-color-picker' ) );
	}
	?>
	
    <?php
}
add_action( 'admin_enqueue_scripts', 'servicos_color_enqueue' );

/**
 * Loads the image management javascript
 */
function servicos_image_enqueue() {
    global $typenow;
    if( $typenow == 'servicos' ) {
        wp_enqueue_media();
 
        // Registers and enqueues the required javascript.
        wp_register_script( 'meta-box-image', plugin_dir_url( __FILE__ ) . 'meta-box-image.js', array( 'jquery' ) );
        wp_localize_script( 'meta-box-image', 'meta_image',
            array(
                'title' => __( 'Escolher/Upload', 'prfx-textdomain' ),
                'button' => __( 'Usar esta imagem', 'prfx-textdomain' ),
            )
        );
        wp_enqueue_script( 'meta-box-image' );
     
    }
}
add_action( 'admin_enqueue_scripts', 'servicos_image_enqueue' );


/** 
 * Preparação para o template 
 */
 
add_filter( 'template_include', 'include_template_function', 1 );

function include_template_function( $template_path ) {
    if ( get_post_type() == 'servicos' ) {
        if ( is_single() ) {
            // checks if the file exists in the theme first,
            // otherwise serve the file from the plugin
            if ( $theme_file = locate_template( array ( 'single-servicos.php' ) ) ) {
                $template_path = $theme_file;
            } else {
                $template_path = plugin_dir_path( __FILE__ ) . 'single-servicos.php';
            }
        }
    }
    return $template_path;
}
