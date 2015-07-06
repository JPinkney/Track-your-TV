<?php 
include "base-login.php"; 
require "password.php";
?>

<!DOCTYPE html>
<html>
<head>
        <title>Login</title>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
        <!-- Login CSS -->
        <link href="css/login.css" type="text/css" rel="stylesheet">

</head>


<body>
 <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

<?php
if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']))
{
             header("Location:/index.php");
}
elseif(!empty($_POST['username']) && !empty($_POST['password']))
{
    $username = $mysqli->real_escape_string($_POST['username']);
    $password = $mysqli->real_escape_string($_POST['password']);

    if ($stmt = $mysqli->prepare("SELECT password FROM _accounts WHERE username=?")) {
     
        // Bind a variable to the parameter as a string. 
        $stmt->bind_param("s", $username);
     
        // Execute the statement.
        $stmt->execute();
     
        // Get the variables from the query.
        $stmt->bind_result($hash);
        $stmt->store_result();
     
        // Fetch the data.
        if($stmt->fetch()){
            if(password_verify($password, $hash)){
                if ($stmt2 = $mysqli->prepare("SELECT username, email FROM _accounts WHERE username=? and password=?")) {
                 
                    // Bind a variable to the parameter as a string. 
                    $stmt2->bind_param("ss", $username, $hash);
                 
                    // Execute the statement.
                    $stmt2->execute();
                 
                    // Get the variables from the query.
                    $stmt2->bind_result($user,$email);
                 
                    // Fetch the data.
                    if($stmt2->fetch()){
                        $_SESSION['Username'] = $user;
                        $_SESSION['Email'] = $email;
                        $_SESSION['LoggedIn'] = 1;
                
                        header("Location:/index.php");
                    }else{
                        echo "<h2>ERROR</h2>";
                        echo "<h6>Unfortunately your account could not be found, please try again.</h6>";
                    }
                 
                    // Close the prepared statement.
                    $stmt2->close();
                 
                }
            }else{
                echo "<h1>Invalid password</h2>";
            }
        }
     
        // Close the prepared statement.
        $stmt->close();
     
    }

    
}
else
{
    ?>
     
   <div class="container">
    <div class="row">
        <div class="col-md-4 centered">
            <div class="panel panel-default">
                <div class="panel-heading"><strong>Login</strong></div>

                <div class="panel-body">
                    <form class="form-horizontal" action="" role="form" method="post">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Username</label>
                            <div class="col-sm-9">
                                <input type="text" required="" placeholder="Username" class="form-control" name="username">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-3 control-label">Password</label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control" required="" placeholder="Password" name="password">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-9">
                                <div class="checkbox">
                                    <label class="">
                                        <input type="checkbox" class="">Remember me</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group last">
                            <div class="col-md-offset-3 col-md-3">
                                <button type="submit" class="btn btn-success btn-sm">Sign in</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="panel-footer">Not Registered? <a href="/register.php">Register here</a>
                </div>
            </div>
        </div>
    </div>
     
   <?php
}
?>


</body>
</html>