    <!--======= PAGES INNER =========-->
<section class="item-detail-page pad-t-b-80" style="margin-top: 40px">
	<div class="container">


		<!--======= PRODUCT DESCRIPTION =========-->
		<div class="item-decribe">
			<!-- Nav tabs -->
			<ul class="nav nav-tabs" role="tablist">
				<li role="presentation" class="active">
					<a href="#descr" role="tab" data-toggle="tab">Dailogs</a></li>
				<li role="presentation" >
					<a href="#review" role="tab" data-toggle="tab">Customer Info </a></li>



				<!--<li role="presentation">
				<a href="#tags" role="tab" data-toggle="tab">TAGS</a></li>-->
			</ul>

			<!-- Tab panes -->
			<div class="tab-content">
				<!-- DESCRIPTION -->
				<div role="tabpanel" class="tab-pane fade in active" id="descr">
					<h6>3 REVIEWS FOR SHIP YOUR IDEA</h6>


					<?
					foreach($dialog as $reply):?>
					<!-- REVIEW PEOPLE 1 -->
					<div class="media">
						<div class="media-left">

							<? $url = $reply['IsJohn'] ? "https://blog.smatsocial.com/wp-content/uploads/2018/02/bot-icon-2883144_1280.png" : "https://images-na.ssl-images-amazon.com/images/I/41wadDtRwwL.png"; ?>

							<img  width="60px" src="<?= $url ?>" alt="" / >

							<!--<div class="avatar">
							</div>-->
						</div>
						<!--  Details -->
						<div class="media-body">
							<p><?= $reply['IsJohn']? "Johny": $customer['Name'] ?></p>

							<?
							if( $bHasLink = strpos( $reply['Message'], base_url()) !== false ) :?>
							<?
							$regex = '/https?\:\/\/[^\",]+/i';
							preg_match_all($regex, $reply['Message'], $matches);
							
							?>
							<img src="<?= $matches[0][0]?>" alt="" />
							<?
							else :?>
							<h6><?= $reply['Message']?>
								<? endif; ?>





								<span class="pull-right"><?= $reply['Date']?><?= $reply['Time']?></span> </h6>
						</div>
					</div>
					<? endforeach ?>


				</div>

				<!-- REVIEW -->
				<div role="tabpanel" class="tab-pane fade" id="review">

					<?
					foreach($customer as $key=>$value) :?>
					<?
					if($key != 'Id' & $key != 'ConvId') :?>
					<b><?= $key ?></b> <?= $value ?><br /><br /><br />
					<? endif;?>
					<? endforeach;?>
				</div>

				<!-- TAGS -->



			</div>
		</div>
	</div>
</section>

<section class="item-detail-page pad-t-b-80" style="margin-top: 40px">

</section>


