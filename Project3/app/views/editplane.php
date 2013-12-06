<body style="background-image:url('http://www.hdwallpapers.in/walls/aeroplane-HD.jpg'); position:relative;">
<link href="../../../css/bootstrap.css" rel="stylesheet">
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
	 $leg = DB::table('Flight_leg')->where('legNum','=',$legNum)->where('tripNum','=',$tripNum)->get();
	 $plane = DB::table('Airplane')->where('ID','=',$leg[0]->airplaneID)->get();
	 echo '<h2>All Planes Available for Switching in Leg '. $legNum .' of Trip '. $tripNum .'</h2><hr><br>';
	 echo '</br><div class="panel panel-primary">
		  <div class="panel-heading">Planes - Current Plane Used: '. $plane[0]->type .'(ID:'. $plane[0]->ID .')</div><table class="table table-hover">
		  <tr>
		  <th>Plane ID</th>
		  <th>Plane Type</th>
		  <th>Maximum Seats Available</th>';
	  $planes = DB::table('Airplane')->select(DB::raw('*'))->where('numSeats','>=',$plane[0]->numSeats)->get();
      for($i = 0; $i < count($planes); $i++)
      {
      	$p = $planes[$i];
        
        echo '<tr><td>' . '<a href="/confirmedit/' . $id . '/' . $tripNum . '/' . $legNum . '/' . $p->ID . '">' . $p->ID . '</a></td>';
        echo '<td>' . $p->type . '</td>';
        echo '<td>' . $p->numSeats . '</td>';
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