<div id="wrapper">
	<div id="header">
		<p>Gefundene Paare: <span id="foundPairs">0</span> | 
			Fehler: <span id="madeErrors">0</span> | 
			verbleibende Zeit: <span id="gameCountdown" class="countdown"></span></p>
	</div>
	<div id="tiles">
		<div class="desc letter"></div>
		<div class="desc letter">A</div>
		<div class="desc letter">B</div>
		<div class="desc letter">C</div>
		<div class="desc letter">D</div>
		<div class="desc letter">E</div>
		<div class="desc letter">F</div>
		<?php $i = 0; ?>
		<?php foreach($aTiles as $sTile) : ?>
			<?php if ($i%6 == 0) : ?>
			<div class="desc number"><?= ($i/6)+1 ?></div>
			<?php endif; ?>
			<?php $i++; ?>	
		<div class="tile closed" tile="<?= $sTile ?>"><img src="<?= base_url() ?>assets/img/memory/tiles/<?= $sTile ?>"></div>
		<?php endforeach; ?>
	</div>
</div>


<div style="display:none">
	<a class="fancybox" href="#winWindow" id="winButton"></a>
	<div id="winWindow" class="popup clearfix">
		<img src="<?= base_url() ?>assets/img/memory/tux-win.jpg">
		<strong>Gratulation!</strong>
		<p>Ihr habt alle Paare gefunden, <span id="win_errors"></span>&nbsp;Fehlversuche benötigt und h&auml;ttet noch <span id="win_timeleft"></span>&nbsp;Sekunden &uuml;brig gehabt.</p>
		<p>Eure Punktzahl: <strong><span id="win_points"></span></strong></p>
		<p><a data-url="<?= base_url() ?>eintragen/" href="#" id="save_result">Speichern</a></p>
	</div>
	<a class="fancybox" href="#loseWindow" id="loseButton"></a>
	<div id="loseWindow" class="popup clearfix">
		<img src="<?= base_url() ?>assets/img/memory/tux-lose.jpg">
		<strong>Zeit abgelaufen!</strong>
		<p>Ihr habt <span id="lose_pairs"></span>&nbsp;Pärchen gefunden und <span id="lose_errors"></span>&nbsp;Fehlversuche benötigt.</p>
		<p>Eure Punktzahl: <strong><span id="lose_points"></span></strong></p>
		<p><a data-url="<?= base_url() ?>eintragen/" href="#" id="save_result">Speichern</a></p>
	</div>
	<a class="fancybox" href="#errorWindow" id="errorButton"></a>
	<div id="errorWindow" class="popup clearfix">
		<img src="<?= base_url() ?>assets/img/memory/tux-error.jpg">
		<strong>Falsch!</strong>
		<p>Das war leider ein Fehler, ihr müsst ne kleine Pause machen.</p>
		<!--<div class="button arrow close-fb" type="" title="Weiter...">WEITER</div>-->
	</div>
</div>
