<body style="background-image:url('http://www.hdwallpapers.in/walls/aeroplane-HD.jpg'); position:relative;">
<link href="../css/bootstrap.css" rel="stylesheet">
<nav class="navbar navbar-default" role="navigation">
  <!-- Brand and toggle get grouped for better mobile display -->
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand">Airline Reservation System</a>
  </div>

  <!-- Collect the nav links, forms, and other content for toggling -->
  <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
    <ul class="nav navbar-nav">
      <li class="active"> <?php echo '<li><a href="../homepage/' . $id . '">'?>Home</a></li>
      <?php echo '<li><a href="../searchflights/' . $id . '">'?>Search Flights</a></li>
      <?php echo '<li><a href="../myflights/' . $id . '">'?>My Flights</a></li>
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
      <?php echo '<li><a href="../logout/' . $id . '">'?>
      Logout</a></li>
    </ul>
  </div><!-- /.navbar-collapse -->
</nav>

<div>
	<div style="padding-top:10px; opacity:0.9 ; z-index:2 ; display:block ; margin-left:auto ; margin-right:auto ; width:1200px ; height:600px ; background-color:#FFF ;">
		
<div class="jumbotron" style="width:95%; margin: 0 auto; border-radius: 10px">
  <div class="container">
    <h1>Welcome back!</h1>
    <?php 
    	$email = DB::table('users')->where('id', $id)->pluck('email');
    	$numTrips = DB::table('Reservation')->where('email', $email)->count();
    	//$numTrips = Reservation::whereRaw('email = '  . $email)->count();
    ?>
    <p><?php echo "You have " . $numTrips . " booked trips."  ?></p>
    <?php echo '<p><a class="btn btn-primary btn-lg" href="../myflights/' . $id . '"' . '>' ?>My Trips</a></p>
  </div>
</div>
	</div>
</div>

<script src="../js/jquery.js"></script>
<script src="../js/bootstrap.js"></script>
</body>