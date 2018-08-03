<div class="col-lg-12">
	<h1>Siegerehrung</h1>
	<div class="pull-right" id="next_place"><span class="glyphicon glyphicon-stats"></span> Nächster Platz</div>
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
			<tr class="hidden">
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
