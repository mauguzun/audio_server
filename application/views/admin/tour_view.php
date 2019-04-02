
<style type="text/css">
	#map
	{
		height: 600px;
	}


</style>



<div class="container">


	
	<div class="row">
		<div class="col-sm">
			<div id="infowindow-content">


				<img id="place-img" src="" width="150px" style="float: right;margin-left: 40px"/>

				<strong id="place-title" style="font-size: 20px"></strong><br>
				<span id="place-desc"></span>
			</div>
			<div id="map"></div>
		</div>

	</div>


</div>
</div>



<script type="text/javascript"
            src="https://maps.google.com/maps/api/js?sensor=false&libraries=drawing&key=<?= GOOGLE?>"></script>

<script type="text/javascript">
	var drawingManager;
	var selectedShape;
	var colors = ['#1E90FF', '#FF1493', '#32CD32', '#FF8C00', '#4B0082'];
	var selectedColor;
	var colorButtons =
	{
	};
	var map;

	let markersInfo = [];
	var currentID;
	let saveData = null;







	function initialize()
	{
		map = new google.maps.Map(document.getElementById('map'),
			{
				zoom: 11,
				center: new google.maps.LatLng(43.7031691, 7.1827772),
				// mapTypeId: google.maps.MapTypeId.SATELLITE,
				disableDefaultUI: false,
				zoomControl: true
			});




		<? if ($edit) : ?>
		restore();
		<? endif;?>
		//  buildColorPalette();
	}


	google.maps.event.addDomListener(window, 'load', initialize);




	let infowindow = new google.maps.InfoWindow();
	let infowindowContent = document.getElementById('infowindow-content');

	function restore()
	{


		let pointsArray = null;

		<? if ($edit ):?>
		saveData = <?= $edit->getPath() ?>;
		pointsArray = <?= $edit->getPointsJson() ?>;
		console.log(pointsArray)

		<? endif;?>


		var flightPath = new google.maps.Polyline(
			{
				path: saveData,
				geodesic: true,
				strokeColor: '#FF0000',
				strokeOpacity: 1.0,
				strokeWeight: 2
			});

		flightPath.setMap(map);

		if (saveData){
			zoomToObject(flightPath);
		}
		
		pointsArray.forEach(index =>
			{


				let pointOnMap = new google.maps.Marker(
					{
						position:
						{
							lat: parseFloat(index.lat),
							lng: parseFloat(index.lng)
						},
						map: map,
						title: index.name  ,

					});

				google.maps.event.addListener(pointOnMap, 'click', function ()
					{

						infowindowContent.children['place-title'].textContent = index.translate.en.title  ;
						infowindowContent.children['place-desc'].innerHTML =index.translate.en.desc
						infowindowContent.children['place-img'].setAttribute('src',index.img.toString())  ;
						infowindow.setContent(infowindowContent);

						infowindow.close(); // Close previously opened infowindow
						infowindow.open(map, pointOnMap);
					});

			})
	}

	function zoomToObject(obj)
	{
		var bounds = new google.maps.LatLngBounds();
		var points = obj.getPath().getArray();
		for (var n = 0; n < points.length ; n++)
		{
			bounds.extend(points[n]);
		}
		map.fitBounds(bounds);
	}
</script>

