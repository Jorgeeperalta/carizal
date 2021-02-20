<!doctype HTML>
<html>

<head>
	<meta charset="utf-8">
	<title>leaflet-measure</title>
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css" integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ==" crossorigin="" />
	<link rel="stylesheet" href="leaflet-measure.css">
	<!-- <h3>Nota: antes de cargar la tabla se recomienda determinar area en el mapa<h3> -->
	<!-- <input id="texto" placeholder="nombre de area"> -->
	<style>
		body {
			font-size: 14px;
			font-family: Helvetica, sans-serif;
			font-weight: 400;
			line-height: 1;
			color: rgb(158, 23, 23);
			text-rendering: optimizeLegibility;
			-webkit-font-smoothing: antialiased;
		}

		body {
			margin: 0 20px 20px;
		}

		h1,
		h2 {
			margin: 20px 0 0;
			font-size: 1.4em;
			font-weight: normal;
			line-height: 1;
		}

		h1 {
			display: inline-block;
			font-size: 1.8em;
		}

		h2 {
			font-size: 1.1em;
		}

		pre {
			line-height: 1.5em;
		}

		p.github {
			display: inline-block;
			margin: 20px 0 0 20px;
			font-size: 1.2em;
		}

		a,
		a:visited,
		a:hover,
		a:active,
		a:focus {
			text-decoration: none;
		}

		#map {
			height: 500px;
			margin: 20px 20px 0 0;
		}
	</style>
</head>

<body>
	<h1></h1>

	<div id="map"></div>
	<!-- <h2><code>Datos de Calculos de Area</code> Datos:</h2> -->
	<pre id="eventoutput"></pre>
	<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
	<script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js" integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw==" crossorigin=""></script>
	<script src="leaflet-measure.js"></script>
	<script>
		(function(L, document) {
			var map = L.map('map', {
				center: [-36.495417, -56.700884],
				zoom: 7,
				measureControl: true
			});
			L.tileLayer('//server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
				minZoom: 3,
				maxZoom: 17,
				attribution: '&copy; Esri &mdash; Sources: Esri, DigitalGlobe, Earthstar Geographics, CNES/Airbus DS, GeoEye, USDA FSA, USGS, Getmapping, Aerogrid, IGN, IGP, swisstopo, and the GIS User Community'
			}).addTo(map);

			map.on('measurefinish', function(evt) {
				writeResults(evt);
			});

			function writeResults(results) {
				escribe(results);
				document.getElementById('eventoutput').innerHTML = JSON.stringify({
						area: Math.round(results.area),
						// // areaDisplay: results.areaDisplay,
						// // lastCoord: results.lastCoord,
						// // length: results.length,
						// // lengthDisplay: results.lengthDisplay,
						cantidad_de_puntos: results.pointCount,
						Coordenadas: results.points

					},

					null,

				);



			}

			function escribe(results) {
				var aux;
				var divide;
				divide = results.area / 10000;
				divide = Math.round(divide);

				fetch('http://localhost:81/S.Final/leaflet-measure/backend/' + divide)
					.then(function(response) {
						return response.json();
					})
					.then(function(myJson) {
						console.log(myJson);
					});

				fetch('http://localhost:81/S.Final/leaflet-measure/backend/euro')
					.then(datos => datos.json())
					.then(datos => {
						datos.forEach(element => {
							// console.log("este del euro "+element.nombre);
						});
						this.datas = datos;
						console.log(datos[2].nombre)
						console.log(datos);
					})


			}

		})(window.L, window.document);
	</script>
</body>

</html>
<!doctype HTML>
<html>

<head>
	<meta charset="utf-8">
	<title>leaflet-measure</title>
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css" integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ==" crossorigin="" />
	<link rel="stylesheet" href="leaflet-measure.css">
	<!-- <h3>Nota: antes de cargar la tabla se recomienda determinar area en el mapa<h3> -->
	<!-- <input id="texto" placeholder="nombre de area"> -->
	<style>
		body {
			font-size: 14px;
			font-family: Helvetica, sans-serif;
			font-weight: 400;
			line-height: 1;
			color: rgb(158, 23, 23);
			text-rendering: optimizeLegibility;
			-webkit-font-smoothing: antialiased;
		}

		body {
			margin: 0 20px 20px;
		}

		h1,
		h2 {
			margin: 20px 0 0;
			font-size: 1.4em;
			font-weight: normal;
			line-height: 1;
		}

		h1 {
			display: inline-block;
			font-size: 1.8em;
		}

		h2 {
			font-size: 1.1em;
		}

		pre {
			line-height: 1.5em;
		}

		p.github {
			display: inline-block;
			margin: 20px 0 0 20px;
			font-size: 1.2em;
		}

		a,
		a:visited,
		a:hover,
		a:active,
		a:focus {
			text-decoration: none;
		}

		#map {
			height: 500px;
			margin: 20px 20px 0 0;
		}
	</style>
</head>

<body>
	<h1></h1>

	<div id="map"></div>
	<!-- <h2><code>Datos de Calculos de Area</code> Datos:</h2> -->
	<pre id="eventoutput"></pre>
	<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
	<script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js" integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw==" crossorigin=""></script>
	<script src="leaflet-measure.js"></script>
	<script>
		(function(L, document) {
			var map = L.map('map', {
				center: [-36.495417, -56.700884],
				zoom: 7,
				measureControl: true
			});
			L.tileLayer('//server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
				minZoom: 3,
				maxZoom: 17,
				attribution: '&copy; Esri &mdash; Sources: Esri, DigitalGlobe, Earthstar Geographics, CNES/Airbus DS, GeoEye, USDA FSA, USGS, Getmapping, Aerogrid, IGN, IGP, swisstopo, and the GIS User Community'
			}).addTo(map);

			map.on('measurefinish', function(evt) {
				writeResults(evt);
			});

			function writeResults(results) {
				escribe(results);
				document.getElementById('eventoutput').innerHTML = JSON.stringify({
						area: Math.round(results.area),
						// // areaDisplay: results.areaDisplay,
						// // lastCoord: results.lastCoord,
						// // length: results.length,
						// // lengthDisplay: results.lengthDisplay,
						cantidad_de_puntos: results.pointCount,
						Coordenadas: results.points

					},

					null,

				);



			}

			function escribe(results) {
				var aux;
				var divide;
				divide = results.area / 10000;
				divide = Math.round(divide);

				fetch('http://localhost:81/S.Final/leaflet-measure/backend/' + divide)
					.then(function(response) {
						return response.json();
					})
					.then(function(myJson) {
						console.log(myJson);
					});

				fetch('http://localhost:81/S.Final/leaflet-measure/backend/euro')
					.then(datos => datos.json())
					.then(datos => {
						datos.forEach(element => {
							// console.log("este del euro "+element.nombre);
						});
						this.datas = datos;
						console.log(datos[2].nombre)
						console.log(datos);
					})


			}

		})(window.L, window.document);
	</script>
</body>

</html>

