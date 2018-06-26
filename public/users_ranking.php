<?php
require_once '../lib/init.php';

if (!$_SESSION['prode_'.session_id()]['user_logged']) {
	header('Location: email.php');
} else {
	require_once 'partials/header.php';

	require_once 'partials/top_nav.php';
?>
	<div class="container-fluid">
		<?php
		require_once 'partials/left_nav.php';
		?>

		<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
			<div class="row">
				<div class="col-12 mt-4">
					<?php
					$iUsers = count(User::getInstance()->getWithPasswordNotNull());
					$aUsersRanking = Match_Prediction::getInstance()->getUsersRanking();
					$iUsersRanking = count($aUsersRanking);
					?>
					<?php
					if ((bool) $aUsersRanking) {
						$aPodium = array_slice($aUsersRanking, 0, 3, true);
						$aNoPodium = array_slice($aUsersRanking, 3, $iUsers, true);
					?>
					<div class="rankingPodium d-flex">
						<div class="mt-auto mb-0 h-100 w-35">
							<?php if ((bool) $aPodium[1]) { ?>
							<div class="card float-right rankingPodiumSecond">
								<div class="card-header border-0 d-flex text-center fa-3x">
									<span class="w-100 my-auto text-body">#2</span>
								</div>
								<a
									href="<?=($aPodium[1]['id_user']==$_SESSION['prode_'.session_id()]['id_user'])?'javascript:void(0);':'/public/user/statistics/'.$aPodium[1]['id_user'].'/';?>"
									title="<?=($aPodium[1]['id_user']==$_SESSION['prode_'.session_id()]['id_user'])?'':'View User Statistics';?>"
								>
									<div class="card-body p-3 text-center">
										<div class="font-weight-bold text-nowrap text-body"><?=$aPodium[1]['nick'];?></div>
										<div class="font-weight-bold text-nowrap text-secondary py-1">
											<?=$aPodium[1]['points'];?> point<?=($aPodium[1]['points']!=1)?'s':'';?>
										</div>
										<div class="text-success"><?=$aPodium[1]['hits'];?> hits</div>
										<div class="text-danger"><?=$aPodium[1]['failures'];?> failures</div>
									</div>
								</a>
							</div>
							<?php } ?>
						</div>
						<div class="mt-auto mb-0 h-100 w-30">
							<?php if ((bool) $aPodium[0]) { ?>
							<div class="card mx-auto rankingPodiumFirst">
								<div class="card-header border-0 d-flex text-center fa-4x">
									<span class="w-100 my-auto text-body">#1</span>
								</div>
								<a
									href="<?=($aPodium[0]['id_user']==$_SESSION['prode_'.session_id()]['id_user'])?'javascript:void(0);':'/public/user/statistics/'.$aPodium[0]['id_user'].'/';?>"
									title="<?=($aPodium[0]['id_user']==$_SESSION['prode_'.session_id()]['id_user'])?'':'View User Statistics';?>"
								>
									<div class="card-body p-3 text-center">
										<div class="font-weight-bold text-nowrap text-body"><?=$aPodium[0]['nick'];?></div>
										<div class="font-weight-bold text-nowrap text-secondary py-1">
											<?=$aPodium[0]['points'];?> point<?=($aPodium[0]['points']!=1)?'s':'';?>
										</div>
										<div class="text-success"><?=$aPodium[0]['hits'];?> hits</div>
										<div class="text-danger"><?=$aPodium[0]['failures'];?> failures</div>
									</div>
								</a>
							</div>
							<?php } ?>
						</div>
						<div class="mt-auto mb-0 h-100 w-35">
							<?php if ((bool) $aPodium[2]) { ?>
							<div class="card float-left rankingPodiumThird">
								<div class="card-header border-0 d-flex text-center fa-2x">
									<span class="w-100 my-auto text-body">#3</span>
								</div>
								<a
									href="<?=($aPodium[2]['id_user']==$_SESSION['prode_'.session_id()]['id_user'])?'javascript:void(0);':'/public/user/statistics/'.$aPodium[2]['id_user'].'/';?>"
									title="<?=($aPodium[2]['id_user']==$_SESSION['prode_'.session_id()]['id_user'])?'':'View User Statistics';?>"
								>
									<div class="card-body p-3 text-center">
										<div class="font-weight-bold text-nowrap text-body"><?=$aPodium[2]['nick'];?></div>
										<div class="font-weight-bold text-nowrap text-secondary py-1">
											<?=$aPodium[2]['points'];?> point<?=($aPodium[2]['points']!=1)?'s':'';?>
										</div>
										<div class="text-success"><?=$aPodium[2]['hits'];?> hits</div>
										<div class="text-danger"><?=$aPodium[2]['failures'];?> failures</div>
									</div>
								</a>
							</div>
							<?php } ?>
						</div>
					</div>

					<?php
					if ((bool) $aNoPodium) {
					?>
					<div class="mt-3 w-80 mx-auto">
						<div class="list-group noPodiumContent">
							<?php foreach ($aNoPodium as $iKey=>$aUser) { ?>
							<a
								href="<?=($aUser['id_user']==$_SESSION['prode_'.session_id()]['id_user'])?'javascript:void(0);':'/public/user/statistics/'.$aUser['id_user'].'/';?>"
								class="list-group-item list-group-item-action py-2"
								title="<?=($aUser['id_user']==$_SESSION['prode_'.session_id()]['id_user'])?'':'View User Statistics';?>"
							>
								<div class="row">
									<div class="col-2 text-center fa-2x text-body">#<?=$iKey+1;?></div>
									<div class="col-5 text-left fa-2x font-weight-bold"><?=$aUser['nick'];?></div>
									<div class="col-5">
										<div class="float-left w-50 my-auto">
											<span class="text-success clearfix"><?=$aUser['hits'];?> hits</span>
											<span class="text-danger"><?=$aUser['failures'];?> failures</span>
										</div>
										<div class="float-left w-50 my-auto fa-2x font-weight-bold text-secondary"><?=$aUser['points'];?> point<?=($aUser['points']!=1)?'s':'';?></div>
									</div>
								</div>
							</a>
							<?php } ?>
						</div>
					</div>
					<?php
					}
					?>
					<?php
					} else {
					?>
					<div class="alert alert-warning">There are no users yet</div>
					<?php
					}
					?>
				</div>
			</div>
		</main>
	</div>
<?php
	require_once 'partials/footer.php';
}
?>
