$(document).ready(function() {
    $('#example').DataTable();
	
	/* ADDED EMPLOYEE DETAILS STARTS*/
	$("#addemp").submit(function(){
		
		var d = {};
		$("form#addemp :input").each(function(){
			var input = $(this);
			var dbname =input.attr('name');
			var value =input.val();
			if(dbname !== undefined){
				if((dbname == 'gender' && !value)){
					input.parent('div').addClass('has-error'); 
					return false;
				}else{
					d[dbname] = value;
				}
			}
		});
		console.log(d);
		if(1){//need to validate the dropdown list
			d['func'] = 'addemp';
			console.log(d);
			$.ajax({   
				url: "../common/dbqueries.php",
				type: "POST",
				data: d,
				success: function(dt)
				{
				   if(dt == 'Success'){
					   $('#message').show();
					   document.getElementById("message").innerHTML='Employee Added';
					   $('#message').delay(1500).fadeOut();
					   document.getElementById("addemp").reset();
				   }
				   else if(dt == 'Employee ID already exists'){
					   $('#error-message').show();
						document.getElementById("error-message").innerHTML=dt;
						$('#error-message').delay(1500).fadeOut();
				   }
				}
			
			});
			
		}
         return false;
		
	})
	
	
	/* ADDED EEMPLOYEE DETAILS ENDS */
	
	/* REPORTS PAGE START */


$('#inputgroup').change(function() {   
	piehcartvalues();
	
});



	/* REPORTS PAGE ENDS */ 
});
piehcartvalues(); //For default chart to show
function piehcartvalues(){
	var e = document.getElementById("inputgroup");
	var groupby = e.options[e.selectedIndex].value;
	var res = getvalue(groupby);
	var result = formatData(JSON.parse(res),groupby);
	drawpichart(result,groupby);
}
function formatData(data,groupby){
	var data_res = [];
	for(var v in data){
		data_res.push({name:data[v].field,y:parseInt(data[v].count),url:'listemp.php?field='+data[v].field+'&value='+data[v].count+'&groupby='+groupby});
	}	
	return data_res;
}

function drawpichart(ds,groupby){
	Highcharts.chart('ct1', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
	credits: {
        enabled: false
    },
    title: {
        text: 'Employee Details NOT completely filled grouped by '+groupby.charAt(0).toUpperCase() + groupby.slice(1)
    },
	subtitle: {
		text: 'Click on the slice for more details'
	},
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f} %</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.y:.0f}',
                style: {
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                }
            },
			//showInLegend: true
        },
		series: {
                cursor: 'pointer',
                point: {
                    events: {
                        click: function() {
							window.open(this.options.url, '_blank');
                            //location.href = this.options.url;
                        }
                    }
                }
            }
    },
    series: [{
        name: 'Percentage',
        colorByPoint: true,
        data: ds
    }]
});
}