
<div id="<?= $name ?>" >
	<h1><?= $name ?></h1>
	<div class="form-group"   >

		<input  ref="file"  @change="upload()"  type="file"   />
		<input  name="<?= $name ?>" type="text"  ref='filename'   value="<?=  (isset($file)) ? $file : null ?>"/>

	</div>


	<div class="form-group" v-if="audio"  >
		<audio controls>
			<source v-bind:src="'<?= base_url()?>uploads/' + audio" type="audio/ogg">
			<source v-bind:src="'<?= base_url()?>uploads/' +  audio" type="audio/mpeg">
		</audio>
	</div>


	<div class="form-group"   v-if="img" >
		<img style="width: 200px;" v-bind:src="'<?= base_url()?>uploads/' + img" />
	</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/vue@2.6.2/dist/vue.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.15.2/axios.js"></script>
<script>

	new Vue(
		{
			el: "#<?= $name ?>",
			data:
			{
				img:null,
				audio:null,

			},
			methods:
			{
				upload()
				{

					let fileToUpload = this.$refs.file.files[0];
					let formData = new FormData();
					formData.append('file', fileToUpload);
					axios.post('<?= $url ?>', formData,
						{
							headers:
							{
								'Content-Type': 'multipart/form-data'
							}
						})
					.then(e=>
						{
							console.log(e.data.url);

							if(e.data.error == false)
							{
								this.$refs.filename.value = e.data.file;
								if (e.data.ext == '.mp3')
								{
									this.audio = e.data.file
									console.log(this.audio);
									this.img = null;
								}else
								{
									this.img = e.data.file
									this.audio = null;
								}
							}

						})
				}
			},

			created()
			{
				let temp = '<?=$file ?>';
				if(temp.trim() != '')
				{
					if(temp.indexOf("mp3")> -1)
					{
						this.audio = temp;
					}else
					{
						this.img = temp;
					}
				}
			}
		});

</script>

