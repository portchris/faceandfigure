<?php 
$sidebar_class = 'row-with-vspace below';
$container_class = "container";
if (is_single() || is_category() || is_search()) {
	$sidebar_class = 'col-md-3 aside';
	$container_class = "sidebar-container";
} else if (!is_front_page() && is_home()) {
	$sidebar_class = 'col-md-3 aside';
	$container_class = "sidebar-container";
}
if (is_active_sidebar('sidebar-right')): ?> 
	<div id="sidebar-right" class="<?php echo $sidebar_class ?>">
		<div class="<?php echo $container_class ?>">
			<?php if (strpos($sidebar_class, 'aside') === false && !is_404()): ?>
				<h2><?php _e('More From Face & Figure Beauty Salon') ?></h2>
				<hr />
			<?php endif; ?>
			<?php do_action('before_sidebar'); ?>
			<?php dynamic_sidebar('sidebar-right'); ?>
		</div>
	</div>
<?php endif; ?> 