<?php

//Adding the Open Graph in the Language Attributes
function add_opengraph_doctype($output) {
    return $output . ' xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml"';
}

add_filter('language_attributes', 'add_opengraph_doctype');

//Lets add Open Graph Meta Info
function insert_fb_in_head() {
    
    global $post;
    $title = "Heritage Science Austria";
    $default_image = "https://heritagescience.at/wp-content/themes/elexis/img/HS_logo_1200_630.png";
    $url = "https://heritagescience.at";
    $content = "Die Heritage Science Plattform bietet erstmals einen Überblick über "
            . "die in Österreich verfügbaren Forschungskompetenzen zum kulturellen "
            . "Erbe und Naturerbe an Universitäten, Museen sowie an weiteren außeruniversitären "
            . "Forschungseinrichtungen und Institutionen auf dem Gebiet des Denkmalschutzes.";
    //if the page is a post then we have to add page related og content
    if (is_singular()) {
        $title = get_the_title();
        $url = get_permalink();
        if (has_post_thumbnail($post->ID)) { 
            $thumbnail_src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'large');
            $default_image = esc_attr($thumbnail_src[0]);
        }
        if(has_excerpt($post->ID)) {
            $content = get_the_excerpt($post->ID);
           
        }
    }
    
    echo '<meta property="og:title" content="' . $title . '"/>';
    echo '<meta property="og:type" content="article"/>';
    echo '<meta property="og:url" content="' . $url . '"/>';
    echo '<meta property="og:site_name" content="Heritage Science Austria"/>';
    echo '<meta property="og:image" content="' . $default_image . '"/>';
    echo '<meta property="og:description" content="' . $content . '"/>';
    
    echo '<meta name="twitter:card" content="summary_large_image" />';
    echo '<meta name="twitter:domain" content="'.$url.'" />';
    echo '<meta name="twitter:site" content="'.$url.'" />';
    echo '<meta name="twitter:title" content="Heritage Science Austria" />';
    echo '<meta name="twitter:description" content="' . $content .'" />';
    echo '<meta name="twitter:image" content="' . $default_image . '" />';
    
}

add_action('wp_head', 'insert_fb_in_head', 5);
