<?php
/**
 * The theme footer
 * 
 * @package bootstrap-basic
 */
?>
			<?php if (is_active_sidebar('footer-center') && dynamic_sidebar('footer-center')): ?>
				<div id="get_in_touch">
					<div class="container">
						<div class="row row-with-vspace">
							<div class="col-md-12 text-center">
								<?php dynamic_sidebar('footer-center'); ?>
							</div>
						</div>
					</div>
				</div>
			<?php endif; ?>
			</div><!--.site-content-->
			<footer id="site-footer" role="contentinfo">
				<div class="container">
					<div id="footer-row" class="row site-footer">
						<div class="col-md-6 footer-left">
							<?php 
							if (!dynamic_sidebar('footer-left')) {
								printf(__('Powered by %s', 'bootstrap-basic'), 'WordPress and Bootstrap Basic');
								echo ' | ';
								printf(__('Web development by: %s', 'chris-rogers'), '<a href="http://www.portchris.co.uk">Chris Rogers</a>');
							} else {
								dynamic_sidebar('footer-left'); 
							} ?> 
						</div>
						<div class="col-md-6 footer-right text-right">
							<?php if (!dynamic_sidebar('footer-right')) {
								echo " Copyright Face &amp; Figure Salon &copy; 2015";
							} else {
								dynamic_sidebar('footer-right'); 
							} ?> 
						</div>
					</div>
				</div>
			</footer>
		</div><!--.container page-container-->
		<!--wordpress footer-->
		<?php wp_footer(); ?> 
	</body>
</html>