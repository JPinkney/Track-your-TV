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

<div class="container">
    <div class="row">
        <div class="col-md-6 centered">
            <div class="panel panel-default">
                <div class="panel-heading"> <strong class="">Settings</strong>

                </div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" action="/scripts/accountValidation.php" method="post" id="main-form" name="main-form">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Username</label>
                            <div class="col-sm-9">
                                    <input type="text" placeholder=<?php $_SESSION["Username"] ?> class="form-control" name="username" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-3 control-label">Password</label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control" required="" placeholder="Password" name="password">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Reset password</label>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-3 control-label">Email</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" placeholder=<?php $_SESSION["Email"] ?>  name="email">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-3 control-label">Confirm your email</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" required="" placeholder="Confirm your Email" name="email-confirm">
                            </div>
                        </div>
                        <div class="col-md-offset-3 col-md-3">
                            <button type="submit" id="submit-button" name="submit-button" class="btn btn-success btn-sm">Create account</button>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>


</body>


</html>