<?php
/**
 * Template Name: Home
 * 
 * @package bootstrap-basic
 */

get_header();

/**
 * determine main column size from actived sidebar
 */
$main_column_size = bootstrapBasicGetMainColumnSize();
?> 
<?php get_sidebar('left'); ?>
<main id="main" class="site-main row-with-vspace" role="main"> 
	<div class="container">
		<div class="row">
			<div class="col-md-<?php echo $main_column_size; ?> content-area" id="main-column">
				<?php if ( function_exists( 'show_simpleresponsiveslider' ) ) show_simpleresponsiveslider(); ?>
			</div> <!-- #main-column -->
		</div><!-- .row -->
	</div><!-- .container -->
</main>
<div id="breakdown">
	<div id="latest-news">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<h2>Achieve beauty the natural way</h2>
					<hr/>
					<div id="home-content">
						<?php while (have_posts()) {
							the_post();
							get_template_part('content', 'page');
						} //endwhile; ?>
					</div> 
				</div>
				<div class="col-md-6">
					<h2>Latest News</h2>
					<hr/>
					<div id="twitter-news">
		            <a class="twitter-timeline" data-chrome="noborders transparent transparent noheader" data-tweet-limit="2" href="https://twitter.com/HannasHerbs" data-aria-polite="assertive" data-widget-id="579732656545480704" data-chrome="noscrollbar nofooter noborders">Tweets by @HannasHerbs</a>
						<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
					</div>
				</div>
			</div>
		</div><!-- .container -->
	</div><!-- #latest-news -->
	<div id="featured-treatments">
		<div class="container">
			<div class="row row-with-vspace">
				<div class="col-md-12">
					<h2>Featured Products &amp; Treatments</h2><hr/>
				</div>
				<div id="treatments">
					<?php $treatments = get_page_by_path('treatments'); 
					$args = array(
						'child_of' => $treatments->ID,
						'parent' => $treatments->ID,
						'hierarchical' => 0, 
						'sort_column' => "post_title",
						'sort_order' => 'asc'
					); 
					$children = get_pages($args);
					shuffle($children);
					for ($i=0; $i < 3; $i++) :?> 
						<div class="treatment col-md-4">
							<?php $page = $children[$i]; 
							$attr = array(
								'class'	=> "img-responsive",
								'alt'	=> trim( strip_tags( $page->post_excerpt ) ),
								'title'	=> trim( strip_tags( $page->post_title ) ),
							);
							$image_id = get_post_thumbnail_id($page->ID);
							$image_attributes = wp_get_attachment_image_src( $image_id, 'full');

							echo "<a href='".get_page_link($page->ID)."' title='".$page->post_title."'>";
							if (!empty($image_attributes) && isset($image_attributes[0])) : ?>
								<div class="img-container">
									<img class="img-responsive" src="<?php echo $image_attributes[0]; ?>" width="100%" alt="<?php echo $page->post_title ?>"/>
								</div>
							<?php endif; ?>
							<div class="treatment-desc">
								<div class="treatment-title"><?php echo $page->post_title ?></div>
								<?php $in = $page->post_content; 
								$out = strlen($in) > 200 ? substr($in,0,200)."..." : $in;
								echo "<p>".$out."</p>";
								echo "</a>"; ?>
							</div>
						</div>
					<?php endfor; ?>
				</div>
			</div>
		</div><!-- .container -->
	</div><!-- #featured-treatments -->
	<div id="social-networks">
		<div class="container">
			<div class="row row-with-vspace">
				<div class="col-md-12">
					<h2><?php _e("Contact with Face in Figure Salon Taunton:", "portchris") ?></h2>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 text-center">
					<a href="https://www.facebook.com/face.and.figure.salon?fref=ts" target="_blank">
						<img src="<?php echo get_template_directory_uri()?>/img/fb_logo.png" width="100" />
						<h4><?php _e("Facebook", "portchris") ?></h4>
					</a>
				</div>
				<div class="col-md-6 text-center">
					<a href="https://twitter.com/HannasHerbs" target="_blank">
						<img src="<?php echo get_template_directory_uri()?>/img/twitter_logo.png" width="100" />
						<h4><?php _e("Twitter", "portchris") ?></h4>
					</a>
				</div>
			</div>
		</div>
	</div>
</div><!-- #breakdown -->
<?php get_sidebar('right'); ?> 
<?php get_footer(); ?> 