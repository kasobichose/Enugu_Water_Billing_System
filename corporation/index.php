<?php require("commons.php");?>
<?php require("config.php");?>
<?php
//Redirects user to another page if not logged in
	check_login();
  //when admin submits form
  if(isset($_POST['submit'])){
     extract($_POST);
     clean_inputs();
     if(validate_input()){
	     get_cust_data($cust_id);
	  
     }
   }
 //redirected from another page
  if(isset($_GET['id'])){
     extract($_GET);
     clean_inputs();
	     get_cust_data($id);
   }
   function validate_input(){
     extract($_POST); 

     if($cust_id==''){
	     $error[] = "No Customer ID Entered";
	   }
	   if(!check_cust($cust_id)){
		  $error[] = "Customer with ID $cust_id not found";
		  }
	 	
  	if(isset($error)){
		 $GLOBALS['errors'] = $error;
         return false;
    }
    else{
       return true;
  }
}//end of validate input

function check_cust($cust_id){
  $db = $GLOBALS['db'];

  $stmt = $db->prepare("SELECT * FROM users WHERE userid = :cust_id");
  $stmt->execute(array(':cust_id' => $cust_id));
  if($stmt->rowCount()>0){
    //matching record found
    return true;
  }
  else{
    return false;
  }
}
function get_cust_data($cust_id){
	$GLOBALS['user_exist'] = true;
  $db = $GLOBALS['db'];

  $stmt = $db->prepare("SELECT * FROM users WHERE userid = :cust_id");
  $stmt->execute(array(':cust_id' => $cust_id));
  $row = $stmt->fetch();
  $GLOBALS['cust_name'] = $row['firstname']." ".$row['middlename']." ".$row['lastname'];
  $GLOBALS['cust_id'] = $cust_id;
  $GLOBALS['billtype'] = $row['billtype'];
  $GLOBALS['c_addr'] = $row['c_addr'];
  $GLOBALS['h_addr'] = $row['h_addr'];
  $GLOBALS['phone'] = $row['phone'];
  $GLOBALS['email'] = $row['email'];
}

function check_invoice($invtype,$ppr){
  $db = $GLOBALS['db'];
  $db_table = $invtype."_invoice";

  $stmt = $db->prepare("SELECT * FROM $db_table WHERE ppr = :ppr");
  $stmt->execute(array(':ppr' => $ppr,));
  if($stmt->rowCount()>0){
    //matching record found
    return true;
  }
  else{
    return false;
  }
}

//check if user is logged in
if(isset($_GET['logout'])){
  	logout();
  }
  set_page("index");
?>
<html lang="en">
<head>
  <title>Water Billing System</title>
  <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1">
  <link  href="css/bootstrap.min.css"  rel="stylesheet">
  <link  href="css/main.css"  rel="stylesheet">
  <link  href="css/style.css"  rel="stylesheet">
  <script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
  <link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
 <style>
    /* Remove the navbar's default margin-bottom and rounded borders */
    .navbar {
      margin-bottom: 0;
      border-radius: 0;
    }
    
    /* Add a gray background color and some padding to the footer */
    footer {
      background-color: #f2f2f2;
      padding: 25px;
    }
    .drop{
        color: #333;
     }
	 .welcome{
		color:blue;
		text-align:center;
	 }
	 .my-background{
		background-color:#d9edf7;
	 }
	 .my-textalign{
		text-align:center;
	 }
	 .my-padding{
		padding:10px;
		}

  </style>
</head>
<body>
<div class="container" style="margin-top:20px;">
<div class="container my-background2">
		<div style="width:200px;">
			<div class="container my-padding">
				<img src="../images/Capture.png" style="height:100px; width:200px;" class="img-responsive pull-left"><h1 style="text-align:center; color:#ffffff;"><strong>COMPUTERIZED WATER BILLING SYSTEM</strong> </br><em style="font-size:18px;">BY PETER KASOBI</em></h1>
			</div>
		</div>
	</div>
