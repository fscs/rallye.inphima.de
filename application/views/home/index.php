<div class="col-lg-6">
	<h3>Spiele</h3>
	<h4>In&Phi;Ma-Duell</h4>
	<p><a href="duell">Hier gehts zum Spiel</a></p>

	<h4>In&Phi;Ma-Memory</h4>
	<p><a href="memory">Hier gehts zum Spiel</a></p>

	<h4>In&Phi;Ma-Jeopardy</h4>
	<p><a href="jeopardy">Hier gehts zum Spiel</a></p>
</div>
<div class="col-lg-6">
	<h3>Zwischenstand</h3>
	<table class="table table-bordered">
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
							<li><?= $oMember->name ?> (<?= $oMember->subject ?>)</li>
						<?php endforeach; ?>
						</ul>
					</div>
				</td>
				<td class="right"><?= $oGroup->finalpoints ?></td>
			</tr>
		<?php endforeach; ?>
	</table>
</div>