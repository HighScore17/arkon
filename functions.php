<?php
add_action('after_setup_theme', 'blankslate_setup');
function blankslate_setup()
{
    load_theme_textdomain('blankslate', get_template_directory() . '/languages');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('responsive-embeds');
    add_theme_support('automatic-feed-links');
    add_theme_support('html5', array('search-form', 'navigation-widgets'));
    add_theme_support('woocommerce');
    global $content_width;
    if (!isset($content_width)) {
        $content_width = 1920;
    }
    register_nav_menus(array('main-menu' => esc_html__('Main Menu', 'blankslate')));
}

add_action('admin_notices', 'blankslate_notice');
function blankslate_notice()
{
    $user_id = get_current_user_id();
    $admin_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $param = (count($_GET)) ? '&' : '?';
    if (!get_user_meta($user_id, 'blankslate_notice_dismissed_8') && current_user_can('manage_options'))
        echo '<div class="notice notice-info"><p><a href="' . esc_url($admin_url), esc_html($param) . 'dismiss" class="alignright" style="text-decoration:none"><big>' . esc_html__('Ⓧ', 'blankslate') . '</big></a>' . wp_kses_post(__('<big><strong>📝 Thank you for using BlankSlate!</strong></big>', 'blankslate')) . '<br /><br /><a href="https://wordpress.org/support/theme/blankslate/reviews/#new-post" class="button-primary" target="_blank">' . esc_html__('Review', 'blankslate') . '</a> <a href="https://github.com/tidythemes/blankslate/issues" class="button-primary" target="_blank">' . esc_html__('Feature Requests & Support', 'blankslate') . '</a> <a href="https://calmestghost.com/donate" class="button-primary" target="_blank">' . esc_html__('Donate', 'blankslate') . '</a></p></div>';
}

add_action('admin_init', 'blankslate_notice_dismissed');
function blankslate_notice_dismissed()
{
    $user_id = get_current_user_id();
    if (isset($_GET['dismiss']))
        add_user_meta($user_id, 'blankslate_notice_dismissed_8', 'true', true);
}

add_action('wp_enqueue_scripts', 'blankslate_enqueue');
function blankslate_enqueue()
{
    wp_enqueue_style('blankslate-style', get_stylesheet_uri());
    wp_enqueue_script('jquery');
}

add_action('wp_footer', 'blankslate_footer');
function blankslate_footer()
{
    ?>
    <script>
        jQuery(document).ready(function ($) {
            var deviceAgent = navigator.userAgent.toLowerCase();
            if (deviceAgent.match(/(iphone|ipod|ipad)/)) {
                $("html").addClass("ios");
                $("html").addClass("mobile");
            }
            if (deviceAgent.match(/(Android)/)) {
                $("html").addClass("android");
                $("html").addClass("mobile");
            }
            if (navigator.userAgent.search("MSIE") >= 0) {
                $("html").addClass("ie");
            } else if (navigator.userAgent.search("Chrome") >= 0) {
                $("html").addClass("chrome");
            } else if (navigator.userAgent.search("Firefox") >= 0) {
                $("html").addClass("firefox");
            } else if (navigator.userAgent.search("Safari") >= 0 && navigator.userAgent.search("Chrome") < 0) {
                $("html").addClass("safari");
            } else if (navigator.userAgent.search("Opera") >= 0) {
                $("html").addClass("opera");
            }
            $("#get-a-demo").on("click", function (){
                $([document.documentElement, document.body]).animate({
                    scrollTop: $("#form-get-a-demo-container").offset().top
                }, 2000);
            })
            $("#get-a-demo2").on("click", function (){
                $([document.documentElement, document.body]).animate({
                    scrollTop: $("#form-get-a-demo-container").offset().top
                }, 2000);
            })
            $("#get-a-demo3").on("click", function (){
                $([document.documentElement, document.body]).animate({
                    scrollTop: $("#form-get-a-demo-container").offset().top
                }, 2000);
            })

        });
    </script>
    <?php
}

add_filter('document_title_separator', 'blankslate_document_title_separator');
function blankslate_document_title_separator($sep)
{
    $sep = esc_html('|');
    return $sep;
}

