<?php

if(isset($_POST['func']))
{	
    if($_POST['func'] == "addemp")
    {
        addEmp();
    }
	if($_POST['func'] == 'getEmpbyId')
	{
		getEmpbyId();
	}
	if($_POST['func'] == 'updateEmp')
	{
		updateEmp();
	}
	if($_POST['func'] == 'getAllEmps')
	{
		getAllEmps();
	}if($_POST['func'] == 'deleteEmp')
	{
		deleteEmp();
	}
	
}

function addEmp(){
	global $conn;
	$params = $_POST;
	unset($params['func']);
	$params['state'] = 1;
	if($params['mobile'] == ''){
		unset($params['mobile']);
	}
	if($params['landline'] == ''){
		unset($params['landline']);
	}
	$params['date_added']=date('Y-m-d H:i:s');
	$params['date_updated']=date('Y-m-d H:i:s');
	$ex = checkEmpid($params['emp_id']);
	if($ex == 0){
		$query  = "INSERT INTO employee";
		$query .= " (`".implode("`, `", array_keys($params))."`)";
		$query .= " VALUES ('".implode("', '", $params)."') ";
		if ($conn===NULL){ 
			$conn = dbconnection();
		}
		$sth = $conn->prepare($query);

		if ($sth->execute() === TRUE){
			echo "Success";
		} else {
			echo "Error: " . $query;
		}
	}else{
		echo "Employee ID already exists";
	}
	
	//print_r($params);
}
function updateEmp(){
	global $conn;
	$params = $_POST;
	$emp_id = $params['emp_id'];
	unset($params['func']);
	unset($params['emp_id']);
	if($params['mobile'] == ''){
		unset($params['mobile']);
	}
	if($params['landline'] == ''){
		unset($params['landline']);
	}
	$params['date_updated']=date('Y-m-d H:i:s');
	foreach($params as $key => $vals) {
	   $set_vals[] = "$key = '$vals'";
	}
	$query  = "UPDATE employee SET ";
	$query .= implode(", ", $set_vals);
	$query .= " WHERE emp_id = ".$emp_id;
	
	if($conn===NULL){ 
		$conn = dbconnection();
	}
	$sth = $conn->prepare($query);

	if ($sth->execute() === TRUE){
		echo "Success";
	} else {
		echo "Error: " . $query;
	}
}
function deleteEmp(){
	global $conn;
	$params = $_POST;
	$emp_id = $params['emp_id'];
	unset($params['func']);
	unset($params['emp_id']);
	
	$params['date_updated']=date('Y-m-d H:i:s');
	
	$query  = "UPDATE employee SET ";
	$query .= " date_updated='".$params['date_updated']."',state=0";
	$query .= " WHERE emp_id = ".$emp_id;
	
	if($conn===NULL){ 
		$conn = dbconnection();
	}
	$sth = $conn->prepare($query);

	if ($sth->execute() === TRUE){
		echo "Success";
	} else {
		echo "Error: " . $query;
	}
}
function checkEmpid($emp_id){
	global $conn;
	if ($conn===NULL){ 
		$conn = dbconnection();
	}
	$query = "SELECT * from employee where emp_id=".$emp_id;
	$sth = $conn->prepare($query);
	$sth->execute();
	
	$resultset = $sth->fetchAll(PDO::FETCH_ASSOC);
	
	return count($resultset);
}

function dbconnection(){
	$config_file = realpath(dirname(__DIR__)) . "/config/config.php";
	if (file_exists($config_file)) {
		$config = include $config_file;
	}
	$conn = new PDO("mysql:host={$config['db']['host']};port={$config['db']['port']};dbname={$config['db']['name']};", $config['db']['user'], $config['db']['pass']);
	
	return $conn;
}
function getNonFiledList(){
	global $conn;
	
	//$query = "SELECT * FROM `employee` where concat(per_address,temp_address,mobile,landline) is null ";
	$gender = getGendercount();
	$desi = getDesignationcount();
	$age = getAgecount();
}

function getGendercount(){
	global $conn;
	
	$query = "SELECT gender as field,count(id) as count FROM `employee` where concat(per_address,temp_address,mobile,landline) is null and state=1 group by gender";

    $sth = $conn->prepare($query);
    $sth->execute();

    $resultset = $sth->fetchAll(PDO::FETCH_ASSOC);
	
	return $resultset;
	
}


