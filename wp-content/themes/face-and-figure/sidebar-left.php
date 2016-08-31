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
if (is_active_sidebar('sidebar-left')): ?> 
	<div id="sidebar-left" class="<?php echo $sidebar_class ?>">
		<div class="<?php echo $container_class ?>">
			<?php do_action('before_sidebar'); ?> 
			<?php dynamic_sidebar('sidebar-left'); ?> 
		</div>
	</div>
<?php endif; ?> 