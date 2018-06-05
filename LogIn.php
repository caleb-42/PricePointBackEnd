<?php include_once ("assets/php/login.php");
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
            <div class = "adminform row justify-content-center" style="height: 80vh;">
                <form autocomplete="off" role="form" method="post" action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="align-self-center text-center px-3 py-5">
                    <img  class = "" width = 55% height = 55% src = "assets/img/logo.png"/>
                    <h5 class = "Title mb-5 mx-5 mt-3">ADMIN PANEL</h5>
                    <div class="row mb-4 pb-3">
                        <label for="username" class="align-self-center offset-1 col-5">Username</label>
                        <input type="text" name="username" class="form-control details col-5" required id="username" required/>
                    </div>
                    <div class="row mb-4">
                        <label for="password" class="align-self-center offset-1 col-5 ">Password</label>
                        <input type="password" name="password" class="form-control details col-5" id="password" required/>
                    </div>
                    <div class="form-group mt-5">
                        <button type="submit" class="btn btn-md btn-success" name="B1" style="">Create User <span class="glyphicon glyphicon-log-in"></span></button> 
                    </div>
                    <div class="mt-1 f-14"><?php echo $output; ?></div>
                </form>
            </div>
        </div>
        <footer class="row justify-content-center f-12 mt-3">
            <p>&copy; 2012 - 2017 Webplay Nig Ltd. All Rights Reserved.</p>
        </footer>

        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <script src="../assets/js/ie10-viewport-bug-workaround.html"></script>
    </body>
</html>