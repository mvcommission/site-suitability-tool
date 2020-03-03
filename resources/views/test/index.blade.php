<!doctype html>
<html lang="en">

<head>
	<meta charset='utf-8' />
	<title>
		MV Site Suitability Tool
	</title>

	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

		<meta name="csrf-token" content="{{ csrf_token() }}">
	<!--[if lte IE 8]>
			<link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.6.4/leaflet.ie.css" />
		<![endif]-->

	 <link rel="stylesheet" href="/css/app.css" /> 

	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.4/dist/leaflet.css"
   integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA=="
   crossorigin=""/>

</head>

<body>
	<div id="app" class="container">
		<div class="row">
			<div class="col-md-9 mt-3">
				<h1>Martha's Vineyard - Site Suitability Tool <small class="text-muted">(Beta)</small></h1>
				<p><a href="/intro">Introduction &amp; Instructions</a></h3>
			</div>
			<div class="col-md-3 mt-3">
				@include('test.partials.helpers')
			</div>
			<div class="col-md-9">
				<div id="map">
				</div>
			</div>
			<div class="col-md-3">									
				@include('test.partials.sidebar')
			</div>
		</div>
		@include('test.partials.results')
		@include('test.modals.filters')		
		@include('test.modals.comparison')
				@include ('test.modals.factors')
		@include ('test.modals.layers')
		
		@include ('test.modals.legend')

	</div>
	
	 <script src="https://unpkg.com/leaflet@1.3.4/dist/leaflet.js"
   integrity="sha512-nMMmRyTVoLYqjP9hrbed9S+FzjZHW5gY1TWCHA5ckwXZBadntCNs8kEqAWdrb9O7rxbCaA4lKTIWjDXZxflOcA=="
   crossorigin=""></script>
	{{-- <script src='https://api.mapbox.com/mapbox-gl-js/v0.47.0/mapbox-gl.js'></script>
	<link href='https://api.mapbox.com/mapbox-gl-js/v0.47.0/mapbox-gl.css' rel='stylesheet' /> --}}

	<script src="/js/app.js"></script>

</body>

</html>