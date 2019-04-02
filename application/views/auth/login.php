
<div class="checkout-form">

	<div class="row">

		<div class="col-sm-12">

			<h1><?php echo lang('login_heading');?></h1>
			<p><?php echo lang('login_subheading');?></p>

		</div>
		<div class="col-sm-12">

			<?php echo $message;?>

		</div>






		<?php echo form_open("auth/login");?>

		<div class="col-sm-12">
			<?php echo lang('login_identity_label', 'identity');?>
		</div>
		
		<div class="col-sm-12">
			<?php echo form_input($identity);?>
		</div>

		<div class="col-sm-12">
			<?php echo lang('login_password_label', 'password');?>

		</div>
		
		<div class="col-sm-12">
			<?php echo form_input($password);?>
		</div>
		<!--<div class="col-sm-12">
		<?php echo lang('login_remember_label', 'remember');?></div-->


		<!--<div class="col-sm-12">
		<?php echo form_checkbox('remember', '1', FALSE, 'id="remember"');?></div>-->


		<div class="col-sm-12">
		<br />
		<br />
		<br />
			<?php echo form_submit('submit', lang('login_submit_btn'));?>
		</div>

		<?php echo form_close();?>
		<div class="col-sm-12">
			<a href="forgot_password"><?php echo lang('login_forgot_password');?></a></div>

	</div>

</div>