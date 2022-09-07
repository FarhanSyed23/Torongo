<?php

/**
 * Template Name: Layout 2
 *
 */

echo '<a href="'.get_term_link( $term->slug, 'doc_category' ).'" class="eael-better-docs-category-box-post layout__2">';
    echo '<div class="eael-bd-cb-inner">';

    if($settings['show_icon']) {
        $cat_icon_id = get_term_meta( $term->term_id, 'doc_category_image-id', true);

        if($cat_icon_id){
            $cat_icon = wp_get_attachment_image( $cat_icon_id, 'thumbnail', [ 'alt' => esc_attr(get_post_meta($cat_icon_id, '_wp_attachment_image_alt', true)) ] );
        } else {
            $cat_icon = '<img src="'.BETTERDOCS_ADMIN_URL.'assets/img/betterdocs-cat-icon.svg" alt="betterdocs-category-box-icon">';
        }

        echo '<div class="eael-bd-cb-cat-icon__layout-2">'.$cat_icon.'</div>';
    }

    if($settings['show_title']) {
        echo '<'.$settings['title_tag'].' class="eael-bd-cb-cat-title__layout-2"><span>'.$term->name.'</span></'.$settings['title_tag'].'>';
    }

    if($settings['show_count']) {
        printf('<div class="eael-bd-cb-cat-count__layout-2"><span class="count-inner__layout-2">%s</span></div>', $this->eael_get_doc_post_count($term->count, $term->term_id));
    }

    echo '</div>';
echo '</a>';
