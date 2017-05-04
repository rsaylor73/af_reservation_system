<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Aggressor Fleet</title>
	<!-- BOOTSTRAP STYLES-->
    <link href="/assets/css/bootstrap.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.35.3/css/bootstrap-dialog.css" rel="stylesheet">

     <!-- FONTAWESOME STYLES-->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        <!-- CUSTOM STYLES-->
    <link href="/assets/css/custom.css" rel="stylesheet" />
     <!-- GOOGLE FONTS-->
     <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

    <script src="/assets/js/jquery-1.10.2.js"></script>
    <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js" integrity="sha256-0YPKAwZP7Mp3ALMRVB2i8GXeEndvCq3eSl/WsAl1Ryk=" crossorigin="anonymous"></script>
    <script src="/assets/js/bootstrap.min.js"></script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBQbQO-EyjRgdLPbzcAJk3kelHqYCPBhvs"></script>
    <link rel="stylesheet" type="text/css" href="/css/jquery-gmaps-latlon-picker.css"/>
    <script src="/js/jquery-gmaps-latlon-picker.js"></script>


{literal}
<script>
  function onSubmit(token) {

	var value = document.getElementById('field').value;
	// Or if you are using jQuery $('#field').val()
	$.get('/ajax/forgotpassword.php',
        {field: value},
        function(php_msg) {
        	$("#forgotpassword").html(php_msg);
        });


	//alert('thanks ' + document.getElementById('field').value);
  }

  function validate(event) {
    event.preventDefault();
    if (!document.getElementById('field').value) {
      alert("Your email is required.");
    } else {
      grecaptcha.execute();
    }
  }

  function onload() {
    var element = document.getElementById('submit');
    element.onclick = validate;
  }
</script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
{/literal}


    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #floating-panel {
        position: absolute;
        top: 10px;
        left: 25%;
        z-index: 5;
        background-color: #fff;
        padding: 5px;
        border: 1px solid #999;
        text-align: center;
        font-family: 'Roboto','sans-serif';
        line-height: 30px;
        padding-left: 10px;
      }
    </style>

</head>
<body>
     
           
          
    <div id="wrapper">



         <div class="navbar navbar-default navbar-fixed-top">
            <div class="adjust-nav">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">
                        <img src="/assets/img/af-df_hdr_logo.png" height="64" />

                    </a><br><br><br>
                    
                </div>
              
            </div>
        </div>

	{if $logged eq "yes"}
        <!-- /. NAV TOP  -->
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
                    <li>
                        <a href="/index.php" ><i class="fa fa-desktop"></i>Main Menu</a>
                    </li>
                    <li>
                        <a href="/profile"><i class="fa fa-user"></i>My Profile</a>
                    </li>
                    <li>
                        <a href="/logout"><i class="fa fa-sign-out"></i>Logout</a>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- /. NAV SIDE  -->
	{/if}

        <div id="page-wrapper" >
            <div id="page-inner">
		<br> 