add_filter('the_title', 'blankslate_title');
function blankslate_title($title)
{
    if ($title == '') {
        return esc_html('...');
    } else {
        return wp_kses_post($title);
    }
}

function blankslate_schema_type()
{
    $schema = 'https://schema.org/';
    if (is_single()) {
        $type = "Article";
    } elseif (is_author()) {
        $type = 'ProfilePage';
    } elseif (is_search()) {
        $type = 'SearchResultsPage';
    } else {
        $type = 'WebPage';
    }
    echo 'itemscope itemtype="' . esc_url($schema) . esc_attr($type) . '"';
}

add_filter('nav_menu_link_attributes', 'blankslate_schema_url', 10);
function blankslate_schema_url($atts)
{
    $atts['itemprop'] = 'url';
    return $atts;
}

if (!function_exists('blankslate_wp_body_open')) {
    function blankslate_wp_body_open()
    {
        do_action('wp_body_open');
    }
}
add_action('wp_body_open', 'blankslate_skip_link', 5);
function blankslate_skip_link()
{
    echo '<a href="#content" class="skip-link screen-reader-text">' . esc_html__('Skip to the content', 'blankslate') . '</a>';
}

add_filter('the_content_more_link', 'blankslate_read_more_link');
function blankslate_read_more_link()
{
    if (!is_admin()) {
        return ' <a href="' . esc_url(get_permalink()) . '" class="more-link">' . sprintf(__('...%s', 'blankslate'), '<span class="screen-reader-text">  ' . esc_html(get_the_title()) . '</span>') . '</a>';
    }
}

add_filter('excerpt_more', 'blankslate_excerpt_read_more_link');
function blankslate_excerpt_read_more_link($more)
{
    if (!is_admin()) {
        global $post;
        return ' <a href="' . esc_url(get_permalink($post->ID)) . '" class="more-link">' . sprintf(__('...%s', 'blankslate'), '<span class="screen-reader-text">  ' . esc_html(get_the_title()) . '</span>') . '</a>';
    }
}

add_filter('big_image_size_threshold', '__return_false');
add_filter('intermediate_image_sizes_advanced', 'blankslate_image_insert_override');
function blankslate_image_insert_override($sizes)
{
    unset($sizes['medium_large']);
    unset($sizes['1536x1536']);
    unset($sizes['2048x2048']);
    return $sizes;
}

