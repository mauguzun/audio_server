
<div id="mymap" style="width: 100%;height:400px;margin-bottom: 100px;"></div>

<script src="https://maps.googleapis.com/maps/api/js?key=<?= GOOGLE ?>&libraries=places&callback"></script>

<script>


	let map  ;
	let marker = null ;
	let lat = document.getElementById("lat");
	let lng = document.getElementById("lng");


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

		google.maps.event.addListener(map, 'click', function(event)
			{
				if (marker != null )
				return ;


				lat.value = event.latLng.lat();
				lng.value = event.latLng.lng();

				createMarker(event.latLng.lat(),event.latLng.lng());

			})


	}

	function createMarker(lat,lng)
	{

  	  
		marker =  new google.maps.Marker({position: {lat: lat, lng: lng} ,map: map,draggable:true});
		map.setCenter( {lat: lat, lng: lng})
		catchMarker();
	}

	function catchMarker()
	{
		google.maps.event.addListener(marker, "dragend", function (event)
			{
				lat.value = event.latLng.lat();
				lng.value = event.latLng.lng();
			})

	};
	initMap();



	$('#lat , #lng').focusout(function()
		{

			let latValue = lat.value;
			let lngValue = lng.value;
			
			latValue = latValue.replace(",",".");
			lngValue = lngValue.replace(",",".");
			
			let intLatValue = parseFloat(latValue);
			let intLngValue = parseFloat(lngValue);
			
			

			if (latValue && lngValue && marker)
			{
				marker.setPosition(new google.maps.LatLng(latValue,lngValue));

			}
			else if (latValue && lngValue )
			{

				createMarker(intLatValue,intLngValue);
			}

			map.setCenter({lat:intLatValue, lng:intLngValue});
		})

	<? if (isset($query) ):?>


	let tempLat = document.getElementById("lat").value;
	let tempLng = document.getElementById("lng").value;



	createMarker(  parseFloat(tempLat),parseFloat(tempLng));
	<? endif; ?>
	//upload img

</script>
