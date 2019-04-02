<div class="blog-single-post">

	<!-- Post Img -->
	

		<!-- Heading -->

	<h4  style="text-align: center;margin-top: 35px;margin-bottom: 35px;" ><?= $title ?></h4>

		<table class="table table-responce">
			<tbody>
				<? foreach($data as $key=>$value):?>
				<tr>
					<td><?= $key ?></td>
					<td><strong><?= $value ?></strong></td>
				</tr>
				<? endforeach;?>
			</tbody>
		</table>
	
	<hr class="margin-top-80 margin-bottom-80">

</div>