
<div class="checkout-form">

	<div class="row">

		<div class="col-sm-12">
			<h1><?php echo lang('change_password_heading');?></h1>
		</div>

		<div class="col-sm-12">
			<?php echo $message;?>

		</div>

		<?php echo form_open("auth/change_password");?>

		<div class="col-sm-12">
			<?php echo lang('change_password_old_password_label', 'old_password');?> </div>

		<div class="col-sm-12">
			<?php echo form_input($old_password);?>
		</div>


		<div class="col-sm-12">
			<label for="new_password"><?php echo sprintf(lang('change_password_new_password_label'), $min_password_length);?></label></div>
		<div class="col-sm-12"><?php echo form_input($new_password);?>
		</div>

		<div class="col-sm-12">
			<?php echo lang('change_password_new_password_confirm_label', 'new_password_confirm');?></div>
		<div class="col-sm-12"><?php echo form_input($new_password_confirm);?>
		</div>
  
		<div class="col-sm-12">
			<?php echo form_input($user_id);?></div>
		<div class="col-sm-12"><?php echo form_submit('submit', lang('change_password_submit_btn'));?></div>

		<?php echo form_close();?>
	</div></div>
