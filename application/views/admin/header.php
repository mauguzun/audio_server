<!doctype html>
<html  lang="en">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="author" content="<?= lang('Discover Nice')?>" />
	<!-- Document Title -->
	<title>
		<?= lang('Discover Nice')?>
	</title>
	<meta  name="description" content="<?= lang('Discover Nice')?>"/>
	<meta  name="keywords" content="<?= lang('Discover Nice')?>"/>

	<!-- Favicon -->
	<link rel="shortcut icon" href="<?= base_url()?>static/admin/images/favicon.ico" type="image/x-icon">
	<link rel="icon" href="<?= base_url()?>static/admin/images/favicon.ico" type="image/x-icon">

	<!-- SLIDER REVOLUTION 4.x CSS SETTINGS -->

	<!-- StyleSheets -->
	<link rel="stylesheet" href="<?= base_url()?>/static/admin/css/ionicons.min.css">
	<link rel="stylesheet" href="<?= base_url()?>/static/admin/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?= base_url()?>/static/admin/css/main.css">
	<link rel="stylesheet" href="<?= base_url()?>/static/admin/css/style.css">
	<link rel="stylesheet" href="<?= base_url()?>/static/admin/css/responsive.css">

	<!-- Fonts Online -->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:200,300,400,500,600,700,800,900|Raleway:200,300,400,500,600,700,800,900" rel="stylesheet">
	<script src="<?= base_url()?>/static/admin/js/vendors/jquery/jquery.min.js">
	</script>
	<script src="<?= base_url()?>/static/admin/js/uploader.js" ></script>
	<!-- JavaScripts -->
	<script src="<?= base_url()?>/static/admin/js/vendors/modernizr.js">
	</script>
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	<style>
		.img_preview
		{
			witdth: 100px;
			height: 100px;
			object-fit: cover;
		}
	</style>
</head>
<body>

<!-- LOADER -->
<!--<div id="loader">
<div class="position-center-center">
<div class="loader"></div>
</div>
</div>
-->
<!-- Page Wrapper -->
<div id="wrap">


<!-- Nav -->
<div class="fly-nav">
	<nav class="overlay" id="overlay">
		<div class="position-center-center">

			<ul>





				<li>
					<a href="<?= base_url().'admin/cities'?>">Cities</a></li>


				<li>
					<a href="<?= base_url().'admin/cities/add'?>">Add City</a></li>


				<li>
					<a href="#form" data-toggle="collapse"  data-parent="#accordion"  >
					Point manager
					<i class="fa fa-angle-right">
						</i>
					</a>
					<div id="form" class="panel-collapse collapse" role="tabpanel">
						<ul>
							<li>
								<a href="<?= base_url().'admin/points/'?>">Points</a></li>

							<li>
								<a   href="<?= base_url().'admin/points/add'?>">Add Point</a></li>


						</ul>
					</div>
				</li>


				<li>
					<a href="<?= base_url().'admin/pages/'?>">Pages</a></li>
				<li>
					<a href="<?= base_url().'admin/pages/add'?>">Add Page</a></li>







			</ul>
		</div>



		<!-- Bottom Info -->
		<div class="botton-info">
			<div class="container-fluid">
				<div class="col-sm-6">

				</div>
				<div class="col-sm-6 text-right">
					<a href="#.">
						<i class="fa fa-facebook">
						</i>
					</a>
					<a href="#.">
						<i class="fa fa-google">
						</i>
					</a>
					<a href="#.">
						<i class="fa fa-behance">
						</i>
					</a>
					<a href="#.">
						<i class="fa fa-twitter">
						</i>
					</a>
				</div>
			</div>
		</div>
	</nav>
</div>

<!-- Header Icon -->
<div class="fly-nac-icon">
	<div class="position-center-center">
		<div class="toggle-button" id="toggle">
			<span class="bar top">
			</span>
			<span class="bar middle">
			</span>
			<span class="bar bottom">
			</span>
		</div>
	</div>
</div>

<!-- Logo -->


<div class="content shadow">
<div class="container" style="min-height: 100vh;" >


<!-- End logo -->