<nav class="navbar navbar-default role=navigation navbar-static-top">
  <div class="container-fluid">
    <div class="navbar-header">
    <a class="my-color my-text-shadow navbar-brand"><strong><small>Port Water Service</small></strong></a>      
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
                       <li  class="active "><a  href="index.php">Home</a></li> 
                       <li  class=" active "><a  href="users.php">Customers List</a></li> 
                       <li  class=" active "><a  href="creditors.php">Debtors</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <span class="glyphicon glyphicon-log-in"></span><?php if(is_logged_in()){
	  	               echo $_SESSION['admin']."<a href='index.php?logout=1'>Log out</a>";
	                 }
	                 else{
	                   echo "<a href='login.php'>Login</a>";
	                 }
	               ?>      
      </ul>
    </div>
  </div>
</nav>

<div class="container" style="margin-top:20px;">
	<div class="container my-background" id="login_div4" style="margin-top:20px; height:300px;">
	<div id='upper_div' style="text-align:center;"><h2 id="text"></h2><strong>PWS Administrator Panel</strong><div>&nbsp;</div>
		<div class="container" style="margin-right:400px;">
		  <?php 
		    if(isset($GLOBALS['errors'])){
		      $errors = $GLOBALS['errors'];
		      foreach($errors as $error){
		    	echo "<p class='has-error'>* $error</p>";
		      }
		    }
		    ?>
			</div>
		</div>
		<form role="form" id="prepaid-form" method="post" action="index.php" > 
		<table width="300" height="50" border="0" align="center" >		
			<tr>
				<td><span id="sprytextfield2">
				<label for="username">&nbsp;
					View Customer Details	
				</label><br /></span></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>

			<tr>
				<td><span id="sprytextfield2">
				<label for="cust_id">
						<input class="StyleTxtField2" type="text" id="cust_id" name="cust_id" placeholder="Enter Customer ID"> <br />
				</label></span></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
		
			<tr> 
					<td><label><input type="submit" class="btn btn-primary" name="submit" value="SEARCH"></label></td>
				</div> 
			</tr> 
			</table>
		</form>
	</div>
</div>
		<?php 
		    if(isset($GLOBALS['user_exist'])){
		  
		    ?>
			<div class="panel panel-default invoice" style="margin-top:20px;"> 
		<div class="panel-heading"> 
			<h3 class="panel-title invoiceh3"><strong><?php echo "Customer Details";?></strong></h3> 
		</div>
		<table class="table invoicetable">
			<tr><td>Full Name</td><td><?php echo $GLOBALS['cust_name'];?></td></tr>
			<tr><td>Customer ID</td><td><?php echo $GLOBALS['cust_id'];?></td></tr>
			<tr><td>Customer Type</td><td><?php echo $GLOBALS['billtype'];?></td></tr>
			<tr><td>Contact Address</td><td><?php echo $GLOBALS['c_addr'];?></td></tr>
			<tr><td>House Address</td><td><?php echo $GLOBALS['h_addr'];?></td></tr>
			<tr><td>Phone</td><td><?php echo $GLOBALS['phone'];?></td></tr>
			<tr><td>Email</td><td><?php echo $GLOBALS['email'];?></td></tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
		</table>
		<table>
		<tr>
				<td>&nbsp;</td>
			</tr>

		  <tr><button type="submit" class="btn btn-primary" name="submit" onclick="print()">PRINT VIEW</button></tr>
		</table>
	</div>
		<?php } ?>
	</div>
	<div class="container" style="margin-top:20px;">
       <footer class="footer pull-right">     
                <p>
                      <em> 
                            <strong class="pull-right">@copy; PWS<small >2016</small></strong> <br>
                            <small class="pull-right">Tel: +2348142230629</small> <br>
                            <small class="pull-right">Email: kasobichosen@gmail.com</small>
                      </em>
                </p>     
       </footer>  
       </div>

 </div>
   <script type="text/javascript">
             var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
             var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
   </script>
   
       
   <script  src="js/jquery.js"></script>
   <script  src="js/bootstrap.min.js"></script>    
</body>
</html>