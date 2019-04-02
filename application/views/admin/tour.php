
<div class="container">

	<div class="row" style="<?= isset($edit) ? ' ' : 'display:none ' ?>" id="tour_div">

		<form method="post" id="tour">

			<?
			if(isset($edit)): ?>
			<input id="id" type="hidden" value="<?= isset($edit) ? $edit->id : null ?>" readonly class="form-control"/>

			<? endif; ?>

			<?
			foreach($langs as $item) :?>
			<label for="">title <?= $item ?></label>
			<input value="<?= (isset($edit) &&  isset($edit->translate[$item])  ) ? $edit->translate[$item]->title : null ?>" required type="text"
			id="title_<?= $item ?>"
			placeholder="title <?= $item ?>" class="form-control"/>
			<? endforeach ?>

			<? $data = ['distance', 'price', 'per_min', 'period'];
			foreach($data as $item) :?>
			<label for=""><?= $item ?></label>
			<input value="<?= (isset($edit)) ? $edit->$item : null ?>" required type="text" id="<?= $item ?>"
			placeholder="<?= $item ?>" class="form-control"/>
			<? endforeach ?>


			<div class="form-group">
				<label>Upload Image</label>
				<div class="input-group">
					<span class="input-group-btn">
						<span class="btn btn-default btn-file">
							Browse… <input type="file" class="img_input">
						</span>
					</span>
					<input type="text" class="form-control" readonly>
				</div>
				<img src="<?= (isset($edit)) ? $edit->img : null ?>" class="img_preview"/>
				<textarea class="hidden" id="img"><?=  (isset($edit)) ? $edit->img : null ?></textarea>
			</div>

			<?
			foreach($langs as $item) :?>
			<label for="">description <?= $item ?></label>
			<textarea class="form-control" placeholder="description <?= $item ?>"
                          id="desc_<?= $item ?>"><?=  (isset($edit) && isset($edit->translate[$item])) ? $edit->translate[$item]->desc : null ?></textarea>

			<? endforeach ?>


			<input type="submit" class="btn btn-block btn-info" value="Save Tour"/>
		</form>
	</div>


	<div class="modal fade bd-example-modal-lg" id="marker_div" tabindex="-1" role="dialog"
         aria-labelledby="myLargeModalLabel"
         aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-body">
					<h1>Point</h1>
					<form method="post" id="point">
						<?
						foreach($langs as $item) :?>
						<label>  title <?= $item?> </label>
						<input type="text" name="title_<?= $item ?>" placeholder="title <?= $item ?>" class="form-control"/>
						<? endforeach ?>

						<?
						foreach($langs as $value) :?>

						<label>Small Description <?= $value?> </label>
						<textarea class="form-control" name="desc_<?= $value?>">Small Description <?= $value?> </textarea>
						<? endforeach ;?>




						<div class="form-group">
							<label>Upload Image</label>
							<div class="input-group">
								<span class="input-group-btn">
									<span class="btn btn-default btn-file">
										Browse… <input type="file" class="img_input">
									</span>
								</span>
								<input type="text" class="form-control" readonly>
							</div>
							<img class="img_preview"/>
							<textarea class="hidden" name="img"></textarea>
						</div>


						<input type="submit" class="btn btn-info" value="Save"/>
					</form>
					<br><br>
					<input type="submit" id='delete_marker' class="btn btn-danger" value="Delete"/>
				</div>
			</div>
		</div>
	</div>


	<div class="row">
		<br>
		<button   id="save_button" class="btn btn-block btn-warning" onclick="save()">Open  Tour Form </button>
		<br><br>
	</div>
	<div class="row">
		<div class="col-sm">
			<div id="map" style="height: 80vh;"></div>
		</div>
	</div>
	<div class="row">
		<br>
		<br>
		<br>
		<input type="text" class="form-control" placeholder="add marker" id="newMarker" onchange="addMarker()"/>
		<br>
		<br>
	</div>

</div>


<script type="text/javascript"
            src="https://maps.google.com/maps/api/js?sensor=false&libraries=drawing&key=AIzaSyAX50gEvAyz9A6Sh3BMvC9eOblbLLZOses"></script>