add_action('widgets_init', 'blankslate_widgets_init');
function blankslate_widgets_init()
{
    register_sidebar(array(
        'name' => esc_html__('Sidebar Widget Area', 'blankslate'),
        'id' => 'primary-widget-area',
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
}

add_action('wp_head', 'blankslate_pingback_header');
function blankslate_pingback_header()
{
    if (is_singular() && pings_open()) {
        printf('<link rel="pingback" href="%s" />' . "\n", esc_url(get_bloginfo('pingback_url')));
    }
}

add_action('comment_form_before', 'blankslate_enqueue_comment_reply_script');
function blankslate_enqueue_comment_reply_script()
{
    if (get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}

function blankslate_custom_pings($comment)
{
    ?>
    <li <?php comment_class(); ?>
            id="li-comment-<?php comment_ID(); ?>"><?php echo esc_url(comment_author_link()); ?></li>
    <?php

}

add_filter('get_comments_number', 'blankslate_comment_count', 0);
function blankslate_comment_count($count)
{
    if (!is_admin()) {
        global $id;
        $get_comments = get_comments('status=approve&post_id=' . $id);
        $comments_by_type = separate_comments($get_comments);
        return count($comments_by_type['comment']);
    } else {
        return $count;
    }
}
wp_enqueue_script( 'main-js', get_template_directory_uri().'/assets/js/main.js', array('jquery'), "3.3.2", true );

/**
 * Show HTML emails instead plain text
 */
add_filter('wp_mail_content_type', function( $content_type ) {
    return 'text/html';
});

/**
 * Contact Form Submission
 */
function send_contact_email() {

    $fname = $_POST['user_fname'];
    $lname = $_POST['user_lname'];
    $company = $_POST['user_company'];
    $email = $_POST['user_email'];
    $subject = "Luis Angel Jiménez León Test";
    $content = "
        <html>
        <head>
            <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
        </head>
        <body>
            <div>
            <table class='es-wrapper' width='100%' cellspacing='0' cellpadding='0'>
                <tbody>
                    <tr>
                        <td class='esd-email-paddings' valign='top'>
                            <table cellpadding='0' cellspacing='0' class='es-header esd-header-popover' align='center'>
                                <tbody>
                                    <tr>
                                        <td class='esd-stripe' esd-custom-block-id='3089' align='center'>
                                            <table class='es-header-body' width='600' cellspacing='0' cellpadding='0' align='center'>
                                                <tbody>
                                                    <tr>
                                                        <td class='esd-structure es-p10t es-p10b es-p10r es-p10l' align='left'>
                                                            <table width='100%' cellspacing='0' cellpadding='0'>
                                                                <tbody>
                                                                    <tr>
                                                                        <td class='esd-container-frame' width='580' valign='top' align='left'>
                                                                            <table width='100%' cellspacing='0' cellpadding='0'>
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td class='esd-block-image' align='left' style='font-size:0'><a href='https://arkon-test-c4f69b.ingress-comporellon.ewp.live/' target='_blank'><img src='https://arkon-test-c4f69b.ingress-comporellon.ewp.live/wp-content/uploads/2023/01/logo_arkon.png' alt='Arkon Data Logo' title='Arkon Data Logo' width='109'></a></td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class='es-content esd-footer-popover' cellspacing='0' cellpadding='0' align='center'>
                                <tbody>
                                    <tr>
                                        <td class='esd-stripe' esd-custom-block-id='3109' align='center'>
                                            <table class='es-content-body' style='background-color: #ffffff; margin-bottom: 50px' width='600' cellspacing='0' cellpadding='0' bgcolor='#ffffff' align='center'>
                                                <tbody>
                                                    <tr>
                                                        <td class='esd-structure es-p20t es-p20b es-p40r es-p40l' esd-general-paddings-checked='true' align='left'>
                                                            <table width='100%' cellspacing='0' cellpadding='0'>
                                                                <tbody>
                                                                    <tr>
                                                                        <td class='esd-container-frame' width='520' valign='top' align='center'>
                                                                            <table width='100%' cellspacing='0' cellpadding='0'>
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td class='esd-block-text' align='left'>
                                                                                            <h1 style='color: #0d2643;'>NEW DEMO REQUEST</h1>
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                            <table style='margin-right: auto;' align='left'>
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td align='left' colspan='1'>
                                                                                            <p>User information: </p>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td><b>First Name:</b></td>
                                                                                        <td>$fname<br></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td><b>Last Name:</b></td>
                                                                                        <td>$lname</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td><b>Company:</b></td>
                                                                                        <td>$company</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td><b>Email:</b></td>
                                                                                        <td>$email</td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <hr>
                                    <tr>
                                        <td class='esd-structure es-p20t es-p20b es-p40r es-p40l' esd-general-paddings-checked='true' align='left'>
                                            <table width='100%' cellspacing='0' cellpadding='0'>
                                                <tbody>
                                                    <tr>
                                                        <td class='esd-container-frame' width='520' valign='top' align='center'>
                                                            <table width='100%' cellspacing='0' cellpadding='0'>
                                                                <tbody>
                                                                    <tr>
                                                                        <td class='esd-block-spacer es-p20t es-p20b es-p5r' align='center' style='font-size:0'>
                                                                            <table width='100%' height='100%' cellspacing='0' cellpadding='0' border='0'>
                                                                                <tbody style='text-align: center; margin-bottom:50px;'>
                                                                                    <tr>
                                                                                        <td><a target='_blank' href='https://www.linkedin.com/company/arkondata/'><img width='30' src='https://arkon-test-c4f69b.ingress-comporellon.ewp.live/wp-content/uploads/2023/01/linkedin_logo.png'></a></td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
            </div>
        </body>
    </html>
        ";

    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'From: luis.angel.jleon@gmail.com' . "\r\n";
    wp_mail( "marketing@arkondata.com", $subject, $content, $headers );
    wp_mail( "luis.angel.jleon@gmail.com", $subject, $content, $headers );

}

add_action('wp_ajax_send_email', 'send_contact_email');
add_action('wp_ajax_send_email', 'send_contact_email');
