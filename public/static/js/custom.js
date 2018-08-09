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
		
		d['func'] = 'addemp';
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
        return false;
		
	})
	
	
	/* ADDED EEMPLOYEE DETAILS ENDS */
	
	/* REPORTS PAGE START */


$('#inputgroup').change(function() {   
	piehcartvalues();
	
});



	/* REPORTS PAGE ENDS */ 
});

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

function myeditfun(id){
	sessionStorage.setItem("emp_id", id);
	
	var d = {};
	d['emp_id']= id;
	d['func']= "getEmpbyId";
	$.ajax({
		url: "../common/dbqueries.php",
		type: "POST",
		data:d,
		success: function(dt)
		{
			var obj = JSON.parse(dt);
			for (var key in obj) {
				var ob = obj[key];
					var str = '#'+key;
					$(str).val(ob);
			}
		}
	});
}

function updateEmp(){
	var d = {};
	$("form#editemp :input").each(function(){
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
	
	d['emp_id']=sessionStorage.getItem("emp_id");	
	d['func'] = 'updateEmp';
	
	if(d['name']!='' && d['designation']!='' && d['age']!='' && typeof(d['gender'])!='undefined' && (d['mobile'].length==10||d['mobile'].length==0) && (d['landline'].length==10||d['landline'].length==0))
	{
		$.ajax({   
		url: "../common/dbqueries.php",
		type: "POST",
		data: d,
		success: function(dt)
		{
		   if(dt == 'Success'){
			   $('#message').show();
			   document.getElementById("message").innerHTML='Employee Details Updated';
			   $('#message').delay(1500).fadeOut();
			   setTimeout(function(){ location.reload(); }, 1500);
			    
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
}
function deleteEmp(){
	var txt;
	var r = confirm("Are you sure you want to delete?");
	if (r == true) {
		//var data = [];
		var d = {};
		d['func'] = 'deleteEmp';
		d['emp_id']=sessionStorage.getItem("emp_id");
		$.ajax({
			url: "../common/dbqueries.php",
			type: "POST",
			data: d,
			success: function(dt)
			{
			   if(dt == 'Success'){
				   $('#myEdit').modal('hide');
				   location.reload();
			   }
			}
		});
	} else {
		txt = "You pressed Cancel!";
	}
	
}
/*
function getDteails(){
	var d = {};
	
	d['func'] = "getAllEmps";
	$.ajax({
		url: "../common/dbqueries.php",
		type: "POST",
		data: d,
		success: function(dt)
		{
			var d= '<thead><tr><th>Name</th><th>Emp ID</th><th>Age</th><th>Gender</th><th>Designation</th><th>Download as PDF</th><th>Edit Details</th></tr></thead><tbody>';
			var obj = JSON.parse(dt);
			c = 1;
			console.log(obj.length);
			for(var i = 0; i < obj.length; i++) {
				c=i+1;
				d+= '<tr><td>'+obj[i]['name']+'</td><td>'+obj[i]['emp_id']+'</td><td>'+obj[i]['age']+'</td><td>'+obj[i]['gender']+'</td><td>'+obj[i]['designation']+'</td><td><a target="_blank" href="dwnpdf.php?empid='+obj[i]['emp_id']+'" id="emp_id_'+obj[i]['emp_id']+'">click for pdf</a></td><td onclick="myeditfun('+obj[i]['emp_id']+')" data-toggle="modal" data-target="#myEdit"><a href="javascript:void(0)" id="'+obj[i]['emp_id']+'">Edit</a></td>';
			}
			d+='</tbody>';
			console.log(d);
			var theDiv = document.getElementById("example");
			theDiv.innerHTML = ''; 
			theDiv.innerHTML += d; 				
		}
	});
}
*/