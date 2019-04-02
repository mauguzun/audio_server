<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.js">
</script>

<div class="checkout-form">

	<div class="row" style="margin-top: 20px; margin-bottom: 20px;">
	
	<h3><?= isset($header)?$header : NULL ;?></h3>
		<table id="example" class="table " style="width:100%">
			<thead>
				<tr>
					<?
					foreach($headers as $header):?>
					<th>
						<?
						if($header != strip_tags($header)) :?>
						<?= $header ?>
						<?
						else :?>

						<?= $header ?>
						<? endif;?>
					</th>
					<? endforeach ;?>
				</tr>
			</thead>

		</table>




	</div>
</div>





<script>
	$('#example').DataTable(
		{
			"ajax": '<?= $url ?>',
			"order": [[ 0, 'desc' ]],
			"columnDefs": [ {"visible": false, "targets": 0}],
			"lengthMenu": [ 10, 20 , 50,  100 ],
			"scrollX": true,
			"initComplete": function(settings, json)
			{
				initMap();
			}
		} );
</script>


