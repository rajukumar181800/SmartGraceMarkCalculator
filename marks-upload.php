<?php
session_start();

include('include/config.php');
include('include/checklogin.php');
require_once('vendor/php-excel-reader/excel_reader2.php');
require_once('vendor/SpreadsheetReader.php');
$link = mysqli_connect("localhost", "root", "abhi", "hms") or die($link);

check_login();
if(isset($_POST['import']))
		  {
			$allowedFileType = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
  
			if(in_array($_FILES["file"]["type"],$allowedFileType)){
		  
				  $targetPath = 'E:/'.$_FILES['file']['name'];
				  move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);
				  
				  $Reader = new SpreadsheetReader($targetPath);
				  
				  $sheetCount = count($Reader->sheets());
				  for($i=0;$i<$sheetCount;$i++)
				  {
					  
					  $Reader->ChangeSheet($i);
					  
					  foreach ($Reader as $Row)
					  {
					
						  $r_no = "";
						  if(isset($Row[0])) {
							  $r_no = mysqli_real_escape_string($link,$Row[0]);
						  }
						  
						  $student_name = "";
						  if(isset($Row[1])) {
							  $student_name = mysqli_real_escape_string($link,$Row[1]);
						  }
						  $marks = "";
						  if(isset($Row[2])) {
							  $marks = mysqli_real_escape_string($link,$Row[2]);
						  }
						  $at_percent = "";
						  if(isset($Row[3])) {
							  $at_percent = mysqli_real_escape_string($link,$Row[3]);
						  }
						  $at_marks = "";
						  if(isset($Row[4])) {
							  $at_marks = mysqli_real_escape_string($link,$Row[4]);
						  }
						  
						  $grade = "";
						  if(isset($Row[5])) {
							  $grade = mysqli_real_escape_string($link,$Row[5]);
						  }
						  
						  
						  if (!empty($r_no) || !empty($student_name) || !empty($marks) || !empty($at_percent) || !empty($at_marks) || !empty($grade)) {
							  $query = "insert into student_marks(r_no,student_name,marks,at_percent,at_marks,grade) values('".$r_no."','".$student_name."','".$marks."','".$at_percent."','".$at_marks."','".$grade."')";
							  $result = mysqli_query($link, $query);
						  
							  if (! empty($result)) {
								  $type = "success";
								  $message = "Excel Data Imported into the Database";
							  } else {
								  $type = "error";
								  $message = "Problem in Importing Excel Data";
							  }
						  }
					   }
				  
				   }
			}
			else
			{ 
				  $type = "error";
				  $message = "Invalid File Type. Upload Excel File.";
			}
		  }
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>User | booking History</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta content="" name="description" />
		<meta content="" name="author" />
		<link href="http://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="vendor/themify-icons/themify-icons.min.css">
		<link href="vendor/animate.css/animate.min.css" rel="stylesheet" media="screen">
		<link href="vendor/perfect-scrollbar/perfect-scrollbar.min.css" rel="stylesheet" media="screen">
		<link href="vendor/switchery/switchery.min.css" rel="stylesheet" media="screen">
		<link href="vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet" media="screen">
		<link href="vendor/select2/select2.min.css" rel="stylesheet" media="screen">
		<link href="vendor/bootstrap-datepicker/bootstrap-datepicker3.standalone.min.css" rel="stylesheet" media="screen">
		<link href="vendor/bootstrap-timepicker/bootstrap-timepicker.min.css" rel="stylesheet" media="screen">
		<link rel="stylesheet" href="assets/css/styles.css">
		<link rel="stylesheet" href="assets/css/plugins.css">
		<link rel="stylesheet" href="assets/css/themes/theme-1.css" id="skin_color" />
	</head>
	<body>
		<div id="app">		
<?php include('include/sidebar.php');?>
			<div class="app-content">
				

					<?php include('include/header.php');?>
				<!-- end: TOP NAVBAR -->
				<div class="main-content" >
					<div class="wrap-content container" id="container">
						<!-- start: PAGE TITLE -->
						<section id="page-title">
							<div class="row">
								<div class="col-sm-8">
									<h1 class="mainTitle"> Upload Center</h1>
																	</div>
								<ol class="breadcrumb">
									<li>
										<span>User </span>
									</li>
									<li class="active">
										<span>upload</span>
									</li>
								</ol>
							</div>
						</section>
						<!-- end: PAGE TITLE -->
						<!-- start: BASIC EXAMPLE -->
						
														<div class="outer-container">
        <form action="" method="post"
            name="frmExcelImport" id="frmExcelImport" enctype="multipart/form-data">
            <div>
                <label>Choose Excel
                    File</label> <input type="file" name="file"
                    id="file" accept=".xls,.xlsx">
                <button type="submit" id="submit" name="import"
                    class="btn-submit">Import</button>
        
            </div>
        
        </form>
        
    </div>
    <div id="response" class="<?php if(!empty($type)) { echo $type . " display-block"; } ?>"><?php if(!empty($message)) { echo $message; } ?></div>
						
						
						<!-- end: BASIC EXAMPLE -->
						<!-- end: SELECT BOXES -->
						
					</div>
				</div>
			</div>
			<!-- start: FOOTER -->
	<?php include('include/footer.php');?>
			<!-- end: FOOTER -->
		
			<!-- start: SETTINGS -->
	<?php include('include/setting.php');?>
			
			<!-- end: SETTINGS -->
		</div>
		<!-- start: MAIN JAVASCRIPTS -->
		<script src="vendor/jquery/jquery.min.js"></script>
		<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
		<script src="vendor/modernizr/modernizr.js"></script>
		<script src="vendor/jquery-cookie/jquery.cookie.js"></script>
		<script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
		<script src="vendor/switchery/switchery.min.js"></script>
		<!-- end: MAIN JAVASCRIPTS -->
		<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
		<script src="vendor/maskedinput/jquery.maskedinput.min.js"></script>
		<script src="vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
		<script src="vendor/autosize/autosize.min.js"></script>
		<script src="vendor/selectFx/classie.js"></script>
		<script src="vendor/selectFx/selectFx.js"></script>
		<script src="vendor/select2/select2.min.js"></script>
		<script src="vendor/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
		<script src="vendor/bootstrap-timepicker/bootstrap-timepicker.min.js"></script>
		<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
		<!-- start: CLIP-TWO JAVASCRIPTS -->
		<script src="assets/js/main.js"></script>
		<!-- start: JavaScript Event Handlers for this page -->
		<script src="assets/js/form-elements.js"></script>
		<script>
			jQuery(document).ready(function() {
				Main.init();
				FormElements.init();
			});
		</script>
		<!-- end: JavaScript Event Handlers for this page -->
		<!-- end: CLIP-TWO JAVASCRIPTS -->
	</body>
</html>
