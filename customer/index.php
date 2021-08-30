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
  
  <script type="text/javascript">
	var slideimages=new Array();
	slideimages[0]=new Array();
	slideimages[1]=new Array();
	slideimages[2]=new Array();
	slideimages[3]=new Array();
	
	slideimages[0].src="../images/4.jpg";
	slideimages[1].src="../images/7.jpg";
	slideimages[2].src="../images/projectpics2.jpg";
	slideimages[3].src="../images/9.jpg";
  </script>
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

				<marquee behavior="slide" direction="left"><h2 class="welcome">WELCOME TO PWS COMPUTERIZED WATER BILLING SYSTEM</h2></marquee>
              <img src="../images/6.jpg" id="slide" width="1200" height="450"/>
			  
			  <script type="text/javascript">
				var step=0;
				function slideit(){
					if(!document.images)
						return;
					document.getElementById('slide').src=slideimages[step].src;
					if(step<3)
						step++;
					else
						step=0;
					setTimeout("slideit()",4000)
				}
				slideit();
			  </script>
<div class="jombotron">
	<div class="container">
   <h2 class="welcome">About Us</h2>
   <p>
		  PWC is the water utility responsible for the provision 
		  of urban water supply and wastewater management services 
		  in Nigeria. We are a corporatized organisation with full 
		  autonomy to undertake the responsibility of handling Government 
		  owned water supply and wastewater management assets in Nigeria.
		</p>
		<p><a href="abtus.php" class="btn btn-primary btn-large no-margin" role="button">Learn More</a></p>
   </div>
</div>

<div class="container">
	<div class="col-md-4 my-background">
		  <p><h2 class="my-textalign">News from PWS</h2></p>
		  <p><span>May 15,2016  Alaja Solar Water Project completed.</span></p>
		  <p><span>April 6,2016  Installation of 500 new Prepaid Water Meter commences in Onitsha.</span></p>
		  <p><span>March 10,2016  International Seminar on Water Resource Management to commence April 2,2016, Enugu.</p>
		  <p><span>Feb. 27,2016  UNICEF donates 400 Prepaid Water Meters to PWS</p>
		  <p><span>Recruitment of New staff at PWS to start next week, visit the head office for more information</p>
		  <p><span>July, 2016 PWS promises to continually provide good water supply to its customers and also thanks customers for their corperation </p>
		  <p><span>July, 2016 Bottled water now available in PWS customers/clients should visit the head office/branch office for information </p>
	</div>
	<div class="col-md-4" width="690px" height="233px">
		<img src="../images/projectpics4.jpg" class="img-responsive">
	</div>
	<div class="col-md-4 my-background">
		  <marquee onMouseOver="this.scrollAmount=0" onMouseOut="this.scrollAmount=2" scrollamount="2" direction="down" loop="true">
		  <p><h2 class="my-textalign">Notification from PWS</h2></p>
		  <p><span>May 15,2016  Alaja Solar Water Project completed.</span></p>
		  <p><span>April 6,2016  Installation of 500 new Prepaid Water Meter commences in Onitsha.</span></p>
		  <p><span>March 10,2016  International Seminar on Water Resource Management to commence April 2,2016, Enugu.</span></p>
		  <p><span>Feb. 27,2016  UNICEF donates 400 Prepaid Water Meters to PWS</span></p>
		  <p><span>Feb. 27,2016  All customers of PWS should endeavour to pay their debt on or before 2 weeks of notification</span></p>
		  <p><span>Feb. 27,2016  All postpaid PWS customers should pay their bill after every month</span></p>
		  <p><span>Feb. PWS wishes all its Customers, friends and well-wishers a happy festive season</span></p></marquee>

	</div>
</div>

      
      <div class="container">
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
 <?php
  if(isset($_GET['logout'])){
  	logout();
  }
  set_page("index");?>

 
 <script type="text/javascript">
             var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
             var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
   </script>
   
       
   <script  src="js/jquery.js"></script>
   <script  src="js/bootstrap.min.js"></script>    

</body>
</html>

