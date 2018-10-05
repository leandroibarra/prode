<?php
require_once '../lib/init.php';

if (!$_SESSION['prode_'.session_id()]['user_logged']) {
	header('Location: /public/login/email/');
} else {
	require_once 'partials/header.php';

	require_once 'partials/top_nav.php';
?>
	<div class="container-fluid">
		<?php
		require_once 'partials/left_nav.php';
		?>

		<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
			<ul class="mt-4 rulesList">
				<li>You can select or change the result until before the start time of the match.</li>
				<li>The result options are: home, draw, or away.</li>
				<li>
					The points for successful result are the following:
					<ul>
						<li>1 in group phase.</li>
						<li>4 in round of 16.</li>
						<li>6 in quarter-finals.</li>
						<li>8 in semi-finals.</li>
						<li>10 in play-off for third place and final.</li>
					</ul>
				</li>
			</ul>
		</main>
	</div>
<?php
	require_once 'partials/footer.php';
}
?>
