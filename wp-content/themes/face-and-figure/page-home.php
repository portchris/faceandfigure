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
$usps = simple_fields_fieldgroup('usps');
$social = simple_fields_fieldgroup('social_connect');
?> 
<?php get_sidebar('left'); ?>
<main id="main" class="site-main row-with-vspace" role="main"> 
	<div class="container">
		<div class="row">
			<div class="col-md-<?php echo $main_column_size; ?> content-area" id="main-column">
				<?php if (function_exists('show_simpleresponsiveslider')) show_simpleresponsiveslider(); ?>
			</div> <!-- #main-column -->
		</div><!-- .row -->
	</div><!-- .container -->
</main>
<div id="breakdown">
	<?php if (isset($usps) && !empty($usps)): ?>
		<div id"usps" class="row-with-vspace">
			<div class="container">
				<div class="row">
					<?php $perRow = 3;
					$c = count($usps);
					for ($i = 0; $i < $c; $i++) {
						$usp = $usps[$i];
						$t = (isset($usp["usp_title"]) && !empty($usp["usp_title"])) ? $usp['usp_title'] : '';
						$img = (isset($usp["usp_img"]) && !empty($usp["usp_img"])) ? $usp['usp_img'] : '';
						$desc = (isset($usp["usp_desc"]) && !empty($usp["usp_desc"])) ? $usp['usp_desc'] : '';
						$cta = (isset($usp["usp_cta"]) && !empty($usp["usp_cta"])) ? $usp['usp_cta'] : '';
						$cta = (is_numeric($cta)) ? get_permalink($cta) : $cta;
						$txt = (isset($usp["usp_cta_text"]) && !empty($usp["usp_cta_text"])) ? $usp['usp_cta_text'] : __('Read more', 'portchris');
						$_blank = (isset($usp["usp_target"]) && !empty($usp["usp_target"])) ? 'target="_blank" ' : '';
						echo ($i !== 0 && $i % $perRow === 0) ? '</div><div class="row">' : '';
						echo '<div class="usp col-sm-4 row-with-vspace"><div class="row-with-vspace">';
						echo '<table><tr>';
						if (strlen($img) > 0) {
							echo '<td>';
							if (strlen($cta) > 0) {
								echo '<a href="' . $cta . '" title="' . $t . '" ' . $_blank . '>';
							}
							echo '<img class="img-responsive usp-img" src="' . wp_get_attachment_url($img) . '" alt="' . $t . '" />';
							if (strlen($cta) > 0) {
								echo '</a>';
							}
							echo '</td>';
						}
						if (strlen($t) > 0) {
							echo '<td><h3>' . $t . '</h3></td>';
						}
						echo '</tr></table></div><div class="col-sm-12">';
						if (strlen($desc) > 0) {
							echo '<small>' . $desc . '</small>';
						}
						if (strlen($cta) > 0) {
							echo '<a role="button" class="btn btn-default" href="' . $cta . '" title="' . $t . '" ' . $_blank . '>' . $txt . '</a>';
						}
						echo '</div></div>';
					} ?>
				</div>
			</div>
		</div><!-- #usps -->
	<?php endif; ?>
	<div id="featured-treatments">
		<div class="container">
			<div class="row">
				<div class="col-sm-8">
					<h2><?php echo __('Featured Products &amp; Treatments') ?></h2>
				</div>
				<div class="col-sm-4 text-right">
					<a role="button" class="btn" href="<?php echo get_permalink(7) ?>" title="<?php _e('View all treatments', 'portchris')?>">
						<?php _e('View all treatments', 'portchris'); ?>
					</a>
				</div>
				<hr />
			</div>
			<div id="treatments" class="row row-with-vspace">
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
					<div class="treatment col-sm-4">
						<?php $page = $children[$i]; 
						$attr = array(
							'class'	=> "img-responsive",
							'alt'	=> trim( strip_tags( $page->post_excerpt ) ),
							'title'	=> trim( strip_tags( $page->post_title ) ),
						);
						$image_id = get_post_thumbnail_id($page->ID);
						$image_attributes = wp_get_attachment_image_src( $image_id, 'full');
						if (!empty($image_attributes) && isset($image_attributes[0])) : ?>
							<div class="img-container">
								<a href=" <?php echo get_page_link($page->ID) ?>" title=" <?php echo $page->post_title ?>">
									<img class="img-responsive" src="<?php echo $image_attributes[0]; ?>" width="100%" alt="<?php echo $page->post_title ?>"/>
								</a>
							</div>
						<?php endif; ?>
						<div class="treatment-desc">
							<h4 class="treatment-title"><?php echo $page->post_title ?></h4>
							<?php $in = $page->post_content; 
							$out = strlen($in) > 150 ? substr($in, 0, 150)."..." : $in;
							echo "<p>".$out."</p>";
							echo '<a role="button" class="btn" href="'.get_page_link($page->ID).'" title="'.$page->post_title.'">' . __('View treatment', 'portchris') . '</a>'; ?>
						</div>
					</div>
				<?php endfor; ?>
			</div><!-- #treatments -->
		</div><!-- .container -->
	</div><!-- #featured-treatments -->
	<div id="latest-news" class="row-with-vspace">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<h2><?php echo __('Achieve beauty the natural way', 'portchris'); ?></h2>
					<hr/>
					<div id="home-content">
						<?php while (have_posts()) {
							the_post();
							get_template_part('content', 'page');
						} ?>
					</div> 
				</div>
				<div class="col-md-6 twitter-news">
					<h2><?php echo __('Latest Tweets', 'portchris'); ?></h2>
					<hr/>
					<div id="twitter-news">
		            <a class="twitter-timeline" data-chrome="noborders transparent transparent noheader" data-tweet-limit="2" href="https://twitter.com/face_and_figure" data-aria-polite="assertive" data-widget-id="579732656545480704" data-chrome="noscrollbar nofooter noborders">Tweets by @face_and_figure</a>
						<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
					</div>
				</div>
			</div>
		</div><!-- .container -->
	</div><!-- #latest-news -->
	<div id="social-networks" class="row-with-vspace">
		<div class="container">
			<div class="row row-with-vspace">
				<div class="col-md-12">
					<h2><?php _e("Contact with Face in Figure Salon Taunton:", "portchris") ?></h2>
					<hr />
				</div>
			</div>
			<?php if (isset($social) && !empty($social)): ?>
				<div class="row">
					<?php $perRow = 3;
					$c = count($social);
					for ($i = 0; $i < $c; $i++) {
						$s = $social[$i];
						$t = (isset($s["social_name"]) && !empty($s["social_name"])) ? $s['social_name'] : '';
						$img = (isset($s["social_img"]) && !empty($s["social_img"])) ? $s['social_img'] : '';
						$desc = (isset($s["social_desc"]) && !empty($s["social_desc"])) ? $s['social_desc'] : '';
						$cta = (isset($s["social_link"]) && !empty($s["social_link"])) ? $s['social_link'] : '';
						$cta = (is_numeric($cta)) ? get_permalink($cta) : $cta;
						$txt = (isset($s["social_btn"]) && !empty($s["social_btn"])) ? $s['social_btn'] : __('Connect');
						$_blank = (isset($s["social_target"]) && !empty($s["social_target"])) ? 'target="_blank" ' : '';
						echo ($i !== 0 && $i % $perRow === 0) ? '</div><div class="row">' : '';
						echo '<div class="social-network col-md-4 row-with-vspace">';
						if (strlen($img) > 0) {
							if (strlen($cta) > 0) {
								echo '<a class="social-img" href="' . $cta . '" title="' . $t . '" ' . $_blank . '>';
							}
							echo '<img class="img-responsive social-img" src="' . wp_get_attachment_url($img) . '" alt="' . $t . '" />';
							if (strlen($cta) > 0) {
								echo '</a>';
							}
						}
						if (strlen($t) > 0) {
							echo '<h3>' . $t . '</h3>';
						}
						if (strlen($desc) > 0) {
							echo '<small>' . $desc . '</small>';
						}
						if (strlen($cta) > 0) {
							echo '<a role="button" class="btn btn-default" href="' . $cta . '" title="' . $t . '" ' . $_blank . '>' . $txt . '</a>';
						}
						echo '</div>';
					} ?>
				</div>
			<?php endif; ?>
		</div>
	</div><!-- #social-networks -->
</div><!-- #breakdown -->
<?php get_sidebar('right'); ?> 
<?php get_footer(); ?> 