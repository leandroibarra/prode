<?php
require_once '../lib/init.php';

if ($_SESSION['prode_'.session_id()]['user_logged']) {
	header('Location: /public/dashboard/');
} else if (!$_SESSION['prode_'.session_id()]['id_user']) {
	header('Location: /public/login/email/');
} else {
	if (isset($_POST['submit'])) {
		try {
			$_POST['id_user'] = $_SESSION['prode_'.session_id()]['id_user'];

			if ($_SESSION['prode_'.session_id()]['complete_data']) {
				$aData = User::getInstance()->update($_POST);

				$_SESSION['prode_'.session_id()]['message'] = array(
					'type' => 'success',
					'message' => 'Data has been saved successfully'
				);
			} else {
				$aData = User::getInstance()->authenticate($_POST, 2);
			}

			$_SESSION['prode_'.session_id()]['user_logged'] = true;

			header('Location: /public/dashboard/');
		} catch (User_Exception $oException) {
			$aErrors = $oException->getErrors();
		}
	}

	require_once 'partials/header.php';
?>
	<div class="row">
		<div class="col-2"></div>
		<div class="col-8">
			<h1 class="text-center mt-4">Login (2/2)</h1>

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

			<?php if ($_SESSION['prode_'.session_id()]['complete_data']) { ?>
			<h4 class="mb-3">Complete your data</h4>
			<?php } ?>

			<form action="" method="POST">
				<?php if ($_SESSION['prode_'.session_id()]['complete_data']) { ?>
				<div class="form-group">
					<label for="email">Enter your nick</label>
					<input type="text" class="form-control" name="nick" id="nick" required value="<?=$_POST['nick'];?>" />
				</div>
				<div class="form-group">
					<label for="password">Enter your password</label>
					<input type="password" class="form-control" name="password" id="password" minlength="6" required value="<?=$_POST['password'];?>" />
				</div>
				<div class="form-group">
					<label for="confirm_password">Confirm your password</label>
					<input type="password" class="form-control" name="confirm_password" id="confirm_password" minlength="6" required value="<?=$_POST['confirm_password'];?>" />
				</div>
				<button type="submit" name="submit" id="submit" class="btn btn-primary btn-block">Save and Enter</button>
				<?php } else { ?>
				<div class="form-group">
					<label for="password">Enter your password</label>
					<input type="password" class="form-control" name="password" id="password" minlength="6" required value="<?=$_POST['pass'];?>" />
				</div>
				<button type="submit" name="submit" id="submit" class="btn btn-primary btn-block">Enter</button>
				<?php } ?>
			</form>
		</div>
		<div class="col-2"></div>
	</div>
<?php
	require_once 'partials/footer.php';
}
?>