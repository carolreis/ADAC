<?php session_start(); ?>

<!DOCTYPE html>

<html>

<?php include("head.php"); ?>

<head>
	<script src="js/Highcharts-6.1.1/code/highcharts.js"></script>
	<script src="js/Highcharts-6.1.1/code/highcharts-3d.js"></script>
	<script src="js/Highcharts-6.1.1/code/modules/exporting.js"></script>
	<script src="js/Highcharts-6.1.1/code/modules/export-data.js"></script>
</head>
<body>
	<?php include("menu.php"); 	?>
	<div class="centralizar">
		
		<h3 style='text-align:center;'>
			<a href='resultados.php?tipo=2' /> 
				<img style='display:inline; vertical-align: middle' src='img/voltar.png' title='Voltar'> 
			</a>
		</h3>
		
		<div id="container" style="height: 2000px"></div>
	</div>

<?php include("footer.php"); ?>

<script type="text/javascript">

	$.ajax({
		url: 'carregarGrafico.php',
		type: 'POST',
		data: {'id_teste' : location.search.split('teste=')[1]},
		success: function(response) {

			var jsonData = JSON.parse(response);
			var perguntas = [],
				acertos = [],
				erros = [],
				p;

			for (p in jsonData['grafico']['perguntas']) {
				perguntas.push('Questão ' + jsonData['grafico']['perguntas'][p]);
			}
			for (p in jsonData['grafico']['dados'][0]['data']) {
				erros.push(parseInt(jsonData['grafico']['dados'][0]['data'][p]));
			}
			for (p in jsonData['grafico']['dados'][1]['data']) {
				acertos.push(parseInt(jsonData['grafico']['dados'][1]['data'][p]));
			}

			Highcharts.chart('container', {
			    chart: {
			        type: 'bar',
			    },
			    title: {
			        text: 'Total de erros / acertos por questão'
			    },
			    xAxis: {
			        categories: perguntas,
			        labels: {
			            skew3d: true,
			            style: {
			                fontSize: '16px'
			            }
			        }
			    },  
			    legend: {
        			reversed: true
    			},
    			plotOptions: {
        			series: {
            			stacking: 'normal'
        			}
    			},
    			yAxis: {
			        min: 0,
			        title: {
			            text: 'Quantidade erros / acertos',
			        }
			    },
			    series: [{
			        name: 'Acertos',
			        data: acertos,
			        stack: 'fele'
			    }, {
			        name: 'Erros',
			        data: erros,
			        stack: 'male'
			    }]
			});

		}
	});
</script>
</html>