<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>In&Phi;Ma-Memory</title>
<script type="text/javascript" src="<?= base_url() ?>assets/js/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/js/jquery.fancybox-1.3.4.pack.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/js/jquery.countdown.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/js/memory.js"></script>
<link rel="stylesheet" href="<?= base_url() ?>assets/css/common.css" type="text/css" />
<link rel="stylesheet" href="<?= base_url() ?>assets/css/memory.css" type="text/css" />
<link rel="stylesheet" href="<?= base_url() ?>assets/css/fancybox/jquery.fancybox-1.3.4.css" type="text/css" />
<script type="text/javascript">
var totalPairs = <?= $iNumberOfPairs ?>;
var totalTime = <?= $iPlaytime ?>;
</script>
<style type="text/css">
#wrapper {
	width: <?= (($iOptimalWidth+1) * ($iTileWidth + 8)) ?>px;
}

.tile {
	width: <?= $iTileWidth ?>px;
	height: <?= $iTileHeight ?>px;
}
</style>
</head>
<body>
<?= $content ?>
</body>
</html>