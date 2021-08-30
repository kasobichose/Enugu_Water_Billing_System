<?php require("commons.php");?>
<?php require("config.php");?>
<?php

  if(isset($_POST['submit'])){
     extract($_POST);
     clean_inputs();
     if(validate_input()){
	     check_creditors();
	  
     }
   }

   function validate_input(){
     extract($_POST); 

     if($month=='noselect'){
	     $error[] = "No month selected";
     }

	  if(isset($error)){
		 $GLOBALS['errors'] = $error;
         return false;
    }
    else{
       return true;
    }
  }

  function check_creditors(){
	  extract($_POST); 
	  $db = $GLOBALS['db'];
	  $stmt = $db->prepare("SELECT * FROM users WHERE billtype = :billtype");
    $stmt->execute(array(':billtype' => 'Postpaid'));
    $postpaid_users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $GLOBALS['month'] = $month;

    foreach($postpaid_users as $post){
	     $cust_id = $post['userid'];
  	   $stmt = $db->prepare("SELECT * FROM postpaid_receipt WHERE month = :month AND cust_id = :cust_id");
      $stmt->execute(array(':month' => $month,':cust_id' => $cust_id ));
      if($stmt->rowCount() == 0){
	      $creditors[]=$post;
	      $GLOBALS['creditors'] = $creditors;
      //user has not paid his bill, add his name to creditors
      }
    }
   if(isset($creditors)){
	   $GLOBALS['creds'] = true;
	  }
  } 
  set_page("login");
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
      <ul class="nav navbar-nav pull-right">
                       <li  class="active "><a  href="index.php">Home</a></li> 
                       <li  class=" active "><a  href="users.php">Customers List</a></li> 
                       <li  class=" active "><a  href="creditors.php">Debtors</a></li>
      </ul>
      
    </div>
  </div>
</nav>
<div class="container" style="margin-bottom:10px;">
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
		<form role="form" id="prepaid-form" method="post" action="creditors.php" > 
		<table width="300" height="150" border="0" align="center" > 
		<tr>
				<td><span id="sprytextfield2">
				<label for="userid">
						View Company's Postpaid Users Debtors
				</label><br /></span></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr> 
				<th><label for="month">Month</label><br />
					<select class="StyleTxtField2" id="month"name="month"> 
						<option value="noselect">-----Select Month-----</option>
						<option value="January 2016">Janary 2016</option> 
						<option value="February 2016">February 2016</option>
						<option value="March 2016">March 2016</option>
						<option value="April 2016">April 2016</option>
						<option value="May 2016">May 2016</option>
						<option value="June 2016">June 2016</option>															
					</select></th>
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

	<div class="panel panel-default invoice">
		<?php 
		    if(isset($GLOBALS['creds'])){
		  
		    ?>			
		<div class="panel-heading"> 
			<h3 class="panel-title invoiceh3" ><h2 style="text-align:center;"><?php $month =$GLOBALS['month'];echo "Debtors for $month";?></h2></h3> 
		</div>
		<table class="table invoicetable">
			  <?php $creditors = $GLOBALS['creditors'];
		  foreach($creditors as $creds){?>
		    <tr><td><?php echo $creds['firstname'] .' '.$creds['lastname'];?></td><td><?php $id=$creds['userid']; echo "<a href='index.php?id=$id'>See details</a>";?></td> </tr>
		<?php }} ?>
		</table>
	</div>
       <div class="container" style="margin-top:30px;">
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