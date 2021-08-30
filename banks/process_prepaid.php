<?php require("commons.php");?>
<?php require("config.php");?>
<?php
	//redirect user if not logged in
	check_login();
   try{
     $ppr = $_SESSION['ppr'];
     $db = $GLOBALS['db'];
	   $stmt = $db->query("SELECT * FROM prepaid_invoice WHERE ppr = '$ppr' AND tx_status = 'pending'");
	
	   $row = $stmt->fetch();
	   $cust_name = $row['cust_name'];
	   $cust_id = $row['cust_id'];
	   $h_addr = $row['h_addr'];
	   $card_unit = $row['card_unit'];
	   $bank_charges = $row['bank_charges'];
	   $total_amt = $row['total_amt'];
	   $bank = $_SESSION['bank'].' '. $_SESSION['branch'];
	   $tx_date = $row['tx_date'];
	  }
	  catch(PDOException $e){
	    echo  $e->getMessage();
	  }
	
	
	
   if(isset($_POST['submit'])){
     extract($_POST);
     clean_inputs();
     if(validate_input()){
	      //defined in commons.php
	     try{
	      $cardpin = gen_cardpin();
	      $stmt = $db->prepare("INSERT INTO prepaid_receipt(cust_name,cust_id,h_addr,ppr,card_unit,bank_charges,total_amt,bank,banker,cardpin,tx_date) VALUES(:cust_name,:cust_id,:h_addr,:ppr,:card_unit,:bank_charges,:total_amt,:bank,:banker,:cardpin,:tx_date)");
	      $stmt->execute(array(
	         ':cust_name' => $cust_name,
						 ':cust_id' => $cust_id,
						 ':h_addr' => $h_addr, 			
						 ':ppr' => $ppr,
						 ':card_unit' => $card_unit,
						 ':bank_charges' => $bank_charges,
						 ':total_amt' => $total_amt,
						 ':bank' => $bank,
						 ':banker' => $banker,
						 ':cardpin' => $cardpin,
						 ':tx_date' => $tx_date,
						));
				}
				catch(PDOException $e){
				  echo  $e->getMessage();
				  exit;
				}
				//delete the invoice
				$stmt = $db->query("DELETE FROM prepaid_invoice WHERE ppr = '$ppr' AND tx_status = 'pending'");
	     //go to print receipt page
      redirect("prepaid_receipt.php?ppr=$ppr");
     }
   }

   function validate_input(){
     extract($_POST); 

     if($banker==''){
	     $error[] = "Enter name of processing bank officer";
	     
	   }
	
     if(!isset($confirm)){
	     $error[] = "Confirm transaction by checking the checkbox below";
	   }
	   
	 	
  	if(isset($error)){
		 $GLOBALS['errors'] = $error;
         return false;
    }
    else{
       return true;
    }
}//end of validate input
//user logout 
  set_page("process_prepaid");
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
<nav class="navbar navbar-inverse role=navigation navbar-static-top">
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

<div class="container my-background">
	<div id='login_div5'>
			<h2 style="text-align:center;">Prepaid Card Processing</h2>
		  <?php 
		    if(isset($GLOBALS['errors'])){
		      $errors = $GLOBALS['errors'];
		      foreach($errors as $error){
		    	echo "<p class='has-error'>* $error</p>";
		      }
		    }
		    ?>
		<form  role="form" id="prepaid-form" method="post" action="process_prepaid.php"style="width:400px;"> 
		<table width="1200" height="auto" border="0" > 
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
					<td><span id="sprytextfield2">
						<label for="ppr">PPR<br />
							<input type="text" class="StyleTxtField2" id="ppr" value="<?php echo $GLOBALS['ppr'];?>" disabled>
						</label></span>
					</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
					<td><span id="sprytextfield2">
						<label for="card_unit">Card Unit<br />
							<input type="text" class="StyleTxtField2" id="card_unit" value="<?php echo $GLOBALS['card_unit'];?>" disabled>
						</label></span>
					</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			
			<tr>
					<td><span id="sprytextfield2">
						<label for="amt">Bank Charges <br />
							<input type="text" class="StyleTxtField2" id="amt" value="<?php echo $GLOBALS['bank_charges'];?>" disabled>
						</label></span>
					</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
					<td><span id="sprytextfield2">
						<label for="amt">Total Amount <br />
							<input type="text" class="StyleTxtField2" id="amt" value="<?php echo $GLOBALS['total_amt'];?>" disabled>
						</label></span>
					</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
					<td><span id="sprytextfield2">
						<label for="name">Customer Name <br />
							<input type="text" class="StyleTxtField2" id="name" value="<?php echo $GLOBALS['cust_name'];?>" disabled>
						</label></span>
					</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
					<td><span id="sprytextfield2">
						<label for="cust_id">Customer ID <br />
							<input type="text" class="StyleTxtField2" id="cust_id" value="<?php echo $GLOBALS['cust_id'];?>" disabled>
						</label></span>
					</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
					<td><span id="sprytextfield2">
						<label for="addr">House Address <br />
							<input type="text" class="StyleTxtField2" id="addr" value="<?php echo $GLOBALS['h_addr'];?>" disabled>
						</label></span>
					</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>			
			<tr>
					<td><span id="sprytextfield2">
						<label for="bank">Bank <br />
							<input type="text" class="StyleTxtField2" id="bank" value="<?php echo $_SESSION['bank'].' '.$_SESSION['branch'];?>" disabled>
						</label></span>
					</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
					<td><span id="sprytextfield2">
						<label for="banker">Name of Bank Officer <br />
							<input type="text" class="StyleTxtField2" id="banker" name="banker" placeholder="Enter Banker's Name">
						</label></span>
					</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
						<td> <input type="checkbox" name="confirm" value="agree"><span><label> &nbsp; I confirm that all the details of this transaction are correct.</label></span></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>  
					<td><input type="submit" class="btn btn-primary" name="submit" value="PROCEED"></td>
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
