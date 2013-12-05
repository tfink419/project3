<body style="background-image:url('http://www.hdwallpapers.in/walls/aeroplane-HD.jpg'); position:relative;">
<link href="../../css/bootstrap.css" rel="stylesheet">
<nav class="navbar navbar-default" role="navigation">
  <!-- Brand and toggle get grouped for better mobile display -->
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="#">Airline Reservation System</a>
  </div>

  <!-- Collect the nav links, forms, and other content for toggling -->
  <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
    <ul class="nav navbar-nav">
      <li class="active"> <?php echo '<li><a href="../../../homepage/' . $id . '">'?>Home</a></li>
      <?php echo '<li><a href="../../../searchflights/' . $id . '">'?>Search Flights</a></li>
      <li><a href="#">My Flights</a></li>
     <!-- <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">My Flights <b class="caret"></b></a>
        <ul class="dropdown-menu">
          <li><a href="#">Action</a></li>
          <li><a href="#">Another action</a></li>
          <li><a href="#">Something else here</a></li>
          <li class="divider"></li>
          <li><a href="#">Separated link</a></li>
          <li class="divider"></li>
          <li><a href="#">One more separated link</a></li>
        </ul>
      </li> -->
    </ul>
  
    <ul class="nav navbar-nav navbar-right">
      <?php echo '<li><a href="../../../logout/' . $id . '">'?>
      Logout</a></li>
    </ul>
  </div><!-- /.navbar-collapse -->
</nav>

<div>
	<div style="padding-left:50px; padding-right:50px; padding-top:10px; opacity:0.9 ; z-index:2 ; display:block ; margin-left:auto ; margin-right:auto ; width:1200px ; height:600px ; background-color:#FFF ;">
		<h2>Flight Information</h2>
		<hr>
		<?php 
			$flight = $currentTrip = DB::table('trip')->where('tripNum', '=', $tripNum)->get(); 
			$flight = $flight[0];
		?>
		<div class="row">
		<div class="col-md-4">
		<label>Trip Number:&nbsp</label><?php echo $flight->tripNum;?><br>
		<label>Airline:&nbsp</label><?php echo $flight->airline;?><br>
		<label>Departure Airport:&nbsp</label><?php echo $flight->depCode;?><br>
		<label>Destination Airport:&nbsp</label><?php echo $flight->destCode;?><br>
		<label>Number of Flight Legs:&nbsp</label><?php echo $flight->numLegs;?><br>
		</div>
		<div class="col-md-1">
		</div>
		<div class="col-md-4">
		</div>
		</div>
		<br><br<br><br><br><br<br><br>
		<input type="submit" class="btn btn-primary" value="Book This Flight"/>
		
		<?php
			$isAdmin = DB::table('users')->select('isAdmin')->where('isAdmin', '=', 1);
			
			//If the user is an admin (airline agent) give additional options
			if($isAdmin)
			{
				echo '<input type="submit" class="btn btn-warning" value="Edit Flight Info"/>';
				echo '&nbsp';
				echo '<input type="submit" class="btn btn-danger" value="Delete Flight"/>';
			}
		?>
	</div>
</div>

<script src="../../js/jquery.js"></script>
<script src="../../js/bootstrap.js"></script>
</body>