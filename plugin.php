<?php

/**
 * Plugin Name: WP block starter plugin 
 * Description: A bolierplate plugin for blocks 
 * Author: John Robert-Nicoud | 6clicks 
 * Author URI: https://6clicks.ch
 * Text-Domain: wp2-gunter
 * 
 */
if( ! defined('ABSPATH')) : exit(); endif;

final class WP_gunter {

    const VERSION = '1.0.0';

    /**
     * Construct Function
     */
    private function _construct(){
        $this->plugin_constants();
        add_action( 'plugin_loaded', [ $this, 'init_plugin' ] );
    }

    /**
     * Define plugin constants
     */
    public function plugin_constants() {
        define( 'PREFIX_VERSION', self::VERSION );
        define( 'PREFIX_PLUGIN_PATH', trailingslashit( plugin_dir_path( __FILE__ ) ) );
        define( 'PREFIX_PLUGIN_URL', trailingslashit( plugins_url( '/', __FILE__ ) ) );
    }

    /**
     * singletone instance 
     */
    public static function init(){
        static $instance = false;
        if ( ! instance ){
            $instance = new self();
        }
        return $instance;
    }

    /**
     * Plugin init
     */
    public function init_plugin(){
        $this->enqueue_scripts();

    }

    /**
     *  registery scripts enque
     */

     public function enqueue_scripts(){
         add_action( 'enqueue_block_editor_assets', [ $this,
         'register_block_editor_assets'] );
         add_action( 'admin_enqueue_scripts',[ $this, 'register_admin_scripts' ]);
         add_action( 'wp_enqueue_scripts',[ $this, 'register_public_scripts' ]);
        add_action( 'init', [ $this, 'register_blocks'] );
     }

     /**
      * register blocks editor ASSETS
      */
      public function register_block_editor_assets(){
            wp_enqueue_script(
                'prefix-wp2-gunter-plugin',
                PREFIX_PLUGIN_URL . '/build/index.js',
                [
                    'wp-blocks',
                    'wp-editor',
                    'wp-i18n',
                    'wp-element',
                    'wp-components',
                    'wp-data'

                ]
            );
      }

      /**
       * register Admin Scripts 
       */
      public function register_admin_scripts(){
        wp_enqueue_script( 
            'prefix-editor',
            PREFIX_PLUGIN_URL . 'assets/js/editor.js',
            rand(),
            true
        );
        wp_enqueue_style(
            'prefix-editor',
            PREFIX_PLUGIN_URL . '/assets/css/editor.css',
            [],
            false,
            'all'
        );
      }

      /**
       * register public Scripts 
       */
      public function register_public_scripts(){
            wp_enqueue_script( 
                'prefix-public',
                PREFIX_PLUGIN_URL . 'assets/js/scripts.js',
                rand(),
                true
            );
            wp_enqueue_style(
                'prefix-public',
                PREFIX_PLUGIN_URL . '/assets/css/style.css',
                [],
                false,
                'all'
            );
    }
    /**
     * register blocks
     */
    public function register_blocks() {
        register_block_type( 'prefix-blocks/block', [
            'styles' => 'prefix-public',
            'editor_styles' => 'prefix-editor',
            'editor_scripts' => 'prefix-wp2-gunter-plugin',
        ] );
    }


} // fin final class

/**
 * Init main plugin 
 */
function prefix_run_plugin(){
    return WP_gunter::init();
}

/**
 * run the plugin 
 *
 */
prefix_run_plugin();