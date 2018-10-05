<?php
require_once '../lib/init.php';

if (!$_SESSION['prode_'.session_id()]['user_logged']) {
	header('Location: /public/login/email/');
} else {
	require_once 'partials/header.php';

	require_once 'partials/top_nav.php';

	$oMatchPrediction = Match_Prediction::getInstance();
	$oMatchSchedule = Match_Schedule::getInstance();
	$oModel = Model::getInstance();
?>
	<div class="container-fluid">
		<?php
		require_once 'partials/left_nav.php';
		?>

		<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
			<div class="card-deck my-4 text-center">
				<div class="card mb-4 box-shadow">
					<div class="card-header">
						<h4 class="my-0">Your Statistics</h4>
					</div>
					<div class="card-body">
						<?php
						$aStatistics = $oMatchPrediction->getStatisticsByUser($_SESSION['prode_'.session_id()]['id_user']);
						?>
						<div class="row mx-auto w-100">
							<div class="col-12">
								<span class="text-muted fa-2x">
									<span class="font-weight-bold"><?=$aStatistics['points'];?></span>
									<small>point<?=($aStatistics['points']>1)?'s':'';?></small>
								</span>
							</div>
						</div>
						<div class="row w-100">
							<div class="col-6 px-0">
								<div id="statisticsHits"></div>
							</div>
							<div class="col-6 px-0">
								<div id="statisticsFailures"></div>
							</div>
						</div>
						<div class="row mx-auto w-100">
							<div class="col-12">
								<h5 class="text-muted mb-0">In <?=$aStatistics['hits']+$aStatistics['failures'];?> predictions of <?=$aStatistics['predictions'];?> in total</h5>
							</div>
						</div>
					</div>
				</div>
				<div class="card mb-4 box-shadow">
					<?php
					$iUsers = count(User::getInstance()->getWithPasswordNotNull());
					$aUsersRanking = $oMatchPrediction->getUsersRanking(3);
					$iUsersRanking = count($aUsersRanking);
					?>
					<div class="card-header">
						<h4 class="my-0">Top Users</h4>
					</div>
					<?php
					if ((bool) $aUsersRanking) {
					?>
					<ul class="list-group list-group-flush">
						<?php
						foreach ($aUsersRanking as $iKey=>$aUser) {
						?>
						<li class="list-group-item p-0 rankingItem" style="height:<?=($iUsers==$iUsersRanking)?'110':'95';?>px;">
							<div class="float-left h-100 w-20 d-flex rankingItemPosition">
								<span class="w-100 my-auto fa-4x">#<?=$iKey+1;?></span>
							</div>
							<div class="float-left h-100 w-60 rankingItemUser">
								<div class="h-100 d-flex pl-2 text-left">
									<div class="float-left w-75 my-auto fa-2x"><?=$aUser['nick'];?></div>
									<div class="float-left w-25 my-auto">
										<span class="text-success clearfix"><?=$aUser['hits'];?> hits</span>
										<span class="text-danger"><?=$aUser['failures'];?> failures</span>
									</div>
								</div>
							</div>
							<div class="float-left h-100 w-20 d-flex rankingItemUser">
								<span class="w-100 my-auto fa-4x font-weight-bold text-secondary"><?=$aUser['points'];?></span>
							</div>
						</li>
					<?php
						}

						if ($iUsers > $iUsersRanking) {
					?>
						<a href="/public/users_ranking/" class="list-group-item list-group-item-action list-group-item-secondary text-uppercase">
							Complete ranking <i class="fa fa-chevron-right"></i>
						</a>
					<?php
						}
					?>
					</ul>
					<?php
					} else {
					?>
					<div class="card-body">
						<div class="alert alert-warning">There are no users yet</div>
					</div>
					<?php
					}
					?>
				</div>
			</div>

			<div class="card-deck my-4 text-center">
				<?php
				$iMatches = count($oMatchSchedule->getByFilters());

				$aNextMatches = $oMatchSchedule->getNextMatches();
				$iNextMatches = count($aNextMatches);

				$aLastMatches = $oMatchSchedule->getLastMatches();
				$iLastMatches = count($aLastMatches);
				?>
				<div class="card mb-4 box-shadow">
					<div class="card-header">
						<h4 class="my-0 d-flex justify-content-between align-items-center">
							<span>Next Matches</span>
							<span class="badge badge-secondary"><?=$iNextMatches;?> of <?=$iMatches;?></span>
						</h4>
					</div>
					<?php
					if ((bool) $aNextMatches) {
						$sCurrentDate = '';
					?>
					<div class="list-group list-group-flush nextMatchesContent">
						<?php
						foreach ($aNextMatches as $iKey=>$aNextMatch) {
							$iNextMatchPoints = $oModel->aPointsByInstance[$aNextMatch['id_instance']];

							$aMatchPrediction = $oMatchPrediction->getByFilters(array(
								'id_match_schedule' => $aNextMatch['id'],
								'id_user' => $_SESSION['prode_'.session_id()]['id_user']
							));

							if ($sCurrentDate != date('d F', strtotime($aNextMatch['datetime']))) {
								$sCurrentDate = date('d F', strtotime($aNextMatch['datetime']));
						?>
						<div class="list-group-item list-group-item-secondary font-weight-bold"><?=date('l jS \of F', strtotime($aNextMatch['datetime']));?></div>
						<?php
							}
						?>
						<a href="/public/prediction/edit/<?=$aNextMatch['id'];?>/" class="list-group-item list-group-item-action py-2" title="Edit Prediction">
							<div class="row">
								<div class="col-3 text-right my-auto"><?=$aNextMatch['name_home_team'];?></div>
								<div class="col-2 text-center">
									<img src="<?=IMAGES_URL."/teams/".((!is_null($aNextMatch['code_home_team']))?$aNextMatch['code_home_team']:'unknown').".png";?>" class="w-100 border-0" />
								</div>
								<div class="col-2 text-center my-auto">vs</div>
								<div class="col-2 text-center">
									<img src="<?=IMAGES_URL."/teams/".((!is_null($aNextMatch['code_away_team']))?$aNextMatch['code_away_team']:'unknown').".png";?>" class="w-100 border-0" />
								</div>
								<div class="col-3 text-left my-auto"><?=$aNextMatch['name_away_team'];?></div>
							</div>
							<div class="row text-nowrap">
								<div class="col-4 text-right text-muted">
									<span>Prediction: </span>
									<span class="font-weight-bold"><?=((bool) $aMatchPrediction)?ucfirst($aMatchPrediction[0]['result']):'Any';?></span>
								</div>
								<div class="col-2 text-left text-center text-points font-weight-bold">
									<?=$iNextMatchPoints;?> point<?=($iNextMatchPoints>1)?'s':'';?>
								</div>
								<div class="col-4 text-right text-muted">
									<span><?=($aNextMatch['id_instance']==1) ? "Group {$aNextMatch['name_group']} - Match {$aNextMatch['matchday']}" : $aNextMatch['name_instance'];?></span>
								</div>
								<div class="col-1 text-left text-muted">
									<?=date('H:i', strtotime($aNextMatch['datetime']));?>
									<i class="fa fa-clock-o text-black"></i>
								</div>
							</div>
						</a>
						<?php
						}
						?>
					</div>
					<?php
					} else {
					?>
					<div class="card-body">
						<div class="alert alert-warning">There are no more matches</div>
					</div>
					<?php
					}
					?>
				</div>
				<div class="card mb-4 box-shadow">
					<div class="card-header">
						<h4 class="my-0 d-flex justify-content-between align-items-center">
							<span>Last Matches</span>
							<span class="badge badge-secondary"><?=$iLastMatches;?> of <?=$iMatches;?></span>
						</h4>
					</div>
					<?php
					if ((bool) $aLastMatches) {
						$sCurrentDate = '';
					?>
					<div class="list-group list-group-flush lastMatchesContent">
						<?php
						foreach ($aLastMatches as $iKey=>$aLastMatch) {
							$iLastMatchPoints = $oModel->aPointsByInstance[$aLastMatch['id_instance']];

							$aMatchPrediction = $oMatchPrediction->getByFilters(array(
								'id_match_schedule' => $aLastMatch['id'],
								'id_user' => $_SESSION['prode_'.session_id()]['id_user']
							));

							if ($sCurrentDate != date('d F', strtotime($aLastMatch['datetime']))) {
								$sCurrentDate = date('d F', strtotime($aLastMatch['datetime']));
						?>
						<div class="list-group-item list-group-item-secondary font-weight-bold"><?=date('l jS \of F', strtotime($aLastMatch['datetime']));?></div>
						<?php
							}
						?>
						<a href="/public/predictions/view/<?=$aLastMatch['id'];?>/" class="list-group-item list-group-item-action py-2" title="View Predictions">
							<div class="row">
								<div class="col-3 text-right my-auto"><?=$aLastMatch['name_home_team'];?></div>
								<div class="col-2 text-center">
									<img src="<?=IMAGES_URL."/teams/".((!is_null($aLastMatch['code_home_team']))?$aLastMatch['code_home_team']:'unknown').".png";?>" class="w-100 border-0" />
								</div>
								<div class="col-2 text-center my-auto">vs</div>
								<div class="col-2 text-center">
									<img src="<?=IMAGES_URL."/teams/".((!is_null($aLastMatch['code_away_team']))?$aLastMatch['code_away_team']:'unknown').".png";?>" class="w-100 border-0" />
								</div>
								<div class="col-3 text-left my-auto"><?=$aLastMatch['name_away_team'];?></div>
							</div>
							<div class="row text-nowrap">
								<div class="col-4 text-right text-muted">
									<span>Result: </span>
									<span class="font-weight-bold"><?=(!is_null($aLastMatch['result']))?ucfirst($aLastMatch['result']):'Any';?></span>
								</div>
								<div class="col-4 text-left text-center text-points font-weight-bold">
									<?=$iLastMatchPoints;?> point<?=($iLastMatchPoints>1)?'s':'';?>
								</div>
								<div class="col-4 text-left text-muted">
									<span>Prediction: </span>
									<?php
									$sText = 'Any';
									$sClass = 'muted';

									if ((bool) $aMatchPrediction) {
										if ($aLastMatch['result'] == $aMatchPrediction[0]['result']) {
											$sText = 'Correct';
											$sClass = 'success';
										} else if ($aLastMatch['result'] != $aMatchPrediction[0]['result']) {
											$sText = 'Wrong';
											$sClass = 'danger';
										}
									}
									?>
									<span class="font-weight-bold text-<?=$sClass;?>"><?=$sText;?></span>
								</div>
							</div>
						</a>
						<?php
						}
						?>
					</div>
					<?php
					} else {
					?>
					<div class="card-body">
						<div class="alert alert-warning">No matches played yet</div>
					</div>
					<?php
					}
					?>
				</div>
			</div>
		</main>
	</div>

	<div class="modal fade" id="modal-default" style="display:none;">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Fix game read ID <strong></strong></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
				</div>
				<div class="modal-footer">
					<button type="button" id="edit" class="btn btn-primary">Edit</button>
					<button type="button" id="cancel" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				</div>
			</div>
		</div>
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

		// Set common settings to notify
		var oNotifySettings = {
			allow_dismiss: true,
			placement: {
				from: 'top',
				align: 'center'
			},
			mouse_over: 'pause',
			type: 'success',
			spacing: 10,
			offset: 20,
			animate:{
				enter: 'animated fadeInDown',
				exit: 'animated fadeOutUp'
			}
		};

		// Show message if correspond
		<?php if ((bool) $_SESSION['prode_'.session_id()]['message']) { ?>
		oNotifySettings.type = '<?=$_SESSION['prode_'.session_id()]['message']['type'];?>';

		jQuery.notify({
			message: '<?=$_SESSION['prode_'.session_id()]['message']['message'];?>'
		}, oNotifySettings);

		<?php unset($_SESSION['prode_'.session_id()]['message']); ?>
		<?php } ?>
	});
	</script>
<?php
	require_once 'partials/footer.php';
}
?>
