<?php
	/**
	* Common Footer
	* Date : 28.08.2017 (dd.mm.yyyy)
	*/
	defined('BASEPATH') OR exit('No direct script access allowed');
?>
		</div>
		<a href="#" class="btn btn-xs btn-danger go-top" style="padding: 5px;">ページの先頭へ</a>
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
				'assets/js/fixed_midashi.js',
				'assets/js/script.js'
			]);
		?>
	</body>
</html>