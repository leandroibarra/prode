<?php
require_once '../lib/init.php';

if (!$_SESSION['prode_'.session_id()]['user_logged']) {
	header('Location: /public/login/email/');
} else {
	require_once 'partials/header.php';

	require_once 'partials/top_nav.php';

	$oModel = Model::getInstance();
	$oMatchPrediction = Match_Prediction::getInstance();
	$aUser = User::getInstance()->getByFilters(array('id'=>$_GET['idu']));

	if (
		(bool) $aUser &&
		!is_null($aUser[0]['password']) &&
		$aUser[0]['id']!=$_SESSION['prode_'.session_id()]['id_user']
	) {
		$aPredictions = $oMatchPrediction->getHitsAndFailuresByUser($aUser[0]['id']);
?>
	<div class="container-fluid">
		<?php
		require_once 'partials/left_nav.php';
		?>

		<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
			<div class="card-deck mt-4 text-center">
				<div class="card box-shadow">
					<div class="card-header">
						<h4 class="my-0">Statistics of <span class="font-weight-bold"><?=$aUser[0]['nick'];?></span></h4>
					</div>
					<div class="card-body">
						<?php
						$aStatistics = $oMatchPrediction->getStatisticsByUser($aUser[0]['id']);
						?>
						<div class="row w-100">
							<div class="col-2">
								<div class="d-flex h-100">
									<div class="my-auto mx-auto fa-3x">
										<span class="text-muted mb-0">
											<span class="clearfix fa-2x font-weight-bold"><?=$aStatistics['points'];?></span>
											<small>point<?=($aStatistics['points']>1)?'s':'';?></small>
										</span>
									</div>
								</div>
							</div>
							<div class="col-10">
								<div class="row">
									<div class="col-6 px-0">
										<div id="statisticsHits"></div>
									</div>
									<div class="col-6 px-0">
										<div id="statisticsFailures"></div>
									</div>
								</div>
								<div class="row mx-auto w-100">
									<div class="col-12">
										<div class="text-muted fa-2x">In <?=$aStatistics['hits']+$aStatistics['failures'];?> predictions of <?=$aStatistics['predictions'];?> in total</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="card-deck my-4 text-center">
				<div class="card mb-4 box-shadow">
					<div class="card-header text-white bg-success">
						<h4 class="my-0 d-flex justify-content-between align-items-center">
							<span>Hits</span>
							<span class="badge bg-white text-success"><?=$aStatistics['hits'];?> of <?=$aStatistics['predictions'];?></span>
						</h4>
					</div>
					<?php
					if ((bool) $aPredictions['hits']) {
					?>
					<div class="list-group list-group-flush hitsContent">
						<?php
						foreach ($aPredictions['hits'] as $aHit) {
							$iHitPoints = $oModel->aPointsByInstance[$aHit['id_instance']];
						?>
						<div class="list-group-item list-group-item-action py-2">
							<div class="row">
								<div class="col-3 text-right my-auto"><?=$aHit['name_home_team'];?></div>
								<div class="col-2 text-center">
									<img src="<?=IMAGES_URL."/teams/".((!is_null($aHit['code_home_team']))?$aHit['code_home_team']:'unknown').".png";?>" class="w-100 border-0" />
								</div>
								<div class="col-2 text-center my-auto">vs</div>
								<div class="col-2 text-center">
									<img src="<?=IMAGES_URL."/teams/".((!is_null($aHit['code_away_team']))?$aHit['code_away_team']:'unknown').".png";?>" class="w-100 border-0" />
								</div>
								<div class="col-3 text-left my-auto"><?=$aHit['name_away_team'];?></div>
							</div>
							<div class="row text-nowrap">
								<div class="col-4 text-right">
									<span class="text-muted">Prediction: </span>
									<span class="text-success font-weight-bold"><?=ucfirst($aHit['prediction_result']);?></span>
								</div>
								<div class="col-4 text-left text-center text-points font-weight-bold">
									<?=$iHitPoints;?> point<?=($iHitPoints>1)?'s':'';?>
								</div>
								<div class="col-4 text-right text-muted">
									<span>Result: </span>
									<span class="font-weight-bold"><?=ucfirst($aHit['result']);?></span>
								</div>
							</div>
						</div>
						<?php } ?>
					</div>
					<?php
					} else {
					?>
					<div class="card-body">
						<div class="alert alert-warning">There are no hits</div>
					</div>
					<?php
					}
					?>
				</div>
				<div class="card mb-4 box-shadow">
					<div class="card-header text-white bg-danger">
						<h4 class="my-0 d-flex justify-content-between align-items-center">
							<span>Failures</span>
							<span class="badge bg-white text-danger"><?=$aStatistics['failures'];?> of <?=$aStatistics['predictions'];?></span>
						</h4>
					</div>
					<?php
					if ((bool) $aPredictions['failures']) {
					?>
					<div class="list-group list-group-flush failuresContent">
						<?php
						foreach ($aPredictions['failures'] as $aFailure) {
						?>
						<div class="list-group-item list-group-item-action py-2">
							<div class="row">
								<div class="col-3 text-right my-auto"><?=$aFailure['name_home_team'];?></div>
								<div class="col-2 text-center">
									<img src="<?=IMAGES_URL."/teams/".((!is_null($aFailure['code_home_team']))?$aFailure['code_home_team']:'unknown').".png";?>" class="w-100 border-0" />
								</div>
								<div class="col-2 text-center my-auto">vs</div>
								<div class="col-2 text-center">
									<img src="<?=IMAGES_URL."/teams/".((!is_null($aFailure['code_away_team']))?$aFailure['code_away_team']:'unknown').".png";?>" class="w-100 border-0" />
								</div>
								<div class="col-3 text-left my-auto"><?=$aFailure['name_away_team'];?></div>
							</div>
							<div class="row text-nowrap">
								<div class="col-4 text-right">
									<span class="text-muted">Prediction: </span>
									<span class="text-danger font-weight-bold"><?=ucfirst($aFailure['prediction_result']);?></span>
								</div>
								<div class="col-4"></div>
								<div class="col-4 text-right text-muted">
									<span>Result: </span>
									<span class="font-weight-bold"><?=ucfirst($aFailure['result']);?></span>
								</div>
							</div>
						</div>
						<?php } ?>
					</div>
					<?php
					} else {
					?>
					<div class="card-body">
						<div class="alert alert-warning">There are no failures</div>
					</div>
					<?php
					}
					?>
				</div>
			</div>
		</main>
	</div>

	<script type="text/javascript">
	jQuery(document).ready(function() {
		// Execute circlifuls
		jQuery('#statisticsHits').circliful({
			animation: 1,
			animationStep: <?=round($aStatistics['accuracy'] / 10);?>,
			foregroundColor: '#28A745',
			foregroundBorderWidth: 15,
			backgroundColor: '#E7E7E7',
			backgroundBorderWidth: 15,
			percent: <?=$aStatistics['accuracy'];?>,
			fontColor: '#28A745',
			iconPosition: 'middle',
			text: '<?="{$aStatistics['hits']} hits";?>',
			textBelow: false,
			textColor: '#28A745'
		});

		jQuery('#statisticsFailures').circliful({
			animation: 1,
			animationStep: <?=round((100 - $aStatistics['accuracy']) / 10);?>,
			foregroundColor: '#DC3545',
			foregroundBorderWidth: 15,
			backgroundColor: '#E7E7E7',
			backgroundBorderWidth: 15,
			percent: <?=($aStatistics['accuracy']>0) ? 100-$aStatistics['accuracy'] : $aStatistics['accuracy'];?>,
			fontColor: '#DC3545',
			iconPosition: 'middle',
			text: '<?="{$aStatistics['failures']} failures";?>',
			textBelow: false,
			textColor: '#DC3545'
		});

		// Align circliful text vertically
		jQuery('[id^=statistics]').find('text:eq(0)').attr('y', 105);
	});
	</script>
<?php
		require_once 'partials/footer.php';
	} else {
		$_SESSION['prode_'.session_id()]['message'] = array(
			'type' => 'danger',
			'message' => 'User is not valid'
		);

		header('Location: /public/dashboard/');
	}
}
?>