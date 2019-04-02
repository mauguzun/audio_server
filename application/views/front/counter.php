
<div class="counters" style="margin-bottom: 50px;margin-top: 50px;" >
	<ul class="row" >



		<?
		foreach($cities as $id => $city):?>


		<li class="col-sm-3"> <span class="counter"><?=  $city['points'] == null ? 0 :    count($city['points']) ?></span>
		  <p>
		  	<a href="<?= 
			$city['points'] == null ? '#'  : base_url().'point/'.$city['points'][0]
			?>"  ><?= $city['title']?></a>
		  	
		  </p>	
		  
		  <h5>	<a title="<?= lang('title')?>"   href="<?= 
			$city['points'] == null ? '#'  : base_url().'guide/'.$id
			?>"  >  <?= lang('title')?>  <br ><?= $city['title']?></a></h5>
		</li>

		<? endforeach ;?>



	</ul>
</div>
