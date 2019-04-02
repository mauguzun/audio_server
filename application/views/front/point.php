
<div class="checkout-form item-detail-page " style="padding-top: 20px;" >

	<div class="row">

		<div class="col-sm-6">

			<h2><?= $point['title'] ?></h2>

			<a href="<?= base_url().'guide/'.$point['city_id'] ?>" class="btn margin-top-50">

				<?= lang('title')?>
				<?= $city[$point['city_id']]['title']?>

			</a>
			<br />
			<br />
			<p><?= $point['text'] ?></p>

			<audio controls>
				<source src="<?= base_url().'/uploads/'.$point['mp3'] ?>" type="audio/ogg">
				<source  src="<?= base_url().'/uploads/'.$point['mp3'] ?>" type="audio/mpeg">
			</audio>
		</div>
		<div class="col-sm-6  large-detail">
			<div class="images-slider">
				<ul class="slides">
				
					<? foreach ($point['img'] as $img) :?>
					  
					<li data-thumb="<?= base_url().'/uploads/'.$img?>">
						<img alt=""  class="img-responsive" width="100%" src="<?= base_url().'/uploads/'.$img ?>">
					</li>
					<? endforeach ;?>
				</ul>
				<div class="clearfix"></div>

			</div>

			<br />
			<br />


		</div>

		<div id="mymap" class="col-sm-12" style="min-height:300px;margin-top:5px;">

		</div>




	</div>


</div>

<script src="https://maps.googleapis.com/maps/api/js?key=<?= GOOGLE ?>&libraries=places&callback"></script>

<script>


	let map  ;
	let marker = null ;


	function initMap()
	{
		map   = new google.maps.Map(document.getElementById('mymap'),
			{
				center:
				{
					/*					lat: 43.6976763, lng: 7.268197
					*/					lat: 56.953304, lng: 24.208990099999937
				},
				zoom: 14
			});


	}

	function createMarker(lat,lng)
	{

		marker =  new google.maps.Marker({position: {lat: lat, lng: lng} ,map: map});
		map.setCenter( {lat: lat, lng: lng})
		catchMarker();
	}


	initMap();

	<? if (isset($point) ):?>


	let tempLat = "<?= $point['lat']?>"
	let tempLng = "<?= $point['lng']?>"

	createMarker(  parseFloat(tempLat),parseFloat(tempLng));
	<? endif; ?>
	//upload img

</script>
