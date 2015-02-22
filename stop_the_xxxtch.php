<?php
/*
Plugin Name: Stop The xxx
Description: (プラグインの短い説明)
Version: 0.1 
Author: Mayuko Moriyama 
Author URI: http://mayuko.me
License: GPL2
*/

function xxxtch_notice( $wp_admin_bar ) {
    if (get_option('xxxtch_root') !== $_SERVER["DOCUMENT_ROOT"]) {
        $title = '<span class="ab-icon"></span><span class="ab-label">' . __('ここはテスト環境です', 'stop-the-xxxtch') . '</span>';

        if (current_user_can('manage_options')) {
            $link = admin_url('options-reading.php#blog_public');
        } else {
            $link = false;
        }
        $wp_admin_bar->add_menu(array(
            'id' => 'xxxtch-notice',
            'meta' => array(),
            'title' => apply_filters('xxxtch-notice-title', $title),
            'href' => apply_filters('xxxtch-notice-link', $link)
        ));
    }
}

function xxxtch_style() {
    if ( ! is_admin() && ! is_user_logged_in() ) { return; }
    ?>
    <style type="text/css">
        #wpadminbar #wp-admin-bar-xxxtch-notice {
            background: orange;
        }
        #wpadminbar #wp-admin-bar-xxxtch-notice .ab-icon:before {
            font-family: 'Genericons';
            content: '\f460';
            color: white;
            font-size: 1.2em;
            top: 1px;
        }
        @media screen and (max-width: 782px) {
            #wp-toolbar > ul > li#wp-admin-bar-xxxtch-notice {
                display:inline;
            }
            #wpadminbar #wp-admin-bar-xxxtch-notice .ab-icon:before {
                font-size: 1em;
                top: 4px;
            }
        }
    </style>
<?php
}

function xxxtch_callback_function() { ?>
    現在のドキュメントルートは <?php echo $_SERVER["DOCUMENT_ROOT"]; ?> です。
    <textarea name="xxxtch_root" id="xxxtch_root" type="text" rows="5" style="width:100%"><?php
        echo esc_html( get_option('xxxtch_root') ); ?></textarea>
<?php
}

function xxxtch_init() {

    add_settings_field('xxxtch_root',
        '本番サイトのドキュメントルート',
        'xxxtch_callback_function',
        'general',
        'default');

    register_setting('general','xxxtch_root');
}
add_action('admin_init', 'xxxtch_init');

add_action( 'admin_bar_menu'    , 'xxxtch_notice', 10000);
add_action( 'admin_print_styles', 'xxxtch_style' , 10000);
add_action( 'wp_head'           , 'xxxtch_style' , 10000);