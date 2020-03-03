<!doctype html>
<html lang="en">

<head>
	<meta charset='utf-8' />
	<title>
		MV Site Suitability Tool
	</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
	        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">


  <script>
          window.Laravel = <?php echo json_encode([
              'csrfToken' => csrf_token(),
          ]); ?>
		</script>
		<meta name="csrf-token" content="{{ csrf_token() }}">

	<style>
		html {
			height: 100%
		}
		body {
			height: 100%;
			margin: 0;
			padding: 0;
		}

		#app.container { max-width: 95%; }

	</style>

</head>

<body>
	<div id="app" class="container">
		<div class="row">
			<div class="col-md-12">
				<h1>Martha's Vineyard - Site Suitability Tool</h1>
			</div>
			<div class="col-md-12">
				<h4>Site Comparison</h4>
			</div>
			
		</div>
		@include('test.partials.filters')
		@include('test.partials.results')
	</div>
	<style>
		body {
			    background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
		}
		.map_scores { width: 100%;}
		.map_scores thead th:nth-child(1) {
			width: 70%;
		}

		.map_scores thead th:nth-child(2) {
			width: 30%;
		}
		.score_titles {
			font-weight: bold;
			border-bottom: 1px solid #000;
		}
		.parcel_row {
	border-bottom: 1px dotted #000;
}
		</style>
	 <script src="https://unpkg.com/leaflet@1.3.4/dist/leaflet.js"
   integrity="sha512-nMMmRyTVoLYqjP9hrbed9S+FzjZHW5gY1TWCHA5ckwXZBadntCNs8kEqAWdrb9O7rxbCaA4lKTIWjDXZxflOcA=="
   crossorigin=""></script>
	<script src='https://api.mapbox.com/mapbox-gl-js/v0.47.0/mapbox-gl.js'></script>
	<link href='https://api.mapbox.com/mapbox-gl-js/v0.47.0/mapbox-gl.css' rel='stylesheet' />

	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/vue-mapbox@latest/dist/vue-mapbox.min.js"></script>
	<script src="/js/app.js"></script>

</body>

</html>