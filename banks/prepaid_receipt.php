<?php require("commons.php");?>
<?php require("config.php");?>
<?php
	//redirect user if not logged in
	check_login();
  try{
    $ppr = stripslashes($_GET['ppr']);
    $db = $GLOBALS['db'];
	  $stmt = $db->query("SELECT * FROM prepaid_receipt WHERE ppr = '$ppr'");
	 $row = $stmt->fetch();
	
	 $cardpin = $row['cardpin'];
	 $card_unit = $row['card_unit'];
	 $cust_id = $row['cust_id'];
	 $tx_date = $row['tx_date'];
	}
	catch(PDOException $e){
	  echo  $e->getMessage();
	}
//user logout 
  set_page("prepaid_receipt");
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
	  .my-margin{
	 margin-bottom:20px;
	 }
	 .my-padding{
		padding:10px;
		}
.invoice{
	width:500px;
	padding:20px;
	border:#000 2px solid;
	margin:0 auto 20px auto;
	font-size:20px;
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
   margin:10px;
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
<nav class="navbar navbar-default role=navigation navbar-static-top my-margin">
  <div class="container-fluid">
    <div class="navbar-header navbar-right">
    <a class="my-color my-text-shadow navbar-brand"><strong><small><?php if(is_logged_in()){
	  	               echo $_SESSION['bank']." <i style='font-size:13px;'>".$_SESSION['branch']."  <a href='index.php?logout=1'></a>";
	                 }
	                 else{
	                   echo "<a href='login.php'>Login</a>";
	                 }
	               ?></small></strong></a>      
    </div>
</div>
</nav>
		  <?php 
		    if(isset($GLOBALS['errors'])){
		      $errors = $GLOBALS['errors'];
		      foreach($errors as $error){
		    	echo "<p class='has-error'>* $error</p>";
		      }
		    }
		    ?>
	<div class="container">
	<div>
	  <a href="index.php" class="btn-back">Return Home</a>
	</div>
	<div class="panel panel-default invoice"> 
		<div class="panel-heading"> 
			<h3 class="panel-title invoiceh3">PWS Prepaid Card</h3> 
		</div>
		<table class="table invoicetable">
			<tr><td>PWS Pin</td><td><?php echo $GLOBALS['cardpin'];?></td></tr>
			<tr><td>Card Unit</td><td><?php echo $GLOBALS['card_unit'];?></td></tr>
			<tr><td>Customer ID</td><td><?php echo $GLOBALS['cust_id'];?></td></tr>
			<tr><td>Time</td><td><?php echo $GLOBALS['tx_date'];?></td></tr>
		</table>
		<table>
		  <tr><button type="submit" class="btn btn-primary" name="submit" onclick="print()">Print Card</button></tr>
		</table>
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