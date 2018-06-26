<div class="row">
	<nav class="col-md-2 d-none d-md-block bg-light sidebar">
		<div class="sidebar-sticky">
			<ul class="nav flex-column">
				<?php foreach ($aPublicPages as $sFile=>$sTitle) { ?>
				<li class="nav-item">
					<a class="nav-link <?=($sCurrentFileName==$sFile)?'active':'';?>" href="<?=($sCurrentFileName==$sFile)?'javascript:void(0);':'/public/'.current(explode('.', $sFile)).'/';?>">
						<?=$sTitle;?>
					</a>
				</li>
				<?php } ?>
			</ul>
		</div>
	</nav>
</div>