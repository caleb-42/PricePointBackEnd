<?php include_once ("assets/php/login.php");
date_default_timezone_set('Africa/Lagos');
$date=date("D M d, Y g:i a");
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>PrimePoint Admin Panel</title>

        <!-- jQuery core -->
        <script src="./vendors/jquery/jquery-3.1.1.min.js"></script>

        <!-- Bootstrap core-->
        <link rel="stylesheet" href="./vendors/bootstrap4-alpha/css/bootstrap.min.css">
        <link rel="stylesheet" href="./vendors/font-awesome-4.7.0/css/font-awesome.min.css">
        <script src="./vendors/bootstrap4-alpha/js/bootstrap.min.js"></script>

        <!-- Custom styles for this template -->
        <link href="./assets/css/logIn.css" rel="stylesheet">

        <style>

        </style>
    </head>
    <body>
        <div class="container">
            <div class = "adminform row justify-content-center" style="height: 100vh;">
                <form autocomplete="off" role="form" method="post" action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="align-self-center">
                    <div class="formhd text-center px-4 py-4">
                        <img  class = "" width = 50% height = 50% src = "assets/img/logo.png"/>
                        <h5 class = "Title mb-5 mx-5 mt-3">ADMIN PANEL</h5>
                        <div class="row mb-4 pb-2">
                            <label for="username" class="align-self-center offset-1 col-4">Username</label>
                            <input type="text" name="username" class="form-control details col-6" required id="username" required/>
                        </div>
                        <div class="row mb-4">
                            <label for="password" class="align-self-center offset-1 col-4 ">Password</label>
                            <input type="password" name="password" class="form-control details col-6" id="password" required/>
                        </div>
                        <div class="form-group mt-5">
                            <button type="submit" class="btn btn-md btn-success" name="B1" style="" onclick="login();">Sign in </button> 
                        </div>
                    </div>
                    <div class="row justify-content-center mt-4" style="height:120px;">
                        <img id="sendGif" class="" src="assets/img/loader.gif" style = "" width="100px" height="70px" />
                        <p id="output" class="str" style="opacity:1; font-size:17px; font-weight: 700;" ><?php echo "<script type = 'text/javascript'>
            jQuery(function(){
            jQuery('#sendGif').toggleClass('notvisible');
            if('$output' != ''){
            if ('$output' != 'Authorization Granted') {
                jQuery('#output').css('color', '#333');
            } else {
                jQuery('#output').css('color', '#333');
            }
            jQuery('#output').text('$output').fadeTo('slow', 1).delay(2000)
            .fadeTo('slow', 0,function(){
            jQuery('#output').text('');
            });
            jQuery('.btn').prop('disabled', false);}
            });</script>"?></p>
                    </div>
                </form>
            </div>
        </div>
        <footer class="f-12">
            <p class = "text-center">&copy; 2012 - 2017 Webplay Nig Ltd. All Rights Reserved.</p>
            <p class = "text-center"><?php echo $date ?></p>
        </footer>

        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <!--<script src="../assets/js/ie10-viewport-bug-workaround.html"></script>-->
    </body>
    <script>
        function login(){
            /*$(".btn").prop('disabled', true);*/
            if($("#username").val() != "" && $("#password").val() != ""){
                jQuery('#sendGif').toggleClass('notvisible');
            }
        }

    </script>
</html>