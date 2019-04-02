<div class="blog-single-post">

	<!-- Post Img -->
	<div class="col-md-9 center-auto">

		<!-- Heading -->

		<h4  style="text-align: center;margin-top: 35px;margin-bottom: 35px;" ><?= $query['title']?></h4>
		<ul class="nolist-style post-info">
			<li>
				<p>
					<i class="icon-calendar"></i><?= date("d-m-Y") ?></p>
			</li>
			<li>
				<a href="<?= base_url()?>">
					<i class="fa fa-shopping-cart"></i><?= lang('store')?></a>
			</li>
			<li>
				
			</li>
		</ul>

		<?= $query['text']?>
	</div>
	<hr class="margin-top-80 margin-bottom-80">

</div>