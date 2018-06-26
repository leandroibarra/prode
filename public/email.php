<?php
require_once '../lib/init.php';

if ($_SESSION['prode_'.session_id()]['user_logged']) {
	header('Location: /public/dashboard/');
} else {
	if (isset($_POST['submit'])) {
		try {
			$aData = User::getInstance()->authenticate($_POST, 1);

			$_SESSION['prode_'.session_id()]['id_user'] = $aData['aUser']['id'];

			$_SESSION['prode_'.session_id()]['complete_data'] = (is_null($aData['aUser']['password'])) ? true : false;

			header('Location: /public/login/password/');
		} catch (User_Exception $oException) {
			$aErrors = $oException->getErrors();
		}
	}

	require_once 'partials/header.php';
?>
	<div class="row">
		<div class="col-2"></div>
		<div class="col-8">
			<h1 class="text-center mt-4">Login (1/2)</h1>

			<?php if ((bool) $aErrors) { ?>
			<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<?php
				foreach ($aErrors as $sError) {
					echo "{$sError}<br />";
				}
				?>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<?php } ?>

			<form action="" method="POST">
				<div class="form-group">
					<label for="email">Enter your email</label>
					<input type="email" class="form-control" name="email" id="email" required value="<?=$_POST['email'];?>" />
				</div>
				<button type="submit" name="submit" id="submit" class="btn btn-primary btn-block">Next</button>
			</form>
		</div>
		<div class="col-2"></div>
	</div>
<?php
	require_once 'partials/footer.php';
}
?>