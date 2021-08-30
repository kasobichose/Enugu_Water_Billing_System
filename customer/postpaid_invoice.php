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
	 .my-margin{
	 margin-bottom:20px;
	 }
	.invoice{
	width:500px;
	padding:20px;
	border:#000 2px solid;
	margin:0 auto 20px auto;
	font-size:20px;
  }
  .my-padding{
		padding:10px;
		}
  .invoiceh3 {
	text-align:center;
	font-size:30px;
	margin-bottom:30px;
  }
  .invoicetable{
	width:100%;
	margin-bottom:30px;
  }
  .invoicetabletd{
	padding:20px 0px;
  }
  .btn-back{
   background-color:#c71c22;
   color:White;
   padding:13px;
   border-top-left-radius: 30px;
   border-bottom-left-radius: 30px;
   margin:5px;
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
<?php
  if(!isset($_GET['ppr'])){
  	redirect("card_purchase.php");
  }
  try{
    $ppr = stripslashes($_GET['ppr']);
  $db = $GLOBALS['db'];
	$stmt = $db->query("SELECT * FROM postpaid_invoice WHERE ppr = '$ppr' AND tx_status = 'pending'");
  
	
	$row = $stmt->fetch();
	$cust_name = $row['cust_name'];
	$userid = $_SESSION['userid'];
	$h_addr = $row['h_addr'];
	$ppr = $row['ppr'];
	$month = $row['month'];
	$bill_amt = $row['bill_amt'];
	$bank_charges = $row['bank_charges'];
	$total_amt = $row['total_amt'];
	$tx_date = $row['tx_date'];
	}
	catch(PDOException $e){
	  echo  $e->getMessage();
	}
	set_page("postpaid_invoice");
?>
<div class="container">
	<div>
	  <a href="index.php" class="btn-back" style="margin-top:100px;">Return Home</a>
	</div>
	<div class="panel panel-default invoice"> 
		<div class="panel-heading"> 
			<h3 class="panel-title invoiceh3">PWS Postpaid Bill Invoice</h3> 
		</div>
		<table class="table invoicetable">
			<tr><td>PPR</td><td><?php echo $GLOBALS['ppr'];?></td></tr>
			<tr><td>Payment Type</td><td>Postpaid</td></tr>
			<tr><td>Customer Name</td><td><?php echo $GLOBALS['cust_name'];?></td></tr>
			<tr><td>Bill Amount</td><td><?php echo $GLOBALS['bill_amt'];?></td></tr>
			<tr><td>For Month Of</td><td><?php echo $GLOBALS['month'];?></td></tr>
			<tr><td>Bank Charges</td><td><?php echo $GLOBALS['bank_charges'];?></td></tr>
			<tr><td>Total Amount</td><td><?php echo $GLOBALS['total_amt'];?></td></tr>
			<tr><td>Time</td><td><?php echo $GLOBALS['tx_date'];?></td></tr>
		</table>
		<table>
		  <tr><button type="submit" class="btn btn-primary" name="submit" onclick="print()">Print Invoice</button></tr>
		</table>
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

