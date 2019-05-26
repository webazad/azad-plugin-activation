<?php
/**
 * The code is to add azad plugin activation plugin in the functions.php file.
 */
/**
 * Azad Plugin Activation.
 */
/**
if(file_exists(trailingslashit(dirname(__FILE__)).'inc/azad-plugin-activation/config.php')){
	require_once(trailingslashit(dirname(__FILE__)).'inc/azad-plugin-activation/config.php');
}
 */
// CALL THE CORE FILE 
if(file_exists(trailingslashit(dirname(__FILE__)).'class-azad-plugin-activation.php')){
	require_once(trailingslashit(dirname(__FILE__)).'class-azad-plugin-activation.php');
}
function apa_plugins(){
    $plugins = array(
        array(
            'name' => 'Wordpress Reset',
            'slug' => 'wordpress-reset',
            'source' => 'azad',
            'required' => true
        ),
        array(
            'name' => 'Akismet',
            'slug' => 'akismet',
            'version' => '2',
            'required' => false
        ),
        array(
            'name' => 'Woocommerce',
            'slug' => 'woocommerce',
            'version' => '2',
            'required' => true
        ),
        array(
            'name'      => 'Elementor',
            'slug'      => 'elementor',
            'source'    => 'asdf',
            'required'  => true
        )
    );
    $config = array(
        'id' => 'apa',
        'default_path' => '',
        'menu' => 'apa-install-plugins',
        'parent_slug' => 'theme.php',
        'capability' => 'edit_theme_options',
        'has_notices' => true,
        'dismissible' => true,
        'dismiss_msg' => '',
        'is_automatic' => false,
        'message' => ''
    );
    apa( $plugins, $config );
}
add_action('apa_register','apa_plugins');