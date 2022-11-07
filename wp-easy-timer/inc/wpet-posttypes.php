<?php

if ( !defined('ABSPATH') ) {
    die;
}

include_once(WPEASYTIMER_PATH . '/inc/wpet-enqueue.php');

if(!class_exists('WPETCustomPostType')) {

    class WPETCustomPostType {

        public function register() {
            add_action( 'init', [$this,'wpet_custom_post_type'] );
    
            add_action( 'add_meta_boxes', [$this, 'wpet_add_meta_box_timer'] );
            add_action( 'save_post', [$this, 'wpet_save_metabox'], 10, 2);
            
            add_action( 'admin_enqueue_scripts', 'wpet_enqueue_jqueryUI' );
            add_action( 'admin_enqueue_scripts', 'wpet_enqueue_admin' );

            add_action( 'wp_enqueue_scripts', 'wpet_enqueue_front' );

            add_action( 'manage_timer_posts_columns', [$this, 'wpet_posttype_columns']);
            add_action( 'manage_timer_posts_custom_column', [$this, 'wpet_custom_posttype_columns'], 10, 2);
        }

        public function wpet_posttype_columns($columns) {

            $custom_column_order = array(
                'title' => $columns['title'],
                'wpet_shortcode' => esc_html__('Shortcode', 'wpeasytimer'),
                'date' => $columns['date'],
            );

            return $custom_column_order;
        }

        public function wpet_custom_posttype_columns($column, $post_id) {

            switch( $column ) {
                case 'wpet_shortcode':
                    echo '<div>[wpet-timer id="'.$post_id.'"]</div> <br/>';
                    break;
            }

        }
    
        public function wpet_add_meta_box_timer() {
            add_meta_box(
                'wpeasytimer_settings',
                'Настройки таймера',
                [$this, 'wpet_metabox_property_html'],
                'timer',
                'normal',
                'default'
            );
        }
    
        public function wpet_metabox_property_html($post) {
            include("wpet-metaboxes-layout.php");
        }

        public function wpet_save_metabox($post_id, $post) {

            if ( !isset($_POST['_wpet']) || !wp_verify_nonce($_POST['_wpet'], 'wpetmetaboxfields') ) {
                return $post_id;
            }

            if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
                return $post_id;
            }

            if ($post->post_type != 'timer') {
                return $post_id;
            }

            $post_type = get_post_type_object($post->post_type);
            if ( !current_user_can($post_type->cap->edit_post, $post_id)) {
                return $post_id;
            }

            // Global Settings Options

            if(isset( $_POST['wpet_gl_settings_options'] ) ) {
                $old_meta_data = get_post_meta( $post->ID, 'wpet_gl_settings_options', true );
                $new_meta_data = $_POST['wpet_gl_settings_options'];

                if(!empty($old_meta_data)) {
                    update_post_meta($post_id, 'wpet_gl_settings_options', $new_meta_data );
                } else {
                    add_post_meta($post_id, 'wpet_gl_settings_options', $new_meta_data , true );
                }
            } else {
                delete_post_meta( $post->ID, 'wpet_gl_settings_options' );
            }

            // Global Settings DateTime

            if( isset( $_POST['wpet_gl_settings_datetime'] ) ) {
                if ( empty( $_POST['wpet_gl_settings_datetime'] ) ) {
                    $current_time = wp_date('d.m.Y H:i');
                    $current_time = strtotime( "+1 MONTH", strtotime($current_time) );
                    $current_time = date( 'd.m.Y H:i', $current_time );
                    update_post_meta( $post_id, 'wpet_gl_settings_datetime', $current_time );
                } else {
                    update_post_meta( $post_id, 'wpet_gl_settings_datetime', $_POST['wpet_gl_settings_datetime'] );
                }
            } else {
                delete_post_meta( $post_id, 'wpet_gl_settings_datetime' );
            }

            // Heading Settings Text

            if( isset( $_POST['wpet_heading_settings_text'] ) ) {
                update_post_meta( $post_id, 'wpet_heading_settings_text', $_POST['wpet_heading_settings_text'] );
            } else {
                delete_post_meta( $post_id, 'wpet_heading_settings_text' );
            }

            // Heading Settings Font Size

            if( isset( $_POST['wpet_heading_settings_fontsize'] ) ) {
                update_post_meta( $post_id, 'wpet_heading_settings_fontsize', $_POST['wpet_heading_settings_fontsize'] );
            } else {
                delete_post_meta( $post_id, 'wpet_heading_settings_fontsize' );
            }

            // Timer Settings Font Size

            if( isset( $_POST['wpet_tm_settings_fontsize'] ) ) {
                update_post_meta( $post_id, 'wpet_tm_settings_fontsize', $_POST['wpet_tm_settings_fontsize'] );
            } else {
                delete_post_meta( $post_id, 'wpet_tm_settings_fontsize' );
            }

            // Paragraph Settings Text

            if( isset( $_POST['wpet_pgh_settings_text'] ) ) {
                update_post_meta( $post_id, 'wpet_pgh_settings_text', $_POST['wpet_pgh_settings_text'] );
            } else {
                delete_post_meta( $post_id, 'wpet_pgh_settings_text' );
            }

            // Paragraph Settings Font Size

            if( isset( $_POST['wpet_pgh_settings_fontsize'] ) ) {
                update_post_meta( $post_id, 'wpet_pgh_settings_fontsize', $_POST['wpet_pgh_settings_fontsize'] );
            } else {
                delete_post_meta( $post_id, 'wpet_pgh_settings_fontsize' );
            }

            // Button Settings Text

            if( isset( $_POST['wpet_btn_settings_text'] ) ) {
                update_post_meta( $post_id, 'wpet_btn_settings_text', $_POST['wpet_btn_settings_text'] );
            } else {
                delete_post_meta( $post_id, 'wpet_btn_settings_text' );
            }

            // Button Settings Font Size

            if( isset( $_POST['wpet_btn_settings_fontsize'] ) ) {
                update_post_meta( $post_id, 'wpet_btn_settings_fontsize', $_POST['wpet_btn_settings_fontsize'] );
            } else {
                delete_post_meta( $post_id, 'wpet_btn_settings_fontsize' );
            }

            // Button Settings Link

            if( isset( $_POST['wpet_btn_settings_link'] ) ) {
                update_post_meta( $post_id, 'wpet_btn_settings_link', $_POST['wpet_btn_settings_link'] );
            } else {
                delete_post_meta( $post_id, 'wpet_btn_settings_link' );
            }

            return $post_id;
        }
    
        public function wpet_custom_post_type() {
            register_post_type( 'timer',
            array(
                'public' => true,
                'has_archive' => true,
                'rewrite' => array( 'slug' => 'timer' ),
                'label' => 'Таймеры',
                'supports' => array('title'),
                'menu_icon'=> 'dashicons-clock',
            ));
        }
    }

}

if ( class_exists('WPETCustomPostType') ) {
    $wpeasytimer = new WPETCustomPostType();
    $wpeasytimer->register();
}