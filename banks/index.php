<?php require("commons.php");?>
<?php require("config.php");?>
<?php
	check_login();
  if(isset($_POST['submit'])){
     extract($_POST);
     clean_inputs();
     if(validate_input()){
       if($invtype == "prepaid"){
	       $_SESSION['ppr'] = $ppr;
	       redirect("process_prepaid.php");
       }
       else{
	      $_SESSION['ppr'] = $ppr;
        redirect("process_postpaid.php");
       }
     }
   }

   function validate_input(){
     extract($_POST); 

     if($invtype=='noselect'){
	     $error[] = "No invoice selected";
	   }
	
     if($ppr==''){
	     $error[] = "Enter PPR";
	   }
	   //PBRN means PWS Bank Reference Number. A way of knowing bank where payment is made
    
     if($invtype != 'noselect'){
	     if(!check_invoice($invtype,$ppr)){
		     $error[] = "The invoice details entered do not match.";
		   }
		  }
	 	
  	if(isset($error)){
		 $GLOBALS['errors'] = $error;
         return false;
    }
    else{
       return true;
  }
}//end of validate input

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
    <div class="navbar-header navbar-right">
    <a class="my-color my-text-shadow navbar-brand"><strong><small><?php if(is_logged_in()){
	  	               echo $_SESSION['bank']." <i style='font-size:13px;'>".$_SESSION['branch']."  <a href='index.php?logout=1'>Log out</a>";
	                 }
	                 else{
	                   echo "<a href='login.php'>Login</a>";
	                 }
	               ?></small></strong></a>      
    </div>
</div>
</nav>

<div class="container my-background" id="login_div4" style="margin-top:20px; height:300px;">
	<div id='upper_div' style="text-align:center;"><h2 id="text"></h2><strong>PWS PAYMENT PROCESSOR</strong>
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
			<table width="300" height="150" border="0" align="center" > 
				<tr> 
					<th><label for="bank"></label><br />
						<select class="StyleTxtField2" id="invtype"name="invtype"> 
							<option value="noselect">Select Invoice Type</option>
							<option value="prepaid">Prepaid</option>
							<option value="postpaid">Postpaid</option>											
						</select></th>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td><span id="sprytextfield2">
					<label for="userid">
							<input class="StyleTxtField2" type="text" id="ppr" name="ppr" placeholder="Enter Invoice PPR"> <br />
					</label></span></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr> 
						<td><label><input type="submit" class="btn btn-primary" name="submit" value="CHECK"></label></td>
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
                            <strong class="pull-right">@copy; PWS<small >&nbsp;2016</small></strong> <br>
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