<script type="text/javascript">
	var drawingManager;
	var selectedShape;
	var colors = ['#1E90FF', '#FF1493', '#32CD32', '#FF8C00', '#4B0082'];
	var selectedColor;
	var colorButtons =
	{
	};
	var map;

	let markersInfo = [];
	var currentID;
	let saveData = null;


	function addMarker(e)
	{

		let results = $('#newMarker').val().split(",")

		if (results.length > 1)
		{
			// make marker
			currentID = Date.now();

			var marker = new google.maps.Marker(
				{
					position:
					{
						lat: Number.parseFloat(results[0]), lng: Number.parseFloat(results[1])
					},
					map: map,
					draggable: true,
					id: currentID,

				});
			markersInfo.push({id: currentID, marker: marker, info: {}})


			//setSelection(marker);
			// set
			subscribe(marker);
		}

	}

	function save()
	{

		/*if (!saveData)
		{
			alert("make some path ,pls ");
			return;
		}*/
		$('#tour_div').slideDown();
		$('#save_button').slideUp();

	}


	$('#tour').submit(function ()
		{


			let points = [];

			if (markersInfo.length > 0)
			{
				for (var i = 0; markersInfo[i]; i++)
				{
					let row =
					{
						lat: markersInfo[i].marker.position.lat(),
						lng: markersInfo[i].marker.position.lng(),
						img: markersInfo[i].info.img,
						translate:
						{
							en:
							{
								title: markersInfo[i].info.title_en,
								desc: markersInfo[i].info.desc_en
							},
							fr:
							{
								title: markersInfo[i].info.title_fr,
								desc: markersInfo[i].info.desc_fr,
							}
						}
					}


					points.push(row);
				}
			}

			let tour =
			{
				distance: $('#distance').val(),
				img: $('#img').val(),
				path: saveData,
				price: $('#price').val(),
				per_min: $('#per_min').val(),
				period: $('#period').val(),
				translate:{
					
				},
				/*{
					en:
					{
						title: $('#title_en').val(),
						desc: $('#desc_en').val().trim()
					},
					fr:
					{
						title: $('#title_fr').val(),
						desc: $('#desc_fr').val().trim()
					}
				},*/
				points: points,


			}
			
			<? foreach($langs as $item) :?>
			
				var currentLang  = "<?= $item ?>";
			
				tour.translate[currentLang] = {
						title: $('#title_'+currentLang).val(),
						desc: $('#desc_'+currentLang).val().trim()
				};
			<? endforeach; ?>
			
			

			if ($('#id'))
			{
				tour.id = $('#id').val();
			}
			$.post("<?= base_url()?>/admin/tours/insert",
				{
					json: JSON.stringify(tour)
				}, function (e)
				{
					
					window.location = "<?= base_url()?>/admin/tours"
				});


			return false;
		})


	$('#delete_marker').click(function ()
		{
			getCurrentRow().marker.setMap(null);
			markersInfo.splice(markersInfo.findIndex(e => e.id === currentID), 1);
			$('#marker_div').modal('toggle')

		})


	$("#point").submit(function ()
		{
			let data = objectifyForm($("#point").serializeArray());

			if (getCurrentRow())
			{
				getCurrentRow().info = data;
			} else
			{
				alert("can`t save")
			}

			$('#marker_div').modal('toggle')
			return false;
		})


	function setPolyLineLength(arg)
	{

		let dirty = google.maps.geometry.spherical.computeLength(arg) / 1000;
		dirty = Number.parseFloat(dirty)
		let clear = dirty.toFixed(2)

		$('#distance').val(clear);

	}


	function setData(arg)
	{


		if (arg != null)
		{
			for (let item in arg)
			{
				if (item == 'img')
				{
					$('#point img').attr('src', arg[item])
				}
				$(`[name=${item}]`).val(arg[item]);
			}


		} else
		{
			$('#point').find("input[type=text], textarea").val("");
			$('#point img').attr('src', '')
		}
	}


	function objectifyForm(formArray)
	{
		//serialize data function

		var returnArray =
		{
		};
		for (var i = 0; i < formArray.length; i++)
		{
			returnArray[formArray[i]['name']] = formArray[i]['value'];
		}
		return returnArray;
	}

	function clearSelection()
	{
		if (selectedShape)
		{
			if (selectedShape.type !== 'marker')
			{
				selectedShape.setEditable(false);
			}

			selectedShape = null;
		}
	}

	function setSelection(shape)
	{
		if (shape.type !== 'marker')
		{
			clearSelection();
			shape.setEditable(true);
			selectColor(shape.get('fillColor') || shape.get('strokeColor'));
		}
		else
		{
			selectedShape = shape;

			setData();
			$('#marker_div').modal()

		}

	}


	function deleteSelectedShape()
	{

		if (selectedShape)
		{

			if (selectedShape.id !== undefined)
			{
				markersInfo.splice(markersInfo.findIndex(e => e.id === selectedShape.id), 1);
				console.log(markersInfo);
			}
			selectedShape.setMap(null);
		}
	}

	function selectColor(color)
	{
		// selectedColor = color;
		// for (var i = 0; i < colors.length; ++i) {
		//     var currColor = colors[i];
		//     colorButtons[currColor].style.border = currColor == color ? '2px solid #789' : '2px solid #fff';
		// }

		// Retrieves the current options from the drawing manager and replaces the
		// stroke or fill color as appropriate.
		var polylineOptions = drawingManager.get('polylineOptions');
		polylineOptions.strokeColor = color;
		drawingManager.set('polylineOptions', polylineOptions);

		var rectangleOptions = drawingManager.get('rectangleOptions');
		rectangleOptions.fillColor = color;
		drawingManager.set('rectangleOptions', rectangleOptions);

		var circleOptions = drawingManager.get('circleOptions');
		circleOptions.fillColor = color;
		drawingManager.set('circleOptions', circleOptions);

		var polygonOptions = drawingManager.get('polygonOptions');
		polygonOptions.fillColor = color;
		drawingManager.set('polygonOptions', polygonOptions);
	}

	function setSelectedShapeColor(color)
	{
		if (selectedShape)
		{
			if (selectedShape.type == google.maps.drawing.OverlayType.POLYLINE)
			{
				selectedShape.set('strokeColor', color);
			} else
			{
				selectedShape.set('fillColor', color);
			}
		}
	}

	function makeColorButton(color)
	{
		var button = document.createElement('span');
		button.className = 'color-button';
		button.style.backgroundColor = color;
		google.maps.event.addDomListener(button, 'click', function ()
			{
				selectColor(color);
				setSelectedShapeColor(color);
			});

		return button;
	}


	function initialize()
	{
		map = new google.maps.Map(document.getElementById('map'),
			{
				zoom: 12,
				center: new google.maps.LatLng(43.7031691, 7.1827772),
				// mapTypeId: google.maps.MapTypeId.SATELLITE,
				disableDefaultUI: true,
				zoomControl: true
			});

		var polyOptions =
		{
			strokeWeight: 2,
			fillOpacity: 0,
			editable: true,
			draggable: true
		};
		// Creates a drawing manager attached to the map that allows the user to draw
		// markers, lines, and shapes.
		drawingManager = new google.maps.drawing.DrawingManager(
			{
				markerOptions:
				{
					draggable: true
				},
				drawingControlOptions:
				{
					position: google.maps.ControlPosition.TOP_CENTER,
					drawingModes: ['marker', 'polyline',]
				},
				polylineOptions:
				{
					editable: true,
					draggable: true
				},
				rectangleOptions: polyOptions,
				circleOptions: polyOptions,
				polygonOptions: polyOptions,
				map: map
			});

		google.maps.event.addListener(drawingManager, 'overlaycomplete', function (e)
			{
				var newShape = e.overlay;

				newShape.type = e.type;
				console.log(newShape)


				if (e.type !== google.maps.drawing.OverlayType.MARKER)
				{
					// Switch back to non-drawing mode after drawing a shape.
					drawingManager.setDrawingMode(null);


					// Add an event listener that selects the newly-drawn shape when the user
					// mouses down on it.
					google.maps.event.addListener(newShape, 'click', function (e)
						{
							if (e.vertex !== undefined)
							{

								if (newShape.type === google.maps.drawing.OverlayType.POLYLINE)
								{
									var path = newShape.getPath();

									path.removeAt(e.vertex);
									if (path.length < 2)
									{
										newShape.setMap(null);
									}


								}
							}
							setSelection(newShape);
						});

					setSelection(newShape);
					getPath(newShape);

					google.maps.event.addListener(newShape, "dragend", () => getPath(newShape));
					google.maps.event.addListener(newShape.getPath(), "insert_at", () => getPath(newShape));
					google.maps.event.addListener(newShape.getPath(), "remove_at", () => getPath(newShape));
					google.maps.event.addListener(newShape.getPath(), "set_at", () => getPath(newShape));

				}
				else
				{

					currentID = Date.now();
					newShape.setValues({id: currentID});
					markersInfo.push({id: currentID, marker: newShape, info: {}})


					setSelection(newShape);
					// set
					subscribe(newShape);
				}

			});

		// Clear the current selection when the drawing mode is changed, or when the
		// map is clicked.
		google.maps.event.addListener(drawingManager, 'drawingmode_changed', clearSelection);
		google.maps.event.addListener(map, 'click', clearSelection);




		<? if (isset($edit)) : ?>
		restore();
		<? endif;?>
		//  buildColorPalette();
	}

	function subscribe(newShape)
	{
		google.maps.event.addListener(newShape, 'click', function (e)
			{

				currentID = newShape.id;
				if (getCurrentRow())
				{
					$('#marker_div').modal()
					setData(getCurrentRow().info);
				}

				// setSelection(newShape);
			});


		google.maps.event.addListener(newShape, "dragend", function (event)
			{

				currentID = newShape.id;
				if (getCurrentRow())
				{
					$('#marker_div').modal()
					setData(getCurrentRow().info)
					getCurrentRow.marker = newShape;
				}

			})
	}


	google.maps.event.addDomListener(window, 'load', initialize);

	function getCurrentRow()
	{
		let row = markersInfo.filter(x => x.id == currentID);
		return (row.length == 1) ? row[0] : null;
	}


	function restore()
	{


		let pointsArray = null;

		<? if (isset($edit)) :?>
		saveData = <?= $edit->path ; ?>;
		pointsArray = <?= $edit->getPointsJson() ?>;


		<? endif;?>

		for (i in pointsArray)
		{


			console.log(i);

			var marker = new google.maps.Marker(
				{
					position:
					{
						lat:  parseFloat( pointsArray[i].lat), lng:parseFloat( pointsArray[i].lng)
					},
					map: map,
					draggable: true,
					id: i,
					title: pointsArray[i].translate.en.title
				});

			markersInfo.push(
				{
					id: i,
					marker: marker,
					info:
					{
						title_en: pointsArray[i].translate.en.title,
						title_fr: pointsArray[i].translate.fr.title,
						desc_en: pointsArray[i].translate.en.desc,
						desc_fr: pointsArray[i].translate.fr.desc,
						img: pointsArray[i].img,

					}
				})

			subscribe(marker);
		}



		console.log(typeof saveData);

		var flightPath = new google.maps.Polyline(
			{
				path: saveData,
				geodesic: true,
				editable: true,
				strokeColor: '#FF0000',
				strokeOpacity: 1.0,
				strokeWeight: 2
			});

		flightPath.setMap(map);


		google.maps.event.addListener(flightPath, "dragend", () => getPath(flightPath));
		google.maps.event.addListener(flightPath.getPath(), "insert_at", () => getPath(flightPath));
		google.maps.event.addListener(flightPath.getPath(), "remove_at", () => getPath(flightPath));
		google.maps.event.addListener(flightPath.getPath(), "set_at", () => getPath(flightPath));

		//  delete vortex

		google.maps.event.addListener(flightPath, 'rightclick', function(e)
			{
				// Check if click was on a vertex control point
				if (e.vertex == undefined)
				{
					return;
				}
				else
				{
					if(confirm("Are you sure to delete this vertex???"))
					flightPath.getPath().removeAt(e.vertex) ;
					
				}

			});
	}

	function getPath(newShape)
	{

		setPolyLineLength(newShape.getPath().getArray())
		saveData = [];
		for (var i = 0; i < newShape.getPath().getArray().length; i++)
		{
			saveData.push(
				{
					lat: newShape.getPath().getArray()[i].lat(),
					lng: newShape.getPath().getArray()[i].lng()
				})
		}
	}

	$(document).on('change', '.btn-file :file', function ()
		{
			var input = $(this),
			label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
			input.trigger('fileselect', [label]);
		});

	$('.btn-file :file').on('fileselect', function (event, label)
		{

			var input = $(this).parents('.input-group').find(':text'),
			log = label;

			if (input.length)
			{
				input.val(log);
			} else
			{
				if (log) alert(log);
			}

		});

	function readURL(input, parent)
	{


		console.log();
		if (input.files && input.files[0])
		{
			var reader = new FileReader();

			reader.onload = function (e)
			{
				parent.find("img").attr('src', e.target.result);
				parent.find("textarea").val(e.target.result);
			}
			reader.readAsDataURL(input.files[0]);
		}
	}

	$(".img_input").change(function ()
		{
			let div = $(this).parent().parent().parent().parent();
			readURL(this, div);
		});

</script>
