<div class="col-lg-12">
	<h1>Aktueller Punktestand</h1>
	<?php foreach ($aGames as $oGame) : ?>
		<div class="col-md-4">
			<table class="table table-bordered">
			<tr><th colspan="3"><?= $oGame->name ?></th></tr>
			<tr>
				<th>#</th>
				<th>Gruppe</th>
				<th>Pkt.</th>
			</tr>
			<?php foreach ($oGame->results as $oResult) : ?>
				<tr <?php if($oResult->points == "-") echo ' class="danger"'; ?>>
					<td class="center"><?= $oResult->placement ?></td>
					<td><?= $oResult->group->name ?></td>
					<td class="right"><?= $oResult->points ?></td>
				</tr>
			<?php endforeach; ?>
			</table>
		</div>
	<?php endforeach; ?>
	<div class="clearfix"></div>
	<h1>Gesamtpunkte</h1>
	<table class="table table-bordered">
	<tr class="success"><th colspan="3">Endergebnis</th></tr>
	<tr>
	<th>#</th>
	<th>Gruppe</th>
	<th>Pkt.</th>
	</tr>
	<?php $iPlacement = 0; ?>
	<?php foreach ($aFinalpoints as $oGroup) : ?>
	<?php $iPlacement++; ?>
	<tr>
	<td class="center"><?= $iPlacement ?></td>
	<td class="mouseover"><a rel="popover"><?= $oGroup->name ?></a>
	<div class="members" style="display:none;">
	<ul>
	<?php foreach ($oGroup->participants as $oMember): ?>
	<li><?= $oMember->name ?></li>
	<?php endforeach; ?>
	</ul>
	</div></td>
	<td class="right"><?= $oGroup->finalpoints ?></td>
	</tr>
	<?php endforeach; ?>
	</table>
</div>
