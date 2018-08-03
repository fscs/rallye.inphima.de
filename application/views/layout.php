<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">
	<title>ESAG-Rallye</title>

	<!-- Bootstrap core CSS -->
	<link href="<?= base_url() ?>assets/css/bootstrap.css" rel="stylesheet">
	<script type="text/javascript">
	var base_url = "<?= base_url() ?>";
	</script>
</head>

<body>
	<div class="container">
		<div class="page-header">
			<center><img src="http://www.inphima.de/tl_files/inphima/bg/sommeresag2017-banner.png" alt="Rallye SS 2017"/></center>
		</div>
		<?php if ($this->user->loggedIn()) : ?>
		<ul class="nav nav-pills nav-justified">
			<li><a href="<?= base_url() ?>">Start</a></li>
			<li><a href="<?= base_url() ?>punkte/">Punkte</a></li>
			<li><a href="<?= base_url() ?>eintragen/">Eintragen</a></li>
			<?php if ($this->user->isAdmin()) : ?>
			<li><a href="<?= base_url() ?>siegerehrung/">Siegerehrung</a></li>
			<?php endif; ?>
			<li><a href="<?= base_url() ?>home/logout/">Logout</a></li>
		</ul>
		<?php endif; ?>
<?php if ($flash_message && $flash_message_class) : ?>
	<div id="topbox" class="alert alert-<?= $flash_message_class ?>"><?= $flash_message ?></div>
<?php endif; ?>

	<div class="row">
		<?= $content ?>
	</div>

	<div class="footer">
		<p>&copy; In&Phi;Ma 2015</p>
	</div>

</div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="//code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?= base_url() ?>assets/js/bootstrap.min.js"></script>
    <script src="<?= base_url() ?>assets/js/layout.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
    	$('#topbox:not(.keep)').fadeIn(300).delay(6000).fadeOut(300);
    	$('#next_place').click(function() { 
    		$('.hidden').last().removeClass('hidden');
    	});
    	$("a[rel='popover']").each(function() {
    		var that = $(this);
    		that.popover({
    			trigger: 'hover',
    			placement: 'auto',
    			html: true,
    			title:'Mitglieder',
    			content: that.parent().find('.members').html()  
    		});
    	});
    });
    </script>
</body>
</html>
