<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Aggressor Fleet :: Reservation System</title>
    <meta name="author" content="Custom PHP Design : Robert Saylor : http://www.customphpdesign.com">
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/simple-sidebar.css" rel="stylesheet">
    <link href="/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <link rel="stylesheet" href="/chosen.css">

    <link rel="stylesheet" type="text/css" href="/css/jquery-gmaps-latlon-picker.css"/>

    <style>
    .table-hover tbody tr:hover td, .table-hover tbody tr:hover th {
      background-color: #00d4ff;
    }

.navbar-brand,
.navbar-nav li a {
    line-height: 68px;
    height: 68px;
    padding-top: 0;
}

    </style>

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
{/literal}

</head>
<body>
    <nav class="navbar navbar-default no-margin">
    <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header fixed-brand">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"  id="menu-toggle">
                      <span class="glyphicon glyphicon-th-large" aria-hidden="true"></span>
                    </button>
                    <a class="navbar-brand" href="/"><img src="/assets/img/af-df_hdr_logo.png" height="64" /></a>
                </div><!-- navbar-header-->
 
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                            <ul class="nav navbar-nav">
                                <li class="active" ><button class="navbar-toggle collapse in" data-toggle="collapse" id="menu-toggle-2"> 
					<span class="glyphicon glyphicon-th-large" aria-hidden="true"></span>
				</button></li>
                            </ul>
                </div><!-- bs-example-navbar-collapse-1 -->
    </nav>
    <div id="wrapper">
        <!-- Sidebar -->
	{if $logged eq "yes"}
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav nav-pills nav-stacked" id="menu">
 

                <li>
                    <a href="/"><span class="fa-stack fa-lg pull-left"><i class="fa fa-desktop fa-stack-1x "></i></span>Main Menu</a>
                </li>
                <li>
                    <a href="/profile"> <span class="fa-stack fa-lg pull-left"><i class="fa fa-user fa-stack-1x "></i></span>My Profile</a>
                </li>
                <li>
                    <a href="/logout"><span class="fa-stack fa-lg pull-left"><i class="fa fa-sign-out fa-stack-1x "></i></span>Log Out</a>
                </li>

            </ul>
        </div><!-- /#sidebar-wrapper -->
	{/if}
        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid xyz">
