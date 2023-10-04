<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset=" UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
	<link rel="icon" href="<?= $this->ASSETS_URL ?>icon/logo.png">
	<title>Payment | <?= $data['title'] ?></title>
	<link rel="stylesheet" href="<?= $this->ASSETS_URL ?>plugins/fontawesome-free-5.15.4-web/css/all.css" rel="stylesheet">
	<link rel="stylesheet" href="<?= $this->ASSETS_URL ?>/plugins/bootstrap-5.2.2-dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?= $this->ASSETS_URL ?>css/style.css">


	<script src="<?= $this->ASSETS_URL ?>js/jquery-3.6.0.min.js"></script>
	<script src="<?= $this->ASSETS_URL ?>plugins/bootstrap-5.1/bootstrap.bundle.min.js"></script>

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Titillium+Web&display=swap" rel="stylesheet">
	<!-- FONT -->

	<?php $fontStyle = "'Titillium Web', sans-serif;" ?>

	<style>
		html .table {
			font-family: <?= $fontStyle ?>;
		}

		html .content {
			font-family: <?= $fontStyle ?>;
		}

		html body {
			font-family: <?= $fontStyle ?>;
		}

		@media print {
			p div {
				font-family: <?= $fontStyle ?>;
				font-size: 14px;
			}
		}

		html {
			height: 100%;
			background-color: #F4F4F4;
		}

		body {
			min-height: 100%;
		}
	</style>
</head>

<?php require_once("layout_config.php"); ?>

<?php
$class_menu = "m-1 p-1 btn btn-sm btn-outline-dark w-100 border-0 text-nowrap";
?>

<body style="max-width: 752px; min-width:  <?= $min_width ?>;" class="m-auto small border border-bottom-0">
	<?php require_once("nav_top.php"); ?>
	<div class="container" style="padding-bottom: 70px;padding-top: 0px;"></div>
	<?php require_once("nav_bot.php"); ?>
</body>

</html>

<script>
	var time = new Date().getTime();
	$(document.body).bind("mousemove keypress", function(e) {
		time = new Date().getTime();
	});

	function refresh() {
		if (new Date().getTime() - time >= 420000)
			window.location.reload(true);
		else
			setTimeout(refresh, 10000);
	}
	setTimeout(refresh, 10000);
</script>