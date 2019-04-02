

<!-- Portfolio -->
<section class="portfolio white-bg hover-show pad-t-b-130">

	<!-- Item Start -->
	<div class="items popup-gallery with-space col-4">


		<?
		foreach($points as $point ) :?>
		<!-- ITEM -->
		<div class="cbp-item portfolio-item web mob-app photo ui">
			<article>
				<div class="portfolio-image">



					<section class="slider-simple" 
					data-animation="fade"
					data-control-nav="false" data-slideshow="true"
					data-slideshow-speed="500"
					>
						<div class="free-slide">
							<ul class="slides">


								<?
								foreach($point['img'] as $img ):?>
								<li>
									<img class="img" alt="<?= $point['title']?>" src="<?= base_url().'/uploads/'. $img?>">

								</li>
								<? endforeach ;?>

							</ul>
						</div>
					</section>

					<div class="portfolio-overlay"></div>
					<div class="position-bottom">


						<a href="<?= base_url().'point/'. $point['id']?>"><p><?= $point['title']?></p></a>
					</div>
				</div>
			</article>
		</div>
		<? endforeach; ?>


	</div>

</section>

<style>
	.img ,.slider-simple
	{
		width: 100%;
		height: 200px;
		object-fit: cover;
	}
	.slider
</style>
<script>
	$('.carousel').carousel()
</script>