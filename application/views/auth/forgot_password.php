

<div class="checkout-form">

	<div class="row">

		<div class="col-sm-12">

			<h1><?php echo lang('forgot_password_heading');?></h1>
			<p><?php echo sprintf(lang('forgot_password_subheading'), $identity_label);?></p>
		</div>

		<div class="col-sm-12"><?php echo $message;?></div>

		<?php echo form_open("auth/forgot_password");?>

		<div class="col-sm-12">
			<label for="identity"><?php echo (($type == 'email') ? sprintf(lang('forgot_password_email_label'), $identity_label) : sprintf(lang('forgot_password_identity_label'), $identity_label));?></label> <br />
		</div>
		<div class="col-sm-12">

			<?php echo form_input($identity);?>
		</div>

		<div class="col-sm-12">		<br />
			<br />
			<br />
			<br /><?php echo form_submit('submit', lang('forgot_password_submit_btn'));?></div>

		<?php echo form_close();?>
	</div>
</div>