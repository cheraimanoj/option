<?php 
include_once realpath(dirname(__DIR__) . "/common/bootstrap.php");
require_once("header.php");
$gender = json_encode(getGendercount());
$desi = json_encode(getDesignationcount());
$age = json_encode(getAgecount());
?>

<div class="container">
	<div class="card-deck mb-12">
		<div class="card mb-12 box-shadow">
			<div class="card-header">
				<div class="col-8 float-left">
					<h5 class="my-0 font-weight-normal">Report</h5>
				</div>
				<div class="col-4 float-left">
				<div class="input-group">
					<div class="input-group-prepend">
						<label class="input-group-text" for="inputgroup">Group By</label>
					</div>
					<select class="custom-select" id="inputgroup">
						<option selected value="designation">Designation</option>
						<option value="age">Age</option>
						<option value="gender">Gender</option>
					</select>
				</div>
				</div>

			</div>
			<div class="card-body">
			
				<div id="ct1"></div>
			</div>
		</div>
	</div>
</div>

<script>
//For geting the values from PHP
function getvalue(groupby){
	if(groupby == 'gender'){
		return '<?php print_r($gender); ?>';
	}
	else if(groupby == 'designation'){
		return '<?php print_r($desi); ?>';
	}
	else{
		return '<?php print_r($age); ?>';
	}
}
</script>
<?php
require_once("footer.php");
?>

