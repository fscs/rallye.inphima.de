<div class="col-lg-6">
	<h2>Spiele</h2>
	<h4>In&Phi;Ma-Duell</h4>
	<p><a href="duell">Hier gehts zum Spiel</a></p>

	<h4>In&Phi;Ma-Memory</h4>
	<p><a href="memory">Hier gehts zum Spiel</a></p>

	<h4>In&Phi;Ma-Jeopardy</h4>
	<p><a href="jeopardy">Hier gehts zum Spiel</a></p>
</div>

<div class="col-lg-6">
	<h2>Login</h2>
	<div class="login">
		<?= form_open("home/login") ?>
		<div class="form-group">
			<?= form_label('Benutzername:', 'username'); ?>
			<div class="col-lg-5">
			<?= form_input(array('name' => 'username', 'id' => 'username'),set_value('username')) ?>
			</div>
		</div>
		<div class="form-group">
			<?= form_label('Passwort:', 'password'); ?>
			<div class="col-lg-5">
			<?= form_password(array('name' => 'password', 'id' => 'password')) ?>
			</div>
		</div>
		<?= form_submit(array('id' => 'submitlogin', 'name' => 'submitlogin'), 'Anmelden') ?>
	</div>
</div>