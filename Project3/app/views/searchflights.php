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
    <a class="navbar-brand" href="#">Airline Reservation System</a>
  </div>

  <!-- Collect the nav links, forms, and other content for toggling -->
  <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
    <ul class="nav navbar-nav">
      <li class="active"> <?php echo '<li><a href="../homepage/' . $id . '">'?>Home</a></li>
      <li><a href="">Search Flights</a></li>
      <li class="active"> <?php echo '<li><a href="../myflights/' . $id . '">'?>My Flights</a></li>
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
	<div style="padding-top:10px; padding-left:50px; opacity:0.9 ; z-index:2 ; display:block ; margin-left:auto ; margin-right:auto ; width:1200px ; height:600px ; background-color:#FFF ;">
		<h2>Flight Search</h2>
		<hr>
		<form id="edit_project" method="post">
      	<div class="row">
        <div class="col-lg-4">
          <label for="dep_date">Departure Date (mm/dd/yyyy)</label>
          <input type="text" name="dep_date" class="form-control"> </br>
          <label for="dep_time">Departure Time</label></br>
          <input type="text" name="dep_time" class="form-control"> </br>
          <label for="dep_code">Departure Airport Code</label></br>
          <input type="text" name="dep_code" class="form-control"> </br>
          <label for="dest_code">Destination Airport Code</label></br>
          <input type="text" name="dest_code" class="form-control"> </br></br>
          <input type="submit" value="Search" class="btn btn-primary"/>
        </div>
        <div class="col-lg-1">
        <h3 class="text text-muted">OR<h3>
        </div>
        <div class="col-lg-4">
        <label>Search Within +/- 2 Days of Date</label><br>
          <input type="text" name="date1" class="form-control"> </br>
          <label for="dep_code">Departure Airport Code</label></br>
          <input type="text" name="dep_code2" class="form-control"> </br>
          <label for="dest_code">Destination Airport Code</label></br>
          <input type="text" name="dest_code2" class="form-control"> </br></br>
        </div>
      </div>
    </form>
	</div>
</div>

<script src="../js/jquery.js"></script>
<script src="../js/bootstrap.js"></script>
</body>