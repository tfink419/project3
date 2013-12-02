<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laravel PHP Framework</title>
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="css/bootstrap-theme.css" rel="stylesheet">
    
</head>
<body>
   
     <div class="row-fluid">
        <div class="span12 well">
            <center><h1 class="text-muted credit">Airline Reservation System</h1></center>
        </div>
    </div>

    <div id="container" style="position:absolute; top:50%; margin-top:-200px; left:0; width:100%">
        <div id="extra_space" class="row" style="height:500px vertical-align:top"></div>
    </div>

    <div class="row" style="positon:relative"></br></br></br></br></br></br>
        <div style="height:30%; width:20%; margin: 0 auto; vertical-align:middle">
            @yield('content')
        </div>
    </div>

    <script src="//code.jquery.com/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>

    
    <nav class="navbar navbar-default navbar-fixed-bottom" style="padding-top:2%; padding-bottom:1%;">
        <div class="navbar-inner navbar-content-center">
            <p class="text-muted credit" style="text-align:center">UF CIS4301 Project 3</p>
        </div>
    </nav>
    

</body>
</html>
