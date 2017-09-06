<?php
	/**
	* Common Footer
	* Date : 28.08.2017 (dd.mm.yyyy)
	*/
	defined('BASEPATH') OR exit('No direct script access allowed');
?>
		<div id="snackbar"></div>
		<!-- Configuration -->
		<script type="text/javascript">
			var base_url = '<?=base_url()?>';
			var csfrData = {};
     		csfrData['<?php echo $this->security->get_csrf_token_name(); ?>']
                       = '<?php echo $this->security->get_csrf_hash(); ?>';
		</script>

		<?= script_tag([
				'assets/js/jquery.min.js',
				'assets/js/jquery-migrate.js',
				'assets/js/fixed_midashi.js',
				'assets/js/script.js'
			]);
		?>

		<script type='text/javascript'>//<![CDATA[
			$(window).load(function(){
				$(document).ready(function() {
					var eTop = 5;
					$('.scroll_div').scrollTop(eTop);
					$('.scroll_div').on("scroll", function(e) {
						var windowScrollTop = $(this).scrollTop();
						if(windowScrollTop < eTop) {
							$(this).scrollTop(eTop);
						}
						else {
						}
					});
				});
			});//]]> 
		</script>
	</body>
</html>