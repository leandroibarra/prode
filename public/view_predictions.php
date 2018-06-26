<?php
require_once '../lib/init.php';

if (!$_SESSION['prode_'.session_id()]['user_logged']) {
	header('Location: email.php');
} else {
	require_once 'partials/header.php';

	require_once 'partials/top_nav.php';

	$oMatchPrediction = Match_Prediction::getInstance();
	$aMatchSchedule = Match_Schedule::getInstance()->getMatchById($_GET['idm'], 'lt');

	if ((bool) $aMatchSchedule) {
		$aPredictions = array();

		foreach (User::getInstance()->getWithPasswordNotNull() as $aUser) {
			$aMatchPrediction = $oMatchPrediction->getByFilters(array(
				'id_match_schedule' => $aMatchSchedule[0]['id'],
				'id_user' => $aUser['id']
			));

			$aPredictions[] = array(
				'id_user' => $aUser['id'],
				'nick' => $aUser['nick'],
				'prediction_result' => ((bool) $aMatchPrediction) ? ucfirst($aMatchPrediction[0]['result']) : 'Any',
				'class' => ((bool) $aMatchPrediction) ? (
					($aMatchPrediction[0]['result']==$aMatchSchedule[0]['result'])
						? 'success'
						: 'danger'
				) : 'muted'
			);
		}
?>
	<div class="container-fluid">
		<?php
		require_once 'partials/left_nav.php';
		?>

		<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
			<div class="row">
				<div class="col-12">
					<?php  if ((bool) $aPredictions) { ?>
					<div class="mt-3 w-80 mx-auto">
						<h4 class="text-center">
							Predictions of <span class="font-weight-bold"><?="{$aMatchSchedule[0]['name_home_team']} vs {$aMatchSchedule[0]['name_away_team']}";?></span>
						</h4>

						<ul class="list-group mt-3 viewPredictionsContent">
							<?php foreach ($aPredictions as $iKey=>$aPrediction) { ?>
							<li class="list-group-item py-2">
								<div class="row">
									<div class="col-5 text-left fa-2x font-weight-bold my-auto"><?=$aPrediction['nick'];?></div>
									<div class="col-4">
										<div class="float-left w-50 my-auto">
											<small class="clearfix">Prediction:</small>
											<span class="fa-2x font-weight-bold text-<?=$aPrediction['class'];?>"><?=$aPrediction['prediction_result'];?></span>
										</div>
									</div>
									<div class="col-3">
										<div class="float-left w-50 my-auto">
											<small class="clearfix">Result:</small>
											<span class="fa-2x font-weight-bold"><?=ucfirst($aMatchSchedule[0]['result']);?></span>
										</div>
									</div>
								</div>
							</li>
							<?php } ?>
						</ul>
					</div>
					<?php } else { ?>
					<div class="alert alert-warning">There were no predictions</div>
					<?php } ?>
				</div>
			</div>
		</main>
	</div>
<?php
		require_once 'partials/footer.php';
	} else {
		$_SESSION['prode_'.session_id()]['message'] = array(
			'type' => 'danger',
			'message' => 'Match is not valid or datetime has no reached'
		);

		header('Location: dashboard.php');
	}
}
?>