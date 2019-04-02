<!-- Shop Content -->



<div class="shop-content " style="margin-top: 100px" >
	<div class="container">

      <div class="container"> 
        
        <!-- Heading -->
        <div class="heading-block margin-bottom-20">
          <h4> - <?= lang('site_title') ?> - </h4>
          <h2><?= $title ?></h2>
        </div>
       
        
      </div>
    
		<div class="row">

			<!-- Shop Side Bar -->
			<div class="col-md-3">
				<div class="side-bar">
					<!--<div class="search">
						<form>
							<input type="text" placeholder="SEARCH">
							<button type="submit">
								<i class="fa fa-search"></i></button>
						</form>
					</div>-->

					<!-- HEADING -->
					<div class="heading">
						<h6><?= lang('Products Categories') ?></h6>
						<hr class="dotted">
					</div>

					<!-- CATEGORIES -->
					<ul class="cate">
						<?
						foreach($cat as $value) :?>
						<li>
							<a href="<?= base_url().'store/'.$value['id']?>"><?= $value['category']?></a></li>

						<? endforeach ;?>

					</ul>


				</div>
			</div>

			<!-- Main Shop Itesm -->
			<div class="col-md-9">
				<!-- SHOWING INFO -->
				<!--  <div class="showing-info">
				<p class="pull-left">Showing   1 - 12  of   30 results</p>
				</div>-->
				<div class="row">

					<?
					foreach($products as $one):?>
					<div class="col-sm-4">
						<article class="shop-artical">
							<img class="img-responsive" src="<?= $one['img']?>"
							style="height: 330px;weight:447px;  object-fit: cover"
							alt="<?= $one['title']?>" >
							<div class="item-hover">
								<div class="up-side">
									<hr class="dotted white">

									<a href="<?= base_url().'product/'.$one['id']?>"><?= $one['title']?></a>
									<?
									if($show):?>
									<span class="price"><?= $one['price']?>
										<strong>NOK</strong>  </span>
									<? endif;?>
								</div>

								<?
								if($show):?>
								<a href="#." data-id="<?= $one['id']?>" class="btn add_to_cart"><?= lang('add_to_cart')?></a>
								<?
								else :?>
								<a href="<?= base_url().'auth/create_user'?>" class="btn"><?= lang('register')?></a>
								<? endif;?>
								<a  href="<?= base_url().'product/'.$one['id']?>" class="btn by"><?= lang('view_more')?></a>


							</div>
						</article>
					</div>

					<? endforeach ?>
				</div>

				<!-- Pagination -->
				<!--<ul class="pagination">
				<li><a href="#.">1</a></li>
				<li><a href="#.">2</a></li>
				<li><a href="#.">....</a></li>
				<li><a href="#.">&gt;</a></li>
				</ul>-->
			</div>
		</div>
	</div>
</div>



<script>
	$('.add_to_cart').on('click',function()
		{
			let append = $.post("<?= base_url().'user/addtocart'?>",
				{
					id: $(this).attr('data-id'), qty: 1
				} );
			append.then(e=>
				{
					let result = JSON.parse(e);
					if(result.error === undefined)
					{

						$('#cart_total').text(result.done);
						$('#cart_total').focus();

					}
				})
		})
</script>

<!-- End Content -->
