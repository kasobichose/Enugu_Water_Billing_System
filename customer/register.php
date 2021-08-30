<?php require("commons.php");?>
<?php require("config.php");?>
<?php
 /*This script validates the user registration on the server-side 
 *incase the user views the page with JavaScript turned off and also to 
 *sanitise the input, to combat attacks like SQL injection and 
 *XSS attack

 *extract the user inputs from the HTTP POST 
 *The POST variables bear the name of the 'name' attr of the 
 *html input elements.
 */


  if(isset($_POST['submit'])){
     extract($_POST);

     clean_inputs();
     if(validate_input()){
       create_user();
   
     }
   }
      

function validate_input(){
   extract($_POST); 

  if($firstname==''){
	  $error[] = "Please enter your firstname";
	}
	
  if($middlename==''){
	  $error[] = "Please enter your middlename";
	}
	
  if($lastname==''){
	  $error[] = "Please enter your lastname";
	}
		 	
  if($c_addr==''){
	  $error[] = "Please enter your contact address";
	}
	 	
  if($h_addr==''){
	  $error[] = "Please enter your home address";
	}
	
	if($usgtype=='noselect'){
	  $error[] = "Invalid Usage type selected";
	}
	
	if($billtype=='noselect'){
	  $error[] = "Invalid billing method selected";
	}
	
	
	 	
  if($email==''){
	  $error[] = "Please enter your email address";
	}

  if(!preg_match('#^(([a-z0-9!\#$%&\\\'*+/=?^_`{|}~-]+\.?)*[a-z0-9!\#$%&\\\'*+/=?^_`{|}~-]+)@(([a-z0-9-_]+\.?)*[a-z0-9-_]+)\.[a-z]{2,}$#i',$email)){
	  $error[] = 'Please enter a valid email address.'; 
   }
		 
	 	
  if($phone==''){
	  $error[] = "Please enter your phone number";
	}
	 	
  if(!isset($terms)){
	  $error[] = "Please agree to the terms and conditions";
	}
	 	
  	if(isset($error)){
		 $GLOBALS['reg_errors'] = $error;
         return false;
    }
    else{
       return true;
  }
}//end of validate input

