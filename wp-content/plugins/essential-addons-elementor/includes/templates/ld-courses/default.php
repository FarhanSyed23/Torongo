<div class="eael-learn-dash-course eael-course-default-layout">
    <div class="eael-learn-dash-course-inner">

        <?php if($image && $settings['show_thumbnail'] === 'true') : ?>
        <a href="<?php echo esc_url(get_permalink($course->ID)); ?>" class="eael-learn-dash-course-thumbnail">
            <img src="<?php echo esc_url($image[0]); ?>" alt="<?php echo $image_alt; ?>" />

            <?php if($settings['show_price'] == 'true') : ?>
            <div class="card-price"><?php echo $legacy_meta['sfwd-courses_course_price'] ? $legacy_meta['sfwd-courses_course_price'] : __('Free', 'essential-addons-elementor'); ?></div>
            <?php endif; ?>
        </a>
        <?php endif; ?>

        <div class="eael-learn-deash-course-content-card">
            <<?php echo $settings['title_tag']; ?> class="course-card-title">
            <a href="<?php echo esc_url(get_permalink($course->ID)); ?>"><?php echo $course->post_title; ?></a>
            </<?php echo $settings['title_tag']; ?>>

            <div class="course-author-meta-inline">
                <img src="<?php echo esc_url( get_avatar_url( $authordata->ID ) ); ?>" alt="<?php echo esc_attr($authordata->display_name); ?>-image" />
                <span>By</span> 
                <a href="<?php echo esc_url($author_courses); ?>">
                <?php echo esc_attr($authordata->display_name); ?></a>
                <span>in</span>
                <?php if (!empty($cats)) : ?>
                <a href="<?php echo $author_courses_from_cat; ?>"><?php echo esc_attr(ucfirst($cats[0]->name)); ?></a>
                <?php endif; ?>
            </div>

            <?php $this->_generate_tags($tags); ?>

            <?php if($settings['show_content'] === 'true' && !empty($short_desc)) : ?> 
            <div class="eael-learn-dash-course-short-desc">
                <?php echo wpautop($this->get_controlled_short_desc($short_desc, $excerpt_length)); ?>
            </div><?php endif; ?>

            <?php
                if($settings['show_progress_bar'] === 'true') {
                    echo do_shortcode( '[learndash_course_progress course_id="' . $course->ID . '" user_id="' . get_current_user_id() . '"]' );
                }
            ?>

            <?php if($settings['show_button'] === 'true') : ?>
                <div class="layout-button-wrap">
                    <a href="<?php echo esc_url(get_permalink($course->ID)); ?>" class="eael-course-button"><?php echo empty($button_text) ? __( 'See More', 'essential-addons-elementor' ) : $button_text; ?></a>
                </div>
            <?php endif; ?>

        </div>

    </div>
</div>