<?php
require_once '../lib/init.php';

if (!$_SESSION['prode_'.session_id()]['user_logged']) {
	header('Location: /public/login/email/');
} else {
	require_once 'partials/header.php';

	require_once 'partials/top_nav.php';

	$oMatchPrediction = Match_Prediction::getInstance();
	$aMatchSchedule = Match_Schedule::getInstance()->getMatchById($_GET['idm'], 'gt');

	if ((bool) $aMatchSchedule) {
		$aMatchPrediction = $oMatchPrediction->getByFilters(array(
			'id_match_schedule' => $aMatchSchedule[0]['id'],
			'id_user' => $_SESSION['prode_'.session_id()]['id_user']
		));

		if (isset($_POST['submit'])) {
			try {
				$_POST = array_merge(
					$_POST,
					array(
						'id_match_schedule' => $aMatchSchedule[0]['id'],
						'id_user' => $_SESSION['prode_'.session_id()]['id_user']
					)
				);

				$oMatchPrediction->update($_POST);

				$_SESSION['prode_'.session_id()]['message'] = array(
					'type' => 'success',
					'message' => 'Prediction has been saved successfully'
				);

				header('Location: /public/dashboard/');
			} catch (Match_Prediction_Exception $oException) {
				$aErrors = $oException->getErrors();
			}
		}
?>
	<div class="container-fluid">
		<?php
		require_once 'partials/left_nav.php';
		?>

		<main role="main" class="col-9 ml-sm-auto col-lg-10 px-4">
			<div class="mt-4 editPredictionContent">
				<h4 class="text-center">
					Edit prediction of <span class="font-weight-bold"><?="{$aMatchSchedule[0]['name_home_team']} vs {$aMatchSchedule[0]['name_away_team']}";?></span>
					</h4>

				<form action="" method="POST" class="w-75 mx-auto">
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

					<div class="form-group mb-0 d-flex">
						<div class="w-40 text-right my-auto">
							<input type="radio" name="result" value="home" <?=($aMatchPrediction[0]['result']=='home')?'checked':'';?> />
						</div>
						<div class="w-20 text-center">
							<img src="<?=IMAGES_URL."/teams/".((!is_null($aMatchSchedule[0]['code_home_team']))?$aMatchSchedule[0]['code_home_team']:'unknown').".png";?>" class="w-50 border-0" />
						</div>
						<div class="w-40 text-left my-auto"><?=$aMatchSchedule[0]['name_home_team'];?></div>
					</div>
					<?php if ($aMatchSchedule[0]['id_instance'] == 1) { ?>
					<div class="form-group row mb-0">
						<div class="w-40 text-right my-auto">
							<input type="radio" name="result" value="draw" <?=($aMatchPrediction[0]['result']=='draw')?'checked':'';?> />
						</div>
						<div class="w-20 text-center">
							<img src="<?=IMAGES_URL;?>/general/draw.png" class="w-50 border-0" />
						</div>
						<div class="w-40 text-left my-auto">Draw</div>
					</div>
					<?php } ?>
					<div class="form-group row ">
						<div class="w-40 text-right my-auto">
							<input type="radio" name="result" value="away" <?=($aMatchPrediction[0]['result']=='away')?'checked':'';?> />
						</div>
						<div class="w-20 text-center">
							<img src="<?=IMAGES_URL."/teams/".((!is_null($aMatchSchedule[0]['code_away_team']))?$aMatchSchedule[0]['code_away_team']:'unknown').".png";?>" class="w-50 border-0" />
						</div>
						<div class="w-40 text-left my-auto"><?=$aMatchSchedule[0]['name_away_team'];?></div>
					</div>
					<div class="form-row">
						<div class="col-6">
							<button type="button" name="cancel" id="cancel" class="btn btn-secondary btn-block" onclick="window.location='/public/dashboard/'">Cancel</button>
						</div>
						<div class="col-6">
							<button type="submit" name="submit" id="submit" class="btn btn-primary btn-block">Save</button>
						</div>
					</div>
				</form>
			</div>
		</main>
	</div>
<?php
		require_once 'partials/footer.php';
	} else {
		$_SESSION['prode_'.session_id()]['message'] = array(
			'type' => 'danger',
			'message' => 'Match is not valid or datetime has expired'
		);

		header('Location: /public/dashboard/');
	}
}
?>
