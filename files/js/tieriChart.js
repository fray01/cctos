$(function (){
                 var PieData = null;
                 var pieOptions = null;
                 var pieChart = null;
		
	var $bRange = $('.bRange');
		$bRange.on('change', function() {
			$(".chart-responsive").html('<canvas id="pieChartPie" height="250"></canvas>');
			chartload();
		});
	var $legend = $('.chart-legend');
	var deb = $('#deb');
	var fin = $('#fin');
	var poser = $('#poser');
function chartload(){
	var link = '../ajax/chartfeeds.php?deb='+deb.val()+'&fin='+fin.val()+'';
	$.ajax({
		type: 'GET',
		url: link,
		dataType: "json",
		timeout: 3000,
		success: function(mydata) {
		
		  //-------------
		  //- PIE CHART -
		  //-------------
                  //initialisation
                  if(pieChart!=null){
//                	  alert('destroy');
                        pieChart.destroy();
            			$(".chart-responsive").html('<canvas id="pieChartPie" height="250"></canvas>');
//          			$("#pieChartPie").html('<canvas id="canvasPie" height="250"></canvas>');
                   }
		  // Get context with jQuery - using jQuery's .get() method.
//		$(".chart-responsive").html('Aucune statistique disponible pour les services à cette date');
		$("#pieChartPie").html('<canvas id="canvasPie" height="250"></canvas>');
		  var pieChartCanvas = $("#pieChartPie").get(0).getContext("2d");
		//  var pieChart = new Chart(pieChartCanvas);
		  PieData = mydata;
		  //alert(json_str[2]["label"]);
		  pieOptions = {
			//Boolean - Whether we should show a stroke on each segment
			segmentShowStroke: true,
			//String - The colour of each segment stroke
			segmentStrokeColor: "#fff",
			//Number - The width of each segment stroke
			segmentStrokeWidth: 1,
			//Number - The percentage of the chart that we cut out of the middle
			percentageInnerCutout: 50, // This is 0 for Pie charts
			//Number - Amount of animation steps
			animationSteps: 100,
			//String - Animation easing effect
			animationEasing: "easeOutBounce",
			//Boolean - Whether we animate the rotation of the Doughnut
			animateRotate: true,
			//Boolean - Whether we animate scaling the Doughnut from the centre
			animateScale: false,
			//Boolean - whether to make the chart responsive to window resizing
			responsive: false,
			// Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
			maintainAspectRatio: false,
			//String - A legend template
			legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>",
			//String - A tooltip template
			tooltipTemplate: "<%=value %> actes posés en <%=label%>"
		  };
		  //Create pie or douhnut chart
		  // You can switch between pie and douhnut using the method below.  

                 pieChart = new Chart(pieChartCanvas).Doughnut(PieData,pieOptions);
                 //pieChart.update();
				//legende
				$legend.html('');
				var myText = '';
				var nbposer =0;
				for(i=0;i< PieData.length; i++){
					var couleur = PieData[i].color;
					var label = PieData[i].label;
					var valeur = PieData[i].value;
					myText +='<li><div class="alert alert-dismissable " style="background-color:'+couleur+';color: #fff;"><h4>'+label+' ('+valeur+')</h4></div></li>';
					nbposer+=valeur;
				}
				poser.html(nbposer);
				$legend.html(myText);
		  //-----------------
		  //- END PIE CHART -
		  //-----------------
		},
		error: function() {
			$("canvas#canvasPie").remove();
			$(".chart-responsive").html('Aucune statistique disponible pour les services à cette date');
			$legend.html('');
		}
	});
	}
		chartload();
		setInterval(chartload, 60000);
});