//create a prepaid customer account
function create_user(){
	extract($_POST);
  $userid =  gen_userid();
	$password = gen_password();
	//hash the password with md5 algorithm for basic security
	$hashedpassword = md5($password);
	//set the payment tariff based on the usage type selected
	//default to 600,But will surely be overridden by user selection 
	$mntbill = 600;
	if($usgtype=="Commercial"){
		$mntbill= 5000;
	}
	else if($usgtype=="Duplex"){
		$mntbill=2500;
  }
  else if($usgtype=="Flat"){
	  $mntbill = 800;
	}
	else{
		$mntbill = 600;
	}
	//insert into database
	try{
	  $db = $GLOBALS['db'];
		$stmt = $db->prepare('INSERT INTO users(firstname,middlename,lastname,billtype,usgtype,mntbill,userid,password,c_addr,h_addr,email,phone) VALUES (:firstname,:middlename,:lastname,:billtype,:usgtype,:mntbill,:userid,:password,:c_addr,:h_addr,:email,:phone)');
		$stmt->execute(array(
		 				 ':firstname' => $firstname,
						 ':middlename' => $middlename,
						 ':lastname' => $lastname, 			
						 ':billtype' => $billtype,
						 ':usgtype' => $usgtype,
						 ':mntbill' => $mntbill,
						 ':userid' => $userid,
						 ':password' => $hashedpassword,
						 ':c_addr' => $c_addr,
						 ':h_addr' => $h_addr,
						 ':email' => $email, 					
						 ':phone' => $phone));

		set_msg("Congratulations! Account created successfully. Your Login ID is $userid and password $password.</br> Copy these details and keep securely before logging in or leaving this page. Thank you");
		redirect('login.php');
 
  }
  catch(PDOException $e){
    echo $e;
  }
}


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
	  background-size: 1000px;
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
	 .my-background2{
		background: #04489a 100px center;
		background-size:50px 50px;
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
                       <li  class=" active "><a  href="card_purchase.php">Buy Prepaid Card</a></li> 
                       <li  class=" active "><a  href="paybill.php">Pay Bill</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <span class="glyphicon glyphicon-log-in"></span> <?php if(is_logged_in()){
	  	               echo $_SESSION['username']." <a href='index.php?logout=1'>Log out</a>";
	                 }
	                 else{
	                   echo "<a href='login.php'>Login</a> | <a href='register.php'>Register</a>";
	                 }
	               ?>
      </ul>
    </div>
  </div>
</nav>
<div class="container my-background">
	<div id="content">
	<div id='login_div'>
	<h2 class="my-textalign">REGISTER</h2>
		  <?php 
		    if(isset($GLOBALS['reg_errors'])){
		      $errors = $GLOBALS['reg_errors'];
		      foreach($errors as $error){
		    	echo "<p class='has-error'>* $error</p>";
		      }
		    }
		    ?>
		<form role="form" id="prepaid-form" method="post" action="register.php" style="width:400px;"> 
			<table width="1200" height="auto" border="0" >
				<tr>
					<td><span id="sprytextfield2">
						<label for="firstname">
							<input type="text" class="StyleTxtField2" id="userid" name="firstname" placeholder="Enter Your First Name">
						</label></span>
					</td>
				</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr> 
				<td><span id="sprytextfield2">
					<label for="middlename">  
						<input type="text" class="StyleTxtField2" id="middlename" name="middlename" placeholder="Enter Your Middle Name">
					</label>
					</span>
				</td>
			</tr> 
			<tr>
				<td>&nbsp;</td>
			</tr>

			<tr> 
				<td><span id="sprytextfield2">
					<label for="lastname">  
						<input type="text" class="StyleTxtField2" id="lastname" name="lastname" placeholder="Enter Your Last Name"> 
					</label></span>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>

			<tr> 
				<td><span id="sprytextfield2">
					<label for="contact_address">
							<input textarea row="2" class="StyleTxtField2" id="c_addr" name="c_addr" placeholder="Enter Your Contact Address"> 
					</label></span>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>

			<tr> 
				<td><span id="sprytextfield2">
					<label for="home_office_address"> 
						<input textarea row="2" class="StyleTxtField2"  id="h_addr" name="h_addr" placeholder="Enter Your Home/Office Address"> 
					</label> </span>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>

			<tr> 
				<th><label for="">Billing Method</label><br />
					<select class="StyleTxtField2" name="billtype"> 
						<option value="noselect">-----Billing Method-----</option>
						<option value="Prepaid">Prepaid</option> 
						<option value="Postpaid">Postpaid</option>  
					</select>
					<em><small><p style="color:red;">Prepaid billing method only for customers who installed Prepaid Water Meter</p></small></em></th>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>

			<tr> 
				<th><label for="">Usage Type</label><br />
					<select class="StyleTxtField2" name="usgtype"> 
						<option value="noselect">-----Usage Type-----</option>
						<option value="Commercial">Commercial</option> 
						<option value="Duplex">Duplex</option>
						<option value="Flat">Flat</option>
						<option value="Single">Single Room</option>						
					</select></th>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>

			<tr> 
				<td><span id="sprytextfield2">
					<label for="email_address">
						<input type="text" class="StyleTxtField2" id="email" name="email" placeholder="Enter Your Email Address"> 
					</label></span>
				</td> 
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>

			<tr> 
				<td><span id="sprytextfield2">
					<label for="phone_no">
						<input type="tel" class="StyleTxtField2" id="phone" name="phone" placeholder="Enter Your Phone Number"> 
					</label> </span>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>

			<tr>
						<td> <input type="checkbox" name="terms" value="agree"><span><label> &nbsp; I agree with terms and conditions</label></span></td>
			</tr>
			<tr>  
					<td><input type="submit" class="btn btn-primary" name="submit" value="REGISTER"></td>
			</tr> 
		</table>
		</form>
    </div> 
</div>
</div>	
       <div class="container" style="margin-top:10px;">
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
