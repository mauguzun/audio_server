
<script src="https://maps.googleapis.com/maps/api/js?key=<?= GOOGLE ?>&libraries=places&callback"
       ></script>


<script src="https://cdn.jsdelivr.net/npm/vue"></script>




<div class="checkout-form"   id="vue_page_map" style="padding-top: 20px;" >

	<div v-show="display" ref="overlay" @click="startPlay"   style=" cursor:pointer;  background: rgba(0,0,0,0.9);position: fixed;top:0;bottom: 0;left: 0;right: 0;z-index: 9999">

		<h1 style="color:white;text-align: center;margin-top: 20vh;">{{infoText}}</h1>
	</div>

	<div class="container">
		<div class="project-detail" class="alert alert-danger alert-dismissible"  v-if="extraPoint != null " >

			<ul>
				<!-- Comments -->
				<li class="media" style="cursor: pointer"  @click="pressExtra(extraPoint.id)" >
					<div class="media-left">  <img
						v-bind:src="extraPoint.img" style="width: 50px;height:50px;object-fit:cover;"
						alt="">  </div>
					<div class="media-body padding-left-20">
						<p>{{ extraPoint.title }}</p>
					</div>
				</li>
			</ul>

		</div>
		<!-- News Post -->
		<div class="project-detail" v-if="activePoint != null" >


			<div class="row margin-bottom-30">
				<div class="col-md-8">

					<!-- Heading -->
					<div class="heading-block margin-bottom-30">
						<h4>{{ activePoint.title }}</h4>
						<h2>{{ activePoint.distance.toFixed(2) * 1000 }} m</h2>
						<a @click="playerClear" href="#"><i class="fa fa-times"></i></a>
					</div>

					<p>{{ activePoint.text }}</p>
					<a v-bind:href="'<?= base_url()?>' + activePoint.id"></a>
					<br>
					<audio ref="main_player" autoplay controls>
						<source v-bind:src="activePoint.mp3" type="audio/ogg">
						<source v-bind:src="activePoint.mp3" type="audio/mpeg">
					</audio>

				</div>
				<!-- Port Img -->
				<div class="col-md-4">

					<img
					style="width: 100%"
					v-bind:src="activePoint.img"
					alt="Generic placeholder image"
					/>
				</div>
			</div>
		</div>
		<!----->
		<div class="comments"  v-if="feautrePoints != null && feautrePoints.length > 0" >
			<h4 class="title-com margin-bottom-100">Feature points</h4>
			<ul v-for="(item, index) in feautrePoints" >

				<!-- Comments -->
				<li class="media"  @click="pressExtra(item.id)" >
					<div class="media-left">  <img
						v-bind:src="item.img" style="width: 50px;height:50px;object-fit:cover;"
						alt="">  </div>
					<div class="media-body padding-left-20">
						<p>{{ item.title }}</p>
						<p>{{ item.distance.toFixed(2) * 1000 }} m </p>
					</div>
				</li>



			</ul>
		</div>
		<!---->

		<div class="row"   id="gmap"  style="height:400px"  >
		</div>
	</div>

</div>

