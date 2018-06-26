<?php
function my_redirect($url, $top=false) {
	if ($top) {
		echo "
		<script>
				window.top.location = '{$url}';
		</script>
		";
	} else {
		echo "
		<script>
				window.location = '{$url}';
		</script>
		";
	}

	die();
}
