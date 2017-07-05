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
    <link href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet">
    <link rel="stylesheet" href="/chosen.css">
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>

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
<!--<script src="/js/jquery-1.12.4.min.js"></script>-->
<script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js" integrity="sha256-0YPKAwZP7Mp3ALMRVB2i8GXeEndvCq3eSl/WsAl1Ryk=" crossorigin="anonymous"></script>
<script src="/js/jquery.cookie.js"></script>
<script src="/js/jquery.countdown.js"></script>

<script>
$( function() {
	$( ".draggable" ).draggable({ snap: true });

} );
</script>

  <script>
  $( function() {
    $( ".sortable" ).sortable();
    $( ".sortable" ).disableSelection();
  } );
  </script>

<script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey={$TINYMCE}"></script>
<script>
tinymce.init({
  selector: 'textarea',
  height: 200,
  menubar: false,
  plugins: [
    'advlist autolink lists link image charmap print preview anchor',
    'searchreplace visualblocks code fullscreen',
    'insertdatetime media table contextmenu paste code'
  ],
  toolbar: 'undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent',
  content_css: [
    '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
    '//www.tinymce.com/css/codepen.min.css']
});
</script>

<style>
.modal {
  text-align: center;
  padding: 0!important;
}

.modal:before {
  content: '';
  display: inline-block;
  height: 100%;
  vertical-align: middle;
  margin-right: -4px;
}

.modal-dialog {
  display: inline-block;
  text-align: left;
  vertical-align: middle;
}
</style>

<script>
	// define angular module/app
	var formApp = angular.module('formApp', []);

	// create angular controller and pass in $scope and $http
	//function formController($scope, $http) {
	//	$scope.formData = {};
	//}
</script>

</head>
<body ng-app="formApp">

{if $logged eq "yes"}
<script>
function Show_Countdown() {
  //var counter = 5;
  var counter = {$counter};
  var timer = setInterval(function () {
        counter = (counter - 1);

        if (counter < 0) 
        {
            clearInterval(timer);
            $('#myModalWarning').modal('show');
        }
    }, 1000);
}
Show_Countdown();
</script>
{/if}


    <nav class="navbar navbar-default no-margin">
    <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header fixed-brand">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"  id="menu-toggle" onclick="js_toggle();">
                      <span class="glyphicon glyphicon-th-large" aria-hidden="true"></span>
                    </button>
                    <a class="navbar-brand" href="/"><img src="/assets/img/af-df_hdr_logo.png" height="64" /></a>
                </div><!-- navbar-header-->
 
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                            <ul class="nav navbar-nav">
                                <li class="active" ><button class="navbar-toggle collapse in" data-toggle="collapse" id="menu-toggle-2" onclick="js_toggle();"> 
					<span class="glyphicon glyphicon-th-large" aria-hidden="true"></span>
				</button></li>
                            </ul>
                </div><!-- bs-example-navbar-collapse-1 -->
    </nav>

   <script>
   function js_toggle() {
      var toggle = $.cookie("menu_toggle");

      if (toggle == "off") {
         $.cookie('menu_toggle', 'on');
      }
      if (toggle == "on") {
         $.cookie('menu_toggle', 'off');
      }

      if (typeof toggle == 'undefined') {
         $.cookie('menu_toggle','off');
         var toggle = $.cookie("menu_toggle");
      };
   }
   </script>


<!-- Modal -->
<div id="myModalWarning" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Warning: Your session will expire soon</h4>
      </div>
      <div class="modal-body">
        <p>Your session will expire in 5 minutes. To stay logged in click below. If you are working on something important click <b>CANCEL</b> and finish your task in less then 5 minutes.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>&nbsp;
        <button type="button" onclick="repaint_screen()" class="btn btn-primary" data-dismiss="modal">Yes - Extend My Login</button>
      </div>

    <script>
    function repaint_screen() {
      extend_login();

      setTimeout(function() {
        window.location.reload();
      }
      ,2000);


    }

    function extend_login() {
        $.get('/ajax/extend_login.php',
        function(php_msg) {     
                $("#null").html(php_msg);
        });
    }
    </script>


    </div>

  </div>
</div>


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
