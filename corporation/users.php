<?php require("commons.php");?>
<?php require("config.php");?>
<?php
  $GLOBALS['submit'] = true;
  $db = $GLOBALS['db'];

  $stmt = $db->prepare("SELECT * FROM users WHERE billtype = :billtype");
  $stmt->execute(array(':billtype' => 'Prepaid'));
  $prepaid_users = $stmt->fetchAll(PDO::FETCH_ASSOC);

  
  $stmt = $db->prepare("SELECT * FROM users WHERE billtype = :billtype");
  $stmt->execute(array(':billtype' => 'Postpaid'));
  $postpaid_users = $stmt->fetchAll(PDO::FETCH_ASSOC);
 
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
      <ul class="nav navbar-nav pull-right">
                       <li  class="active "><a  href="index.php">Home</a></li> 
                       <li  class=" active "><a  href="users.php">Customers List</a></li> 
                       <li  class=" active "><a  href="creditors.php">Debtors</a></li>
      </ul>
      
    </div>
  </div>
</nav>

<div class="container ">
			<div class="panel panel-default invoice"> 
		<div class="panel-heading"> 
			<h3 class="panel-title invoiceh3"><h2 style="text-align:center">Prepaid Users</h2></h3> 
		</div>
		<table class="table invoicetable">
			 <?php  $prepaid_users = $GLOBALS['prepaid_users'];
		  foreach($prepaid_users as $pre){ ?>
     <tr><td><?php echo $pre['firstname'].' '.$pre['lastname'];?></td><td><?php $id=$pre['userid']; echo "<a href='index.php?id=$id'>See details</a>";?></td> </tr>
		<?php } ?>
		</table>
		<div class="panel-heading"> 
			<h3 class="panel-title invoiceh3"><h2 style="text-align:center">Postpaid Users</h2></h3> 
		</div>
		<table class="table invoicetable">
			 <?php $postpaid_users = $GLOBALS['postpaid_users'];
		  foreach($postpaid_users as $post){ ?>
     <tr><td><?php echo $post['firstname'] .' '.$post['lastname'];?></td><td><?php $id=$post['userid']; echo "<a href='index.php?id=$id'>See details</a>";?></td> </tr>
		<?php } ?>
		</table>
	</div>

		<div>
		 <button type="submit" class="btn btn-primary" name="submit" onclick="print()">PRINT LIST</button>
	</div>
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