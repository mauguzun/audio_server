  <!-- Footer -->
</div></div>
<footer>

	<div class="foot-down">
		<div class="container">
			<div class="row">
				<div class="col-sm-6 text-left">
					<p>
						<?= lang('Discover Nice')?>
					</p>
				</div>
				<div class="col-sm-6">
					<a href="#">
						<i class="fa fa-facebook">
						</i>
					</a>
					<a href="#">
						<i class="fa fa-twitter">
						</i>
					</a>

				</div>
			</div>
		</div>
	</div>
</footer>

<!-- End Footer -->

<!-- GO TO TOP  -->
<a href="#" class="cd-top">
	<i class="fa fa-angle-up">
	</i>
</a>
<!-- GO TO TOP End -->

<!-- End Page Wrapper -->

<!-- JavaScripts -->

<script src="<?= base_url()?>static/admin/js/vendors/wow.min.js">
</script>

<script src="<?= base_url()?>static/admin/js/vendors/jquery.magnific-popup.min.js">
</script>
<script src="<?= base_url()?>static/admin/js/vendors/own-menu.js">
</script>
<script src="<?= base_url()?>static/admin/js/vendors/jquery.sticky.js">
</script>
<script src="<?= base_url()?>static/admin/js/vendors/owl.carousel.min.js">
</script>

<!-- SLIDER REVOLUTION 4.x SCRIPTS  -->

<script src="<?= base_url()?>static/admin/js/main.js">
</script>


<link rel="stylesheet" type="text/css" href="<?= base_url() ?>/static/gdpr/dist/style.css" />

<script type="text/javascript" src="<?= base_url() ?>/static/gdpr/dist/script.js"></script>


<? if ($current_lang != 'en') :?>
<script type="text/javascript" src="<?= base_url() ?>/static/gdpr/dist/langs/<?=  $current_lang ?>.js"></script>
<? endif ;?>

<!--<script>
	gdprCookieNotice(
		{
			locale: '<?=  $current_lang ?>', //This is the default value
			timeout: 500, //Time until the cookie bar appears
			expiration: 30, //This is the default value, in days
			domain: '<?= base_url()?>', //If you run the same cookie notice on all subdomains, define the main domain starting with a .
			implicit: true, //Accept cookies on scroll
			statement: 'http://ico.org.uk/for_organisations/privacy_and_electronic_communications/the_guide/cookies', //Link to your cookie statement page
			
			
		});
</script>-->

</body>
</html>