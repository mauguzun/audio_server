

<!-- Portfolio -->
<section class="portfolio port-wrap white-bg pad-t-b-130" style="margin-top: 50px;">
	<div class="container">

		<!-- PORTOFLIO ITEMS FILTER -->
		<ul class="portfolio-filter">

			<li><h1></h1><a class="active" href="#." data-filter="*"><?= $title ?></a></li>



		</ul>
	</div>

	<!-- Item Start -->
	<div class="items popup-gallery no-space col-4">

		<?
		foreach($langs as $code=>$lang) :?>
		<!-- ITEM -->
		<div class="cbp-item portfolio-item web mob-app photo ui">
			<article>
				<div class="portfolio-image">
<a href="<?= $url.'?lang='.$code  ?>">
					<img class="lang_img"
					src="<?= base_url().'static/sq_lang/'.$code ?>.png"
					/>
					<div class="portfolio-overlay"></div>
					<div class="position-bottom">

				
						<p><?= $lang ?></p>
					</div>
					</a>
				</div>
			</article>
		</div>
		<? endforeach ;?>
	</div>
	<!-- LOAD MORE -->
	<div class="text-center margin-top-50 animate fadeInUp" data-wow-delay="0.4s">

		<?= $desc ?>
	</div>
</section>

<style>
	.lang_img
	{
		height: 200px;
		padding: 25px;
		-webkit-filter: drop-shadow(0 1px 2px rgba(0,0,0,0.24));
		filter: drop-shadow(0 1px 2px rgba(0,0,0,0.24));
	}
</style>