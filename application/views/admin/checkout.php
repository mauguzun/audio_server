<div class="shopping-cart text-center" style="margin-top: 50px;">

	<div class="container">

		<!-- Heading -->
		<div class="heading-block margin-bottom-20">
			<h4> - <?= lang('site_title') ?> - </h4>
			<h2><?= lang('you_cart') ?></h2>
		</div>


	</div>

	<div class="cart-head">
		<ul class="row">
			<!-- PRODUCTS -->
			<li class="col-sm-2 text-left">
				<h6>PRODUCTS</h6>
			</li>
			<!-- NAME -->
			<li class="col-sm-4 text-left">
				<h6>TITLE</h6>
			</li>
			<!-- PRICE -->
			<li class="col-sm-2">
				<h6>PRICE</h6>
			</li>
			<!-- QTY -->
			<li class="col-sm-1">
				<h6>QTY</h6>
			</li>

			<!-- TOTAL PRICE -->
			<li class="col-sm-2">
				<h6>TOTAL</h6>
			</li>
			<li class="col-sm-1"> </li>
		</ul>
	</div>

	<!-- Cart Details -->
	<?
	foreach($cart as $value):?>
	<ul class="row cart-details" id="<?= $value['id']?>">

		<li class="col-sm-5">
			<div class="media">
				<!-- Media Image -->
				<div class="media-left media-middle">
					<a href="#." class="item-img"> <img class="media-object" src="<?= $value['img']?>" alt=""> </a> </div>

				<!-- Item Name -->
				<div class="media-body">
					<div class="position-center-center">
						<h5><?= $value['title']?></h5>
						<a target="_blank" href="<?= base_url().'product/'.$value['id'];?>"><?= lang('view_details')?></a>
					</div>
				</div>
			</div>
		</li>

		<!-- PRICE -->
		<li class="col-sm-3">
			<div class="position-center-center">
				<span class="price">
					<small>NOK</small><?= $value['price']?></span> </div>
		</li>

		<!-- QTY -->
		<li class="col-sm-1">
			<div class="position-center-center">
				<div class="quinty">
					<!-- QTY -->
					<input type="number" class="edit-qty" value="<?= $value['qty']?>" placeholder="<?= lang('qty') ?>">
				</div>
			</div>
		</li>

		<!-- TOTAL PRICE -->
		<li class="col-sm-2">
			<div class="position-center-center">
				<span class="price">
					<small>NOK </small><?= $value['subtotal']?></span> </div>
		</li>

		<!-- REMOVE -->
		<li class="col-sm-1">
			<div class="position-center-center">
				<a href="<?= $value['id']?>">
					<i class="icon-close"></i></a> </div>
		</li>

	</ul>
	<? endforeach ;?>

</div>
</div>

<section class="pad-t-b-130 light-gray-bg shopping-cart small-cart">
	<div class="container">

		<!-- SHOPPING INFORMATION -->
		<div class="cart-ship-info margin-top-0">

			<!-- DISCOUNT CODE -->

			<!-- SUB TOTAL -->
			<div class="col-sm-12">
				<h6>grand total</h6>
				<div class="grand-total">
					<div class="order-detail">
						<p><?= lang('products')?>
							<span>NOK
								<strong><?= $total['total']?></strong>  </span></p>
						<p><?= lang('shiping')?>
							<span>NOK
								<strong><?= $total['total_shipping']?></strong> </span></p>
						<!-- SUB TOTAL -->
						<p class="all-total"><?= lang('total_cost')?>
							<span>
								<strong><?= $total['grand_total']?></strong></span></p>
					</div>
				</div>
			</div>
			<div class="col-sm-12 text-right margin-top-30">
				<div class="coupn-btn">
					<a href="<?= base_url().'user/pay'?>" class="btn btn-inverse"><?= lang('pay')?></a> </div>
			</div>
		</div>
	</div>
	</div>
</section>