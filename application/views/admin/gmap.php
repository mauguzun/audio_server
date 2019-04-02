
<script src="https://maps.googleapis.com/maps/api/js?key=<?= GOOGLE ?>&libraries=places&callback"
        async defer></script>

<script>


	var  map  ;
	function initMap()
	{


		map   = new google.maps.Map(document.getElementById('mymap'),
			{
				center:
				{
					lat: 43.6976763, lng: 7.268197
				},
				zoom: 14
			});

		$('.gmap').each((key,value)=>
			{
				setAutoComplate(value);
			})

		$('.save').click((e)=>
			{
				const id = e.target.getAttribute('id');
				$.post('<?= base_url() ?>admin/Drivermanager/update',
					{
						'user_id':id,
						'status':$(`.status[data-id="${id}"]`).val(),
						'lat':$(`.lat[data-id="${id}"]`).val(),
						'lng':$(`.lng[data-id="${id}"]`).val(),
					});
			})  

	}

	function setAutoComplate(arg)
	{

		var autocomplete = new google.maps.places.Autocomplete(arg);
		autocomplete.bindTo('bounds',map);
		autocomplete.setFields(['address_components', 'geometry', 'icon', 'name']);

		const id = arg.getAttribute("data-id");
		console.log(id)

		autocomplete.addListener('place_changed', function ()
			{



				var place = autocomplete.getPlace();
				if (!place.geometry)
				return;


				var address = '';
				if (place.address_components)
				{
					address = [
						(place.address_components[0] && place.address_components[0].short_name || ''),
						(place.address_components[1] && place.address_components[1].short_name || ''),
						(place.address_components[2] && place.address_components[2].short_name || '')
					].join(' ');
				}

				$(`.lat[data-id="${id}"]`).val(place.geometry.location.lat())
				$(`.lng[data-id="${id}"]`).val(place.geometry.location.lng())



				// show button
			});
	}

</script>
<div id="mymap" style="width: 100%;height:600px;margin-bottom: 100px;">

</div>