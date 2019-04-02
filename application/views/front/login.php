    <!-- Tesm Text -->
<section class="lookin-pro" id="subscribe">
	<div class="container">



		<!-- Heading -->
		<div   class="heading-block white margin-bottom-20">
			<a data-toggle="tooltip" title="<?= lang('ask_password')?>"  href="mailto:<?= EMAIL ?>"><h4><?= lang('ask_password')?></h4></a>
			
			<h3><?= lang('login_heading')?></h3>
			<?= $text ?>
			<hr>

			<?
			if($text != null ) :?>
			<div class="alert alert-info alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true"><i class="ion-android-close"></i> </span></button>
				<?= $text ?>
			</div>
			<? endif; ?>
		</div>
	
		

		<form method="post">
			<div class="intro-small col-md-8 center-auto margin-bottom-0">

				<input  data-toggle="tooltip" title="<?= lang('password')?>" required  minlength="3"  
				placeholder="<?= lang('password')?>" class="sub mat-shadow" name="password" type="text"/>


			</div>

			<div class="text-center">

				<input type="submit" class="btn mat-shadow" value="<?= lang('login_heading')?>" />

			</div>
		</form>

		

	</div>



</section>

<script>
	$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>


<style>
	#vue-page
	{


/*		background: url(https://natgeo.imgix.net/factsheets/thumbnails/cannes-france.adapt.1900.1.jpg?auto=compress,format&w=1024&h=560&fit=crop) no-repeat;*/
		background: url(https://spotlight.it-notes.ru/wp-content/uploads/2018/01/ace9d9adb6e25a9130663de895845e57.jpg) no-repeat;
		background-size: cover;
	}
	.fly-nac-icon .bar
	{
		background-color: white;
	}
	.shadow
	{
		text-shadow: 0px 4px 3px rgba(0,0,0,0.4), 0px 8px 13px rgba(0,0,0,0.1), 0px 18px 23px rgba(0,0,0,0.1);
	}

	.sub
	{
		background-color: rgba(0,0,0,0.5) !important;
		height: 45px;
		font-size: 15px;
		border: none;
		color: #fff;
		width: 100%;
		padding: 0 25px;
		text-align: center;
		display: block;
		margin-bottom: 10px;
	}
</style>