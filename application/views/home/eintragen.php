<div class="col-lg-12">
	<?php if($isAdmin) { ?>
	<div class="alert alert-warning">Sie sind derzeit als Admin eingeloggt und können alle Punkte überschreiben.</div>
	<?php } ?>
	<h2>Punkte eintragen</h2>
	<?= form_open('eintragen') ?>
	<input type="hidden" name="action" value="insert">
	<div class="form-group">
		<label for="group" class="col-lg-2 control-label">Gruppe:</label>
		<div class="col-lg-10">
			<select name="group" id="group">
				<option value="" disabled="disabled">bitte wählen</option>
				<?php foreach ($aNewGroups as $oGroup) : ?>
					<option value="<?= $oGroup->id ?>"><?= $oGroup->name ?></option>
				<?php endforeach; ?>
			</select>
		</div>
	</div>
	<?php if($isAdmin) { ?>
	<div class="form-group">
		<label for="group" class="col-lg-2 control-label">Station:</label>
		<div class="col-lg-10">
			<select name="station" id="station">
				<option value="" disabled="disabled">bitte wählen</option>
				<?php foreach ($stations as $id => $name) : ?>
					<option value="<?= $id ?>"><?= $name ?></option>
				<?php endforeach; ?>
			</select>
		</div>
	</div>
	<?php } ?>
	<div class="form-group">
		<label for="points" class="col-lg-2 control-label">Punkte:</label>
		<div class="col-lg-2">
			<input class="form-control" value="<?= $aPunkte ?>" type="text" name="points" id="points">
		</div>
	</div>
	<div class="form-group">
	    <div class="col-lg-offset-2 col-lg-10">
	    	<input type="submit" class="btn btn-default" value="Speichern">
	    </div>
	</div>
	<?= form_close() ?>

	<h2>Punkte korrigieren</h2>
	<?= form_open('eintragen') ?>
	<input type="hidden" name="action" value="update">
	<div class="form-group">
		<label for="group" class="col-lg-2 control-label">Gruppe:</label>
		<div class="col-lg-10">
			<select name="group" id="group">
				<option value="">bitte wählen</option>
				<?php foreach ($aOldGroups as $oGroup) : ?>
					<option value="<?= $oGroup->id ?>"><?= $oGroup->name ?></option>
				<?php endforeach; ?>
			</select>
		</div>
	</div>
	<?php if($isAdmin) { ?>
	<div class="form-group">
		<label for="group" class="col-lg-2 control-label">Station:</label>
		<div class="col-lg-10">
			<select name="station" id="station">
				<option value="">bitte wählen</option>
				<?php foreach ($stations as $id => $name) : ?>
					<option value="<?= $id ?>"><?= $name ?></option>
				<?php endforeach; ?>
			</select>
		</div>
	</div>
	<?php } ?>
	<div class="form-group">
		<label for="points" class="col-lg-2 control-label">Punkte:</label>
		<div class="col-lg-2">
			<input class="form-control" type="text" name="points" id="points">
		</div>
	</div>
	<div class="form-group">
		<div class="col-lg-offset-2 col-lg-10">
			<input type="submit" class="btn btn-default" value="Speichern">
		</div>
	</div>
	<?= form_close() ?>
	<div class="alert alert-info">Die Punktzahl kann mit Nachkommastellen angegeben werden. Bei der Station Extremsport muss die Zeit in Sekunden (inklusive Strafsekunden) eingetragen werden.</div>
</div>