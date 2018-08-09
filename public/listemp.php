<?php 
include_once realpath(dirname(__DIR__) . "/common/bootstrap.php");
require_once("header.php");
$allemps = getAllEmps();
$p_str = $allemps['p_str'];
unset($allemps['p_str']);
?>
<div class="container">
	
	<!--Popup -->
	<div class="modal fade" id="myEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div id="snackbar"></div>
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Edit/Delete Employee Details</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
				
					<form id="editemp" method="post">
						<div class="form-row">
							<div class="form-group col-md-6">
							  <label for="inputempid">Emp ID</label>
							  <input type="text" name="emp_id" class="form-control" id="emp_id" placeholder="Employee ID" disabled="disabled">
							  
							</div>
							<div class="form-group col-md-6">
							  <label for="inputPassword4">Full Name</label>
							  <input type="text" name="name" class="form-control" id="name" placeholder="Full Name" required="true">
							</div>
						</div>
						
						<div class="form-row">
							<div class="form-group col-md-3">
							  <label for="inputAge">Age</label>
							  <input type="number" name="age" min="1" max="999" class="form-control" id="age" placeholder="11" required="true">
							</div>

							<div class="form-group col-md-4">
							  <label for="inputGender">Gender</label>
							  <select id="gender" name="gender" class="form-control" required>
								<option value="">Select</option>
								<option value="Male">Male</option>
								<option value="Female">Female</option>
								<option value="Other">Other</option>
							  </select>
							</div>
							<div class="form-group col-md-5">
							  <label for="inputZip">Designation</label>
							  <input type="text" name="designation" class="form-control" id="designation" required="true">
							</div>
						</div>
						<div class="form-group">
							<label for="inputAddress">Permenant Address</label>
							<input type="text" name="per_address" class="form-control" id="per_address" placeholder="1234 Main St">
						</div>
						<div class="form-group">
							<label for="inputAddress2">Temporary address</label>
							<input type="text" name="temp_address" class="form-control" id="temp_address" placeholder="Apartment, studio, or floor">
						</div>
						<div class="form-row">
							<div class="form-group col-md-6">
								<label for="inputempid">Phone</label>
								<input type="tel" name="mobile" class="form-control" id="mobile" pattern="[1-9]{1}[0-9]{9}">
							</div>
							<div class="form-group col-md-6">
								<label for="inputPassword4">Land-Line</label>
								<input type="tel" name="landline" class="form-control" id="landline" pattern="[1-9]{1}[0-9]{9}">
							</div>
						</div>
						<div class="pull-right">
							<strong><div id="message" class="text-success float-right"></div></strong>
							<strong><div id="error-message" class="text-danger float-right"></div></strong>
						</div>
				
			</form>	
			</div>
			<div class="modal-footer">
				<button type="button" onclick="deleteEmp()" class="btn btn-danger pull-left">Delete</button>
				<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
				<button type="submit" onclick="updateEmp()" class="btn btn-primary pull-right">Update</button>
			</div>
			
		</div>
	</div>
	</div>
	<!--popup -->
	<div class="card-deck mb-12">
		<div class="card mb-12 box-shadow">
			<div class="card-header">
				<h5 class="font-weight-normal">Option3 Employe Details <?php echo $p_str; ?> </h5>
			</div>
			<div class="card-body">
			
				<table id="example" class="table table-striped table-bordered" style="width:100%">
				<thead>
					<tr>
						<th>Name</th>
						<th>Emp ID</th>
						<th>Age</th>
						<th>Gender</th>
						<th>Designation</th>
						<th>Download as PDF</th>
						<th>Edit/Delete Details</th>
					</tr>
				</thead>
				<tbody>
				<?php 
				foreach($allemps as $vals){
				?>
				<tr>
				<td><?php echo $vals['name']; ?></td>
				<td><?php echo $vals['emp_id']; ?></td>
				<td><?php echo $vals['age']; ?></td>
				<td><?php echo $vals['gender']; ?></td>
				<td><?php echo $vals['designation']; ?></td>
				<td><a target="_blank" href="dwnpdf.php?empid=<?php echo $vals['emp_id'];?>" id='emp_id_<?php echo $vals['emp_id'];?>'>click for pdf</a></td>
				<!-- <td><a onClick="dwn_pdf(this.id)" href="#" id='emp_id_<?php echo $vals['emp_id'];?>'><?php echo "pdf" ?></a></td>-->
				<td onclick="myeditfun(<?php echo $vals['emp_id'] ?>)" data-toggle="modal" data-target="#myEdit"><a href="javascript:void(0)" id="<?php echo $vals['emp_id'] ?>" > Edit/Delete </a> </td>
				</tr>
				<?php	} ?>

				</tbody>
			</div>
		</div>
		  
		
	</div>

	
</div>

<?php
require_once("footer.php");
?>
