

<div class="checkout-form">

<div class="row">

	<div class="col-sm-12">
		<h1><?php echo lang('reset_password_heading');?></h1>
	</div>

	<div class="col-sm-12">
		<?php echo $message;?>
	</div>

	<?php echo form_open('auth/reset_password/' . $code);?>

	<div class="col-sm-12">
		<label for="new_password"><?php echo sprintf(lang('reset_password_new_password_label'), $min_password_length);?></label></div><div class="col-sm-12">
		<?php echo form_input($new_password);?>
	</div>

	<div class="col-sm-12">
		<?php echo lang('reset_password_new_password_confirm_label', 'new_password_confirm');?></div><div class="col-sm-12">
		<?php echo form_input($new_password_confirm);?>
	</div>

	<?php echo form_input($user_id);?>
	<?php echo form_hidden($csrf); ?>

	<div class="col-sm-12"><br><br><br><?php echo form_submit('submit', lang('reset_password_submit_btn'));?></div>

	<?php echo form_close();?>
</div>

</div>