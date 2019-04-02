

<div class="checkout-form" style="padding-top: 10px;">


	<div class="row">
	   <div class="heading-block margin-bottom-20" style="text-align: center">
        
          <h4><?= lang('find_other_point') ?></h4>
        </div>
		
		<div class="col-sm-12" style="margin-bottom: 20px">
		
			<select  onchange="location.replace('<?= base_url()?>point/'+ this.value) "    name="city_id" class="selectpicker" data-live-search="1">
				<? foreach($points as $value) :?>
					<option   <?= $value['id'] == $point['id'] ? 'selected' : null ;?>   value="<?= $value['id'] ?> "><?= $value['title']?></option>
				<? endforeach ;?>
			</select>

		</div>
	</div>
</div>

