<?php
/**
 * Template archive docs
 *
 * @link       https://wpdeveloper.net
 * @since      1.0.0
 *
 * @package    BetterDocs
 * @subpackage BetterDocs/public
 */

get_header(); 

$alphabetically_order_post = BetterDocs_DB::get_settings('alphabetically_order_post');
$nested_subcategory = BetterDocs_DB::get_settings('nested_subcategory');
$object = get_queried_object();
?>

<div class="betterdocs-category-wraper betterdocs-single-wraper">
	<?php 
		$live_search = BetterDocs_DB::get_settings('live_search');
		if($live_search == 1){
	?>
	<div class="betterdocs-search-form-wrap">
		<?php echo do_shortcode( '[betterdocs_search_form]' ); ?>
	</div>
	<?php } ?>
	<div class="betterdocs-content-area">
		<?php 
		$enable_sidebar_cat_list = BetterDocs_DB::get_settings('enable_sidebar_cat_list');
		if($enable_sidebar_cat_list == 1){
		?>
        <aside id="betterdocs-sidebar">
            <div class="betterdocs-sidebar-content">
                <?php
                echo do_shortcode( '[betterdocs_category_grid sidebar_list="true" posts_per_grid="-1"]' );
                ?>
			</div>
        </aside><!-- #sidebar -->
		<?php } ?>
		<div id="main" class="docs-listing-main">
			<div class="docs-category-listing" >
				<?php 
				$enable_breadcrumb = BetterDocs_DB::get_settings('enable_breadcrumb');
				if($enable_breadcrumb == 1){
					betterdocs_breadcrumbs();
				}
				?>
				<div class="docs-cat-title">
					<?php printf( '<h3>%s </h3>', $object->name ); ?>
					<?php printf( '<p>%s </p>', $object->description ); ?>
				</div>
				<div class="docs-list">
					<?php 
						$args = array(
							'post_type' => 'docs',
							'post_status' => 'publish',
							'posts_per_page' => -1,
							'tax_query' => array(
								array(
									'taxonomy' => 'doc_category',
									'field'    => 'slug',
									'terms'    => $object->slug,
									'include_children'  => false
								),
							),
						);

						if($alphabetically_order_post == 1) {
							$args['orderby'] = 'title';
							$args['order'] = 'ASC';
						}

						$args = apply_filters( 'betterdocs_articles_args', $args, $object->term_id );

						$post_query = new WP_Query( $args );

						if ( $post_query -> have_posts() ) :

							echo '<ul>';
							while ( $post_query -> have_posts() ) : $post_query -> the_post();
								echo '<li><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="0.86em" height="1em" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1536 1792"><path d="M1468 380q28 28 48 76t20 88v1152q0 40-28 68t-68 28H96q-40 0-68-28t-28-68V96q0-40 28-68T96 0h896q40 0 88 20t76 48zm-444-244v376h376q-10-29-22-41l-313-313q-12-12-41-22zm384 1528V640H992q-40 0-68-28t-28-68V128H128v1536h1280zM384 800q0-14 9-23t23-9h704q14 0 23 9t9 23v64q0 14-9 23t-23 9H416q-14 0-23-9t-9-23v-64zm736 224q14 0 23 9t9 23v64q0 14-9 23t-23 9H416q-14 0-23-9t-9-23v-64q0-14 9-23t23-9h704zm0 256q14 0 23 9t9 23v64q0 14-9 23t-23 9H416q-14 0-23-9t-9-23v-64q0-14 9-23t23-9h704z"/></svg><a href="'.get_the_permalink().'">'.get_the_title().'</a></li>';
							endwhile;
							
							echo '</ul>';
						
						endif;
						wp_reset_query();

						// Sub category query
						if( $nested_subcategory == 1 ) {
							$args = array(
								'child_of' => $object->term_id,
								'orderby' => 'name'
							);
							$sub_categories = get_terms( 'doc_category', $args);
							if( $sub_categories ){
								foreach($sub_categories as $sub_category) {
									echo '<span class="docs-sub-cat-title">
									<svg class="toggle-arrow arrow-right" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="0.48em" height="1em" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 608 1280"><g transform="translate(608 0) scale(-1 1)"><path d="M595 288q0 13-10 23L192 704l393 393q10 10 10 23t-10 23l-50 50q-10 10-23 10t-23-10L23 727q-10-10-10-23t10-23l466-466q10-10 23-10t23 10l50 50q10 10 10 23z"/></g></svg>
									<svg class="toggle-arrow arrow-down" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="0.8em" height="1em" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1024 1280"><path d="M1011 480q0 13-10 23L535 969q-10 10-23 10t-23-10L23 503q-10-10-10-23t10-23l50-50q10-10 23-10t23 10l393 393l393-393q10-10 23-10t23 10l50 50q10 10 10 23z"/></svg>
									<a href="#">'.$sub_category->name.'</a></span>';
									echo '<ul class="docs-sub-cat">';
									$sub_args = array(
										'post_type'   => 'docs',
										'post_status' => 'publish',
										'tax_query' => array(
											array(
												'taxonomy' => 'doc_category',
												'field'    => 'slug',
												'terms'    => $sub_category->slug,
												'operator'          => 'AND',
												'include_children'  => false
											),
										),
									);
									$sub_args['posts_per_page'] = -1;
									$sub_args = apply_filters( 'betterdocs_sub_cat_articles_args', $sub_args, $sub_category->term_id );
									$sub_post_query = new WP_Query( $sub_args );
									//print_r($sub_post_query);
									if ( $sub_post_query->have_posts() ) :
										while ( $sub_post_query->have_posts() ) : $sub_post_query->the_post();
											$sub_attr = ['href="'.get_the_permalink().'"'];
											echo '<li class="sub-list"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="0.86em" height="1em" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1536 1792"><path d="M1468 380q28 28 48 76t20 88v1152q0 40-28 68t-68 28H96q-40 0-68-28t-28-68V96q0-40 28-68T96 0h896q40 0 88 20t76 48zm-444-244v376h376q-10-29-22-41l-313-313q-12-12-41-22zm384 1528V640H992q-40 0-68-28t-28-68V128H128v1536h1280zM384 800q0-14 9-23t23-9h704q14 0 23 9t9 23v64q0 14-9 23t-23 9H416q-14 0-23-9t-9-23v-64zm736 224q14 0 23 9t9 23v64q0 14-9 23t-23 9H416q-14 0-23-9t-9-23v-64q0-14 9-23t23-9h704zm0 256q14 0 23 9t9 23v64q0 14-9 23t-23 9H416q-14 0-23-9t-9-23v-64q0-14 9-23t23-9h704z"/></svg><a '.implode(' ',$sub_attr).'>'.get_the_title().'</a></li>';
										endwhile;
									endif;
									wp_reset_query();
									echo '</ul>';
								}
								
							}
						}
						
					?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
get_footer();
