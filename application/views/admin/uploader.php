


<div class="uploader" id="<?= $upload_id?>">


	<input width="1px" style="opacity: 0" oninvalid="this.setCustomValidity('Please upload image')"  value="<?=  $show_me  ?? NULL; ?>" required="require"   name="Img" type="text"   id="Img"/>

	<div id="error">

	</div>
	<div id="drag-and-drop-zone" class="uploader">
		<div>
			 Drop Files Here 
		</div>

		<div class="browser">
			<label>
				<span>
					 Click to open the file Browser

				</span>
				<input type="file" id="file" 
				multiple="multiple" title='Click to add Files'>
			</label>
		</div>
	</div>
	
	<br />
	<br />
	<br />
	<br />
	<br />
	<!-- /D&D Markup -->

	<div id="console">
	</div>

	<div id="loglist">
	</div>


	<div id="filelist">
		
		<?=  isset($show_me)? img_div($show_me) :  null ; ?>
		
	</div>

</div>



<script>


	function setAction()
	{
		$('.edit i').on('click',function()
			{

				const action = $(this).attr('class')
				const url = $(this).parent().attr('data-img-url');
				const parent = $(this).parent();
				if(action.includes('trash')  )
				{
/*
					$.get("<?= base_url()?>"+'admin/product/delete?url=/'+ url ,function(e)
						{
							if(e.error === undefined)
							{
								parent.fadeOut();
							}
						})*/
				}else
				{

				}
				
				return false;
			})
	}

	setAction();

	$("#drag-and-drop-zone").dmUploader
	(
		{

			url:'<?= $upload_url ?>' ,
			// only debug mode
			onInit: function()
			{
				console.log('can upload')
			},
			onNewFile: function(id,file)
			{
				console.log('start upload')
				$('#<?=$upload_id?> #error').html('');
				//$("#<?=$upload_id?> #loglist").empty();
				$('#<?=$upload_id?> #loglist').html("<progress id='"+id+"_file' value='1' max='100'></progress> " );
			},


			onUploadProgress: function(id, percent)
			{
				$("#"+id+'_file').attr('value',percent);
				$("#"+id+'_file').attr('title',percent);

			},

			onUploadSuccess: function(id, data)
			{
				let result = JSON.parse(data);
				
				if(result.error !== undefined)
				{
					$('#<?=$upload_id?> #error').append(result.error)
				}
				else
				{
					
					$('#Img').val(result.upload_data.file_name)
					$('#<?=$upload_id?> #filelist').empty().append(result.upload_data.html);
					setAction();
				}
			},
			onUploadError: function(id, message)
			{
				console.log(message);
				alert('Error trying to upload #' + id + ': ' + message);
			}

		});
</script>
<style>

	.uploader
	{
		border: 1px dotted silver;
		width: 100%;
		color: #92AAB0;
		text-align: center;
		vertical-align: middle;
		padding: 30px 0px;
		margin-bottom: 10px;

		cursor: default;

		-webkit-touch-callout: none;
		-webkit-user-select: none;
		-khtml-user-select: none;
		-moz-user-select: none;
		-ms-user-select: none;
		user-select: none;
	}

	.uploader div.or
	{
		font-size: 50%;
		font-weight: bold;
		color: #C0C0C0;
		padding: 10px;
	}

	.uploader div.browser label
	{
		background-color: #f0f0f0;
		padding: 5px 15px;
		color: #676;
		padding: 6px 0px;
		font-size: 40%;
		font-weight: bold;
		cursor: pointer;
		border-radius: 2px;
		position: relative;
		overflow: hidden;
		display: block;
		width: 300px;
		margin: 20px auto 0px auto;

		box-shadow: 3px 3px 3px #f0f0f0;
	}

	.uploader div.browser span
	{
		cursor: pointer;
	}


	.uploader div.browser input
	{
		position: absolute;
		top: 0;
		right: 0;
		margin: 0;
		border: solid transparent;
		border-width: 0 0 100px 200px;
		opacity: .0;
		filter: alpha(opacity= 0);
		-o-transform: translate(250px,-50px) scale(1);
		-moz-transform: translate(-300px,0) scale(4);
		direction: ltr;
		cursor: pointer;
	}


	#loglist,#filelist
	{
		list-style: none  !important;
		text-align: center;
	}
	#loglist progress
	{
		display: block;
		width: 90%;
		margin-left: 5%;
		color: white;
		height: 10px;
	}
	#error
	{
		color: red;
		height: 50px;
		text-align: center;;
	}

	i[data-circle]
	{
		cursor: pointer;
	}

	#filelist
	{
		padding: 15px;
	}
	#filelist div
	{
		width: 100px;
		display: inline-block;
		height: 100px;
		margin: 5px;

	}
	#filelist div img
	{
		width: 100px;
		height: 100px;
		object-fit: cover;
	}
	#filelist div i
	{
		cursor: pointer;
		padding-left: 5px;
	}
</style>
