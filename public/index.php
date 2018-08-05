<?php 
include_once realpath(dirname(__DIR__) . "/common/bootstrap.php");
require_once("header.php");
getNonFiledList();
?>
<div class="container">
	<div class="card-deck mb-12">
		<div class="card mb-12 box-shadow">
			<div class="card-header">
				<h5 class="font-weight-normal">Add New Employee details</h5>
			</div>
			<div class="card-body">
				<form id="addemp" method="post">
				  <div class="form-row">
					<div class="form-group col-md-6">
					  <label for="inputempid">Emp ID</label>
					  <input type="text" name="emp_id" class="form-control" id="inputempid" placeholder="Employee ID" required="true">
					</div>
					<div class="form-group col-md-6">
					  <label for="inputPassword4">Full Name</label>
					  <input type="text" name="name" class="form-control" id="inputname" placeholder="Full Name" required="true">
					</div>
				  </div>
				  <div class="form-row">
					<div class="form-group col-md-3">
					  <label for="inputAge">Age</label>
					  <input type="number" name="age" min="1" max="999" class="form-control" id="inputAge" placeholder="11" required="true">
					</div>

					<div class="form-group col-md-4">
					  <label for="inputGender">Gender</label>
					  <select id="inputGender" name="gender" class="form-control" required>
						<option value="">Select</option>
						<option value="Male">Male</option>
						<option value="Female">Female</option>
						<option value="Other">Other</option>
					  </select>

					</div>
					<div class="form-group col-md-5">
					  <label for="inputZip">Designation</label>
					  <input type="text" name="designation" class="form-control" id="inputdesignation" required="true">
					</div>
				  </div>
				  <div class="form-group">
					<label for="inputAddress">Permenant Address</label>
					<input type="text" name="per_address" class="form-control" id="inputAddress1" placeholder="1234 Main St">
				  </div>
				  <div class="form-group">
					<label for="inputAddress2">Temporary address</label>
					<input type="text" name="temp_address" class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor">
				  </div>
				  <div class="form-row">
					<div class="form-group col-md-6">
					  <label for="inputempid">Phone</label>
					  <input type="tel" name="mobile" class="form-control" id="inputtel1" >
					</div>
					<div class="form-group col-md-6">
					  <label for="inputPassword4">Land-Line</label>
					  <input type="tel" name="landline" class="form-control" id="inputtel2">
					</div>
				  </div>
				  <div class="pull-right">
				  <button type="submit" class="btn btn-primary float-left" >Add Employee</button>
				  <strong><div id="message" class="text-success float-right"></div></strong>
				  <strong><div id="error-message" class="text-danger float-right"></div></strong>
				</form>
				
			</div>
		</div>
	</div>
</div>


<?php
require_once("footer.php");
?>