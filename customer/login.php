<?php require("commons.php");?>
<?php require("config.php");?>
<?php

  if(isset($_POST['submit'])){
     extract($_POST);
     clean_inputs();
     if(validate_input()){
	     login($userid);
   
     }
   }

   function validate_input(){
     extract($_POST); 

     if($userid==''){
	     $error[] = "Enter your user ID";
	   }
	
     if($psd==''){
	     $error[] = "Enter your password";
	   }
	   
	   if(!auth_user($userid,$psd)){
		    $error[] = "Invalid username or password";
		 }
	 	
  	if(isset($error)){
		 $GLOBALS['errors'] = $error;
         return false;
    }
    else{
       return true;
  }
}//end of validate input
set_page("login");
?>
<html lang="en">
<head>
  <title>Water Billing System</title>
  <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1">
  <link  href="css/bootstrap.min.css"  rel="stylesheet">
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
	.notification{
	color:red;
	font-size:14px;
	width:550px;
	}
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
<div class="container my-background" id="login_div" style="margin-top:20px; height:400px;">
<div id='upper_div' style="text-align:center;"><h2 id="text"></h2><strong>LOGIN</strong>
		<div class="container" style="margin-right:400px;">
<?php
          if(get_msg()){
            $msg = get_msg();
            echo "<div class='notification'>";
            echo "<h6 class='notification'>$msg</h6>";
            echo "</div>";
          }
?>
		</div>
	</div>

		  <?php 
		    if(isset($GLOBALS['errors'])){
		      $errors = $GLOBALS['errors'];
		      foreach($errors as $error){
		    	echo "<p class='has-error'>* $error</p>";
		      }
		    }
		    ?>
		<form role="form" id="prepaid-form" method="post" action="login.php" > 
		<table width="300" height="150" border="0" align="center" >
			<tr>
				<td><span id="sprytextfield2">
				<label for="userid">
						<input class="StyleTxtField2" type="text" id="userid" name="userid" placeholder="Enter your User ID"> <br />
				</label></span></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr> 
				<td><span id="sprytextfield2">
				<label for="psd">
						<input class="StyleTxtField2" type="password" id="psd" name="psd" placeholder="Enter Your Password"> <br />
				</label></span></td> 
			</tr> 
			<tr>
				<td>&nbsp;</td>
			</tr>
			
			 
			<tr> 
					<td><label><input type="submit" class="btn btn-primary" name="submit" value="LOGIN"></label></td>
				</div> 
			</tr> 
			</table>
		</form>
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

