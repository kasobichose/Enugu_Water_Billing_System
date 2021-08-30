<?php require("commons.php");?>
<?php require("config.php");?>
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
	 .my-color{
		color:red;
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
<?php

  if(is_logged_in()){
	$userid = $_SESSION['userid'];
    $stmt = $db->prepare('SELECT * FROM users WHERE userid = :userid');
    $stmt->execute(array(':userid' => $userid));
    $row =  $stmt->fetch();

	$firstname = $row['firstname'];
	$middlename = $row['middlename'];
	$lastname = $row['lastname'];
	$userid = $row['userid'];
	$h_addr = $row['h_addr'];
  }
  else{
  	$firstname = '';
  	$middlename = '';
	$lastname = '';
	$userid = '';
	$h_addr = '';
  }


  if(isset($_POST['submit'])){
    if(!is_logged_in()){
    	echo "Please login to your account before making payments. <a href='login.php'>Login</a>";
    	exit;
    }   
    else{
    	process_request();
    }
  }

  function process_request(){
  	$card_unit = stripslashes(strip_tags($_POST['card_unit']));
  	if($card_unit == 'noselect'){
  		$GLOBALS['error'] = "No card unit selected";
  		$error = true;
  	}
  	if(!$error){
  		try{
           $userid = $_SESSION['userid'];
           $db = $GLOBALS['db'];
           $stmt = $db->prepare('SELECT * FROM users WHERE userid = :userid');
           $stmt->execute(array(':userid' => $userid));
           $row =  $stmt->fetch();
	         $cust_name = $row['firstname']." ".$row['middlename']." ".$row['lastname'];
           $h_addr = $row['h_addr'];
           $ppr = gen_ppr();
           $tx_date = date("M j , Y g:i A",time()+3600);
           $bank_charges = BANKCHARGES;
           $total_amt = $card_unit + $bank_charges;


  		     $db = $GLOBALS['db'];
		       $stmt = $db->prepare('INSERT INTO prepaid_invoice(cust_name,cust_id,h_addr,ppr,card_unit,bank_charges,total_amt,tx_date,tx_status) VALUES (:cust_name,:cust_id,:h_addr,:ppr,:card_unit,:bank_charges,:total_amt,:tx_date,:tx_status)');
		       $stmt->execute(array(
		 				 ':cust_name' => $cust_name,
						 ':cust_id' => $userid,
						 ':h_addr' => $h_addr, 			
						 ':ppr' => $ppr,
						 ':card_unit' => $card_unit,
						 ':bank_charges' => $bank_charges,
						 ':total_amt' => $total_amt,
						 ':tx_date' => $tx_date,
						 ':tx_status' => 'pending'
						 ));
		}
		catch(Exception $e){
			echo $e;
			exit;
		}
	redirect("prepaid_invoice.php?ppr=$ppr");
 
  		}
  	}
set_page("paybill");
?>

<div class="container my-background">
	<div id="content">
		<div id='login_div2'>
				<h2>Prepaid Card Purchase</h2>
		  <p class="my-color">Use the invoice generated after filling your payment details here to pay 
			at any UBA, First Bank, Zenith Bank or Fidelity Bank branch near you. After
			payment, the bank will issue you a receipt containing your PWS Prepaid Card Pin.</p>

	<form  role="form" id="prepaid-form" method="post" action="card_purchase.php"style="width:400px;"> 
		<table width="1200" height="auto" border="0" >
		<?php 
		    if(isset($GLOBALS['error'])){
		      $error = $GLOBALS['error'];
		    	echo "<p class='has-error'>* $error</p>";
		    }
		    ?>

			<tr> 
				<th><label for="amount">Month</label><br />
					<select class="StyleTxtField2" id="amount"name="card_unit"> 
						<option value="noselect">Card Unit</option>
						<option value="1000">N1000</option>
						<option value="2000">N2000</option>
						<option value="3500">N3500</option>
						<option value="5000">N5000</option>							
					</select></th>
			</tr>
			<?php $name = $GLOBALS['firstname']." ".$GLOBALS['middlename']." ".$GLOBALS['lastname'];
			    $userid = $GLOBALS['userid'];
			    $h_addr = $GLOBALS['h_addr'];
			 ?>
			 <tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
					<td><span id="sprytextfield2">
						<label for="name">Customer Name<br/>
							<input type="text" class="StyleTxtField2" id="userid" id="name" value="<?php echo $name;?>" disabled>
						</label></span>
					</td>
				</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			
			<tr>
					<td><span id="sprytextfield2">
						<label for="cust_id">Customer ID<br/>
							<input type="text" class="StyleTxtField2" id="cust_id" value="<?php echo $userid;?>" disabled>
						</label></span>
					</td>
				</tr>	
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
					<td><span id="sprytextfield2">
						<label for="addr">House Address<br/>
							<input type="text" class="StyleTxtField2" id="addr" value="<?php echo $h_addr?>" disabled>
						</label></span>
					</td>
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
				
			
			