function getDesignationcount(){
	global $conn;
	
	$query = "SELECT designation as field,count(id) as count FROM `employee` where concat(per_address,temp_address,mobile,landline) is null and state=1 group by designation";

    $sth = $conn->prepare($query);
    $sth->execute();

    $resultset = $sth->fetchAll(PDO::FETCH_ASSOC);
	
	return $resultset;
	
}
function getAgecount(){
	global $conn;
	
	$query = "SELECT concat(10*floor(age/10), '-', 10*floor(age/10) + 10) as field,count(*) as count FROM `employee` where concat(per_address,temp_address,mobile,landline) is null and state=1 group by field ";

    $sth = $conn->prepare($query);
    $sth->execute();

    $resultset = $sth->fetchAll(PDO::FETCH_ASSOC);
	
	return $resultset;
	
}

function getAllEmps(){
	global $conn;
	$flag = '';
	if ($conn===NULL){ 
		$conn = dbconnection();
		$flag=1;
	}
	$params = $_GET;
	$str_print = '';
	if(!empty($params)){
		$str_print = 'grouped by '.$params['groupby'].' of '.$params['field'];
		if($params['groupby'] == 'age'){
			$agerange = explode("-",$params['field']);
			$where_sql = $params['groupby']." between ".$agerange[0]." and ".$agerange[1];
		}
		else{
			$where_sql = $params['groupby']."='".$params['field']."'";
		}
		$query = "SELECT id,emp_id,name,age,gender,designation,date_added from employee where ".$where_sql." and concat(per_address,temp_address,mobile,landline) is null and state=1 order by date_added desc";
	}else{
		$query = "SELECT id,emp_id,name,age,gender,designation,date_added from employee where state=1 order by date_added desc";
	}
	$sth = $conn->prepare($query);
	$sth->execute();

	$resultset = $sth->fetchAll(PDO::FETCH_ASSOC);
	$resultset = array_merge($resultset,array('p_str'=>$str_print));
	if($flag)
		print(json_encode($resultset[0]));
	else
		return $resultset;
	
}

function getEmpbyId(){
	global $conn;
	if ($conn===NULL){ 
		$conn = dbconnection();
	}
	$params = $_POST;
	if($params['emp_id'])
	{
		$query = "SELECT emp_id,name,age,gender,designation,per_address,temp_address,mobile,landline from employee where emp_id=".$params['emp_id']." and state=1 order by date_added desc";
		$sth = $conn->prepare($query);
		$sth->execute();

		$resultset = $sth->fetchAll(PDO::FETCH_ASSOC);
		if($resultset[0]){
			echo json_encode($resultset[0]);
		}
		else{
			echo "error";
		}
	}
	else{
			echo "error";
		}
	

    
}

function downloadAsPdf(){
	$params = $_GET;
	
	global $conn;
	require('include/fpdf.php');
	if ($conn===NULL){ 
		$conn = dbconnection();
	}
	$query = "SELECT emp_id as Employee_ID,name as Employee_Name,age as Age,gender as Gender,designation as Designation,per_address as Present_address,temp_address as Temporary_address,mobile as Mobile,landline as Land_line,date_added as Date_added,date_updated as Last_updated ";
	$query .=" from employee where emp_id=".$params['empid']." and state=1 order by date_added desc";
	
    $sth = $conn->prepare($query);
    $sth->execute();

    $resultset = $sth->fetchAll(PDO::FETCH_ASSOC);
	if(array_key_exists(0,$resultset)){
		$res = $resultset[0];
	}
	else{
		$res = null;
	}

	$pdf = new FPDF();
	$pdf->AddPage();
	//Header
		$pdf->SetFont('Arial','B',15);
		$pdf->Cell(60);// Move to the right
		$pdf->Cell(30,10,'Option3 Employee Details');
		$pdf->Ln(20);
	//Header Ends
	
	
	$pdf->SetFont('Times','',11);

	$array1= array_keys($res);
	$array2= array_values($res);
	
	$pdf->SetFont('Helvetica','B',14);
	$pdf->Cell(40,10,'Field');
	$pdf->Cell(40,10,'Details');
	$pdf->Line(10, 40, 160, 40);
	$pdf->Line(50, 30, 50, 150);
	$pdf->Ln(10);
	$c=10;
	foreach($array1 as $key=>$row){
		$pdf->SetFont('Helvetica','',11);
		$pdf->Cell(40,10,$row);
		$pdf->Cell(40,10,$array2[$key]);
		$pdf->Ln(10);
		$pdf->Line(10, 40+$c, 160, 40+$c);
		$c+=10;
	}
	$pdf->Output();
}

?>