<script>
	let x = new Vue(
		{
			el: "#vue_page_map",
			data:
			{
				display:true,
				infoText:"<?= lang('loading')?>",

				mapOptions:
				{
					map: null,
					location: null,
					markers: null,
					circle:null,
				},

				timer: null,
				timerOptions:
				{
					inetral: 7000
				},

				pointsOptions:
				{
					pointDistance: 0.09,
					samePlace: 0.01,
					feautrePointDistance: 0.6
				},


				activePoint: null,
				extraPoint: null,
				feautrePoints: null,

				currentLat: null,
				currentLng: null,
				prevLat: null,
				prevLng: null,
				points: null,
				
			},

			watch:
			{
				display(value)
				{
					if (value == false)
					{
						this.playerClear();
					}
				},
				activePoint(value)
				{
					// active == false
					if (value == null)
					{
						return;
					}
					this.activePoint = value;
					this.points.find(e => e.id == value.id).active = false;

					//http://maps.google.com/mapfiles/ms/icons/blue-dot.png

					//console.log(this.mapOptions.markers.find(x=>x.id == value.id));

                    this.mapOptions.markers.find(e=>e.id == value.id).setIcon( "http://maps.google.com/mapfiles/ms/icons/blue-dot.png" ) ;

					
				

					if(this.feautrePoints != null )
					{
						this.feautrePoints = this.feautrePoints.filter(element=>
							{
								if (element.id != value.id) return element;
							});

						// remove from extra
						if (this.feautrePoints.id == value.id)
						this.feautrePoints = null;

					}

				}
			},

			methods:
			{
				startPlay()
				{
					this.display = false;
					this.timerAction();

					this.mapSetMarkers();
					this.timerStart();
				},
				timerStart()
				{
					this.timerStop();
					const self = this;
					this.timer = setInterval(function()
						{
							self.timerAction();
						}, self.timerOptions.inetral);
				},
				timerStop()
				{
					if (this.timer != null)
					{
						clearInterval(this.timer);
						this.timer = null;
					}
				},
				timerAction()
				{

					this.getCurrentPosition()
					.then(done =>
						{
							if (
								this.prevLat != null &&
								this.currentLat == done.coords.latitude &&
								this.currentLng == done.coords.longitude
							)
							{
								console.log("same place");
							} else
							{

								// save old
								this.prevLat = this.currentLat;
								this.prevLng = this.currentLng;
								// set new
								this.currentLat = done.coords.latitude;
								this.currentLng = done.coords.longitude;
								// show map
								this.mapMyLocation();
								// soirt  points
								this.sortPoints();
							}
						})
					.catch(error =>
						{
							console.log(error);
						})
					.finally(e => {});
				},
				getCurrentPosition()
				{
					if (navigator.geolocation)
					{
						return new Promise((resolve, reject) =>
							navigator.geolocation.getCurrentPosition(resolve, reject,
								{
									enableHighAccuracy: true
								})
						);
					} else
					{
						return new Promise(resolve => resolve({}));
					}
				},

				start()
				{
					if (this.mapOptions.map == null)
					{
						this.makeMap();
					}
				},

				makeMap()
				{
					this.mapLoad();

					$.post("<?= base_url()?>/api/points/",
						{
							'lang':'<?= $lang?>',
							'city':'<?= $cityid?>'
						}).then(e=>
						{

							if(e.action == true)
							{

								if (e.count == 0 )
								{
									this.infoText = "<?= lang('empty')?>";
								}else
								{
									this.points = e.points;
									this.infoText = "<?= lang('loaded')?>";

								}

							}else
							{

							}


						});

				},

				// points sort methods
				sortPoints()
				{
					if (
						this.prevLng != null &&
						this.distanceInKmBetweenEarthCoordinates(
							this.prevLat,
							this.prevLng,
							this.currentLat,
							this.currentLng
						) < this.pointsOptions.samePlace
					)
					{
						///////////////////////////////////////////// sor point ?  yeas pleease /////////////////git
						console.log("we are same place");
						return;
						////////////////////////////////////////////////////////////////////////////////////////////////
					}

					for (let ind in this.points)
					{
						this.points[ind].distance = this.distanceInKmBetweenEarthCoordinates(
							this.currentLat,
							this.currentLng,
							this.points[ind].lat,
							this.points[ind].lng
						);


					}





					let clear = this.points.filter(
						x => x.distance < this.pointsOptions.feautrePointDistance && x.active == true
					)


					clear.sort((a,b)=>
						{
							if (a.distance > b.distance)
							{
								return 1;
							}
							if (a.distance < b.distance)
							{
								return -1;
							}

							return 0;
						})



					if (clear.length > 0)
					{
						if(clear[0].distance  < this.pointsOptions.pointDistance)
						{
							this.play(clear[0])
						}
					}
					this.feautrePoints =  (clear.length > 0) ? clear : null ;


				},
				distanceInKmBetweenEarthCoordinates(lat1, lon1, lat2, lon2)
				{
					var R = 6371; // Radius of the earth in km
					var dLat = this.deg2rad(lat2 - lat1); // deg2rad below
					var dLon = this.deg2rad(lon2 - lon1);
					var a =
					Math.sin(dLat / 2) * Math.sin(dLat / 2) +
					Math.cos(this.deg2rad(lat1)) *
					Math.cos(this.deg2rad(lat2)) *
					Math.sin(dLon / 2) *
					Math.sin(dLon / 2);
					var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
					var d = R * c; // Distance in km
					return d;
				},
				deg2rad(deg)
				{
					    return deg * (Math.PI / 180);

				},

				// map methods
				mapLoad()
				{

					this.mapOptions.map = new google.maps.Map(
						document.getElementById("gmap"),
						{
							center:
							{
								lat: 56.9577312, lng: 24.1832039
							},
							zoom: 17,
							disableDefaultUI: true
						}
					);
				},
				mapMyLocation()
				{
					let point =
					{
						lat: this.currentLat, lng: this.currentLng
					};
					if (this.mapOptions.location == null)
					{
						this.mapOptions.location = new google.maps.Marker(
							{
								map: this.mapOptions.map,
								position: point,
								title: "You are here",
								icon:
								"https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png"
							});
					}
					this.mapOptions.location.setPosition(point);
					this.mapOptions.map.setCenter(point);
					

					this.mapOptions.circle = new google.maps.Circle({
					strokeColor: '#FF0000',
					strokeOpacity: 0.1,
					strokeWeight: 1,
					fillColor: '#FF0000',
					fillOpacity: 0.1,
					map: this.mapOptions.map,
					center: point,
           			radius: this.pointsOptions.pointDistance * 1000 });
				},
				mapSetMarkers()
				{
					this.mapOptions.markers = [];

					let self = this;
					this.points.forEach((element, index, theArray) =>
						{
							theArray[index].lat = parseFloat(theArray[index].lat);
							theArray[index].lng = parseFloat(theArray[index].lng);


							let marker = new google.maps.Marker(
								{
									map: this.mapOptions.map,
									position:
									{
										lat: element.lat, lng: element.lng
									},
									title: element.title,
									id:element.id

								});
							// on click


							google.maps.event.addListener(marker, 'click', function ()
								{
									self.activePoint = null;
									self.playerClear();
									self.play(element);
									self.$refs.main_player.load();

								});








							////

							this.mapOptions.markers.push(marker);
						});
				},

				play(point)
				{
					console.log(point)
					if (
						this.activePoint != null
					)
					{
						// extra +return ;
						this.playExtra(point);
						return;
					}
					// stop pls
					if (this.mainPlayer != null)
					{
						this.playerClear();
					}
					this.activePoint = point;

				},
				playExtra(point)
				{
					if (this.extraPoint != null && this.extraPoint.id == point.id)
					{
						return;
					}

					//
					new Audio('http://soundbible.com/mp3/Air%20Plane%20Ding-SoundBible.com-496729130.mp3').play();

					this.extraPoint = point;
				},
				// click play extra point
				pressExtra(arg)
				{
					//
					let point = this.points.find(e => e.id == arg);
					// clear extra if same
					if (this.extraPoint && this.extraPoint.id == point.id)
					{
						this.extraPoint = null;
					}
					this.playerClear();
					this.play(point);
					this.$refs.main_player.load();
				},
				closeExtra()
				{
					this.extraPoint = null;
				},

				playerClear()
				{



					this.activePoint = null;

					// loop ?
				}
			}

			,mounted()
			{

				this.start()
			}

		});



</script>