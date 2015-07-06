<?php 
include "base-login.php"; 
require "password.php";
?>

<!DOCTYPE html>
<html>
<head>
        <title>Register</title>
		<!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
        <!-- Register CSS -->
        <link href="css/register.css" type="text/css" rel="stylesheet">
</head>

<body>


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

               
<?php
if(!empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['email']))
{    

    $username = $mysqli->real_escape_string($_POST['username']);
    $password = $mysqli->real_escape_string($_POST['password']);
    $password_confirm = $mysqli->real_escape_string($_POST['password-confirm']);
    $email = $mysqli->real_escape_string($_POST['email']);
    $email_confirm = $mysqli->real_escape_string($_POST['email-confirm']);

    if(!empty($password) && !empty($password_confirm) && !empty($email) && !empty($email_confirm)){
        if($password === $password_confirm){
            if($email === $email_confirm){
                 #$checkusername = mysqli_query($conn, "SELECT * FROM _accounts WHERE username='".$username."'");
                 if ($stmt = $mysqli->prepare("SELECT username FROM _accounts WHERE username=?")) {       
                        // Bind a variable to the parameter as a string. 
                        $stmt->bind_param("s", $user);
                     
                        // Execute the statement.
                        $stmt->execute();
                     
                        // Get the variables from the query.
                        $stmt->bind_result($user);
                    
                        // Fetch the data.
                        #IF THE USER ISNT IN THE DATABASE
                        if($stmt->fetch() == NULL){
                            if($user == NULL){
                                if ($stmt2 = $mysqli->prepare("INSERT INTO _accounts (username, password, email) VALUES (?, ?, ?)")) {
                                        // Bind the variables to the parameter as strings. 
                                        $pass = password_hash($password, PASSWORD_BCRYPT);
                                        $stmt2->bind_param("sss", $username, $pass, $email);
                                     
                                        // Execute the statement.
                                        $stmt2->execute();
                                     
                                        // Close the prepared statement.
                                        $stmt2->close();

                                        $_SESSION['Username'] = $username;
                                        $_SESSION['Email'] = $email;
                                        $_SESSION['LoggedIn'] = 1;

                                        header("Location:/index.php");
                                }else{
                                    echo "<h2>Error</h2>";
                                    echo "<p>Sorry, your registration failed. Please go back and try again.</p>";   
                                }     
                            }else{
                                echo "<h2>Error</h2>";
                                echo "<p>Sorry, that username is taken. Please go back and try again.</p>";
                            }
                        }
                     
                        // Close the prepared statement.
                        $stmt->close();
                 
                }
            }else{
                echo "<h2>Your emails do not match.</h2>";
            }
        }else{
            echo "<h2>Your passwords do not match.</h2>";
        }
 }else{
    echo "<h2>Please fill in the tables colums</h2>";
 }
}
else
{
    ?>
   <div class="container">
    <div class="row">
        <div class="col-md-6 centered">
            <div class="panel panel-default">
                <div class="panel-heading"> <strong class="">Create an Account!</strong>

                </div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" action="" method="post">
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
                            <label for="inputPassword3" class="col-sm-3 control-label">Confirm your Password</label>
                            <div class="col-sm-9">
                               <input type="password" class="form-control" required="" placeholder="Password" name="password-confirm">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-3 control-label">Email</label>
                            <div class="col-sm-9">
                               <input type="text" class="form-control" required="" placeholder="Email" name="email">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-3 control-label">Confirm your email</label>
                            <div class="col-sm-9">
                               <input type="text" class="form-control" required="" placeholder="Confirm your Email" name="email-confirm">
                            </div>
                        </div>
                        <div class="form-group last">
                            <div class="col-md-offset-3 col-md-3">
                                <button type="submit" class="btn btn-success btn-sm">Create account</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
     
    <?php
}
?>



</body>


</html>