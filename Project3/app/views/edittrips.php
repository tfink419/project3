<body style="background-image:url('http://www.hdwallpapers.in/walls/aeroplane-HD.jpg'); position:relative;">
<link href="/css/bootstrap.css" rel="stylesheet">
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
      <li class="active"> <?php echo '<li><a href="/homepage/' . $id . '">'?>Home</a></li>
      <li> <?php echo '<li><a href="/searchflights/' . $id . '">'?>Search Flights</a></li>
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
      <?php echo '<li><a href="/logout/' . $id . '">'?>
      Logout</a></li>
    </ul>
  </div><!-- /.navbar-collapse -->
</nav>

<div>
	<div style="padding-top:10px; padding-left:50px; padding-right:50px; opacity:0.9 ; z-index:2 ; display:block ; margin-left:auto ; margin-right:auto ; width:1200px ; height:600px ; background-color:#FFF ;">
	<?php 
		
	 echo '<h2>Trip Number '. $legs[0]->tripNum .'</h2><hr><br>';
	 echo '</br><div class="panel panel-primary">
		  <div class="panel-heading">Legs Involved</div><table class="table table-hover">
		  <tr>
		  <th>Leg Number</th>
		  <th>Departure</th>
		  <th>Destination</th>
		  <th>Seats Available</th>
		  <th>Plane</th>';

      for($i = 0; $i < count($legs); $i++)
      {
      	$l = $legs[$i];
      	$planeName = DB::table('Airplane')->where('ID','=',$l->airplaneID)->pluck('type');
		$planeID = DB::table('Airplane')->where('ID','=',$l->airplaneID)->pluck('ID');
        
        echo '<tr><td>' . '<a href="/editplane/' . $id . '/' . $l->tripNum . '/' . $l->legNum . '">' . $l->legNum . '</a></td>';
        echo '<td>' . $l->departureCode . '</td>';
        echo '<td>' . $l->destinationCode . '</td>';
        echo '<td>' . $l->seatsAvailable . '</td>';
        echo '<td>' . $planeName . '(ID:'. $planeID .')</td>';
        echo '</tr>';
      }
?>
  
    </tr>
  </table>
</div>
</div>

<script src="../js/jquery.js"></script>
<script src="../js/bootstrap.js"></script>
</body>