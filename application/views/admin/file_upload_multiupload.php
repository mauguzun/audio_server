
<div id="<?= str_replace("[]","",$name) ;?>" >
	<h2><?= str_replace("[]","",$name) ;?></h2>

	<input  ref="file"  @change="upload()"  type="file"     />

	<div class="form-group"   >

		<input  v-for="(item, index) in imgs" :key="index" name="<?= $name ?>"  type="hidden" :value="item"  ref='filename'  />
	</div>




	<div class="form-group"  >

		<a   href=""  v-for="(item, index) in imgs" :key="index+'123'"  style="margin:5px;"  @click.prevent='del(item)'
			:title="index" >
			<img style="width: 100px;height:100px ;object-fit: cover"
			:src="'<?= base_url()?>uploads/' + item"/>

		</a>


	</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/vue@2.6.2/dist/vue.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.15.2/axios.js"></script>
<script>

	new Vue(
		{
			el: "#<?= str_replace("[]","",$name) ;?>",
			data:
			{
				imgs:[],

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


							if(e.data.error == false)
							{
								this.imgs.push(e.data.file)
							}

						})
				},
				del(item)
				{
					var index = this.imgs.indexOf(item);
					if (index !== -1)
					{
						this.imgs.splice(index, 1);
					}
				}

			},


			created()
			{

				this.imgs = <?= json_encode($file) ?>;

				console.log(this.imgs);

			}
		});

</script>

