<?php require("commons.php");?>
<?php require("config.php");?>
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

<p><h2 style="color:blue; text-align:center;">ABOUT US</h2></p>
<p>
		  PWC is the water utility responsible for the provision 
		  of urban water supply and wastewater management services 
		  in Nigeria. We are a corporatized organisation with full 
		  autonomy to undertake the responsibility of handling Government 
		  owned water supply and wastewater management assets in Nigeria.
		</p>
		<p>
		  Our operations are to be carried out at a commercial level, with 
		  the aim of achieving cost recovery for daily operations and maintenance
		  of plants. The paid for services will ensure sustainability and continuous 
		  service delivery to the Nigerian urban citizenry.
		</p>
		<p>
		  Access to Water Supply: we recognize that clean water is essential 
		  for health and human development and will
		  strive to ensure that every citizen of the country has equal access 
		  to safe, adequate and reliable water supply.
		  Strategy: To take all necessary measures needed for the involvement of Federal,
		  State and Local Governments, international development agencies, communities,
		  donor agencies, and the private sector to participate in providing water to 
		  every citizen of this country in a sustainable manner.
		</p>
		<p>
		  Urban Water Supply shall be provided by the Port Water Corporation (PWC) 
		  which shall be encouraged to collaborate with the private sector.
		  The PWC has 1 wastewater treatment plant that currently services some 
		  states  in Nigeria. We also have 8 water service stations that will be 
		  undergoing extensive upgrades and restoration as part of the corporations
		  5 year plan. The restoration activities involves rehabilitation and upgrade 
		  of pumps, pump houses and water quality testing laboratory to international standards.
		</p>
		</div>
		<p>
		  <h4 style="color:skyblue; text-align:center;">Appreciate water before you are thirsty! Appreciate all the good things before you
			need them! </h4>
		</p>
		<p class="pull-right"><a href="index.php" class="btn btn-primary btn-large no-margin" role="button">Return to Home Page</a></p>
		</body>
		</html>