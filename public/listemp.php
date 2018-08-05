<?php 
include_once realpath(dirname(__DIR__) . "/common/bootstrap.php");
require_once("header.php");
$allemps = getAllEmps();
$p_str = $allemps['p_str'];
unset($allemps['p_str']);
?>
<div class="container">
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
				<td><?php echo $vals['designation']; ?></td><td><a target="_blank" href="dwnpdf.php?empid=<?php echo $vals['emp_id'];?>" id='emp_id_<?php echo $vals['emp_id'];?>'>click for pdf</a></td>
				<!-- <td><a onClick="dwn_pdf(this.id)" href="#" id='emp_id_<?php echo $vals['emp_id'];?>'><?php echo "pdf" ?></a></td>-->
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
