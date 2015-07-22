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


        <style type="text/css">
            .vertical-alignment-helper {
                display:table;
                height: 100%;
                width: 100%;
                pointer-events:none; /* This makes sure that we can still click outside of the modal to close it */
            }
            .vertical-align-center {
                /* To center vertically */
                display: table-cell;
                vertical-align: middle;
                pointer-events:none;
            }
            .modal-content {
                /* Bootstrap sets the size of the modal in the modal-dialog class, we need to inherit it */
                width:inherit;
                height:inherit;
                /* To center horizontally */
                margin: 0 auto;
                pointer-events: all;
            }
        </style>
</head>

<body>
 <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

<div class="container">
    <div class="row">
        <div class="col-md-4 centered">
            <div class="panel panel-default">
                <div class="panel-heading"><strong>Login</strong></div>

                <div class="panel-body">
                    <form class="form-horizontal" action="/scripts/loginVerification.php" role="form" method="post">
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
                                <button type="submit" id="submit-button" name="submit-button" class="btn btn-success btn-sm">Sign in</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="panel-footer">Not Registered? <a href="/register.php">Register here</a>
                </div>
            </div>
        </div>
    </div>
</div>

 <button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">Launch demo modal</button>

 <!-- Modal -->
 <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
     <div class="vertical-alignment-helper">
         <div class="modal-dialog vertical-align-center">
             <div class="modal-content">
                 <div class="panel-heading">
                     <h3 class="panel-title">Sign In</h3>
                 </div>
                 <div class="panel-body">
                     <form role="form">
                         <fieldset>
                             <div class="form-group">
                                 <input class="form-control" placeholder="E-mail" name="email" type="email" autofocus="">
                             </div>
                             <div class="form-group">
                                 <input class="form-control" placeholder="Password" name="password" type="password" value="">
                             </div>
                             <div class="checkbox">
                                 <label>
                                     <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                 </label>
                             </div>
                             <!-- Change this to a button or input when using this as a form -->
                             <a href="javascript:;" class="btn btn-sm btn-success">Login</a>
                         </fieldset>
                     </form>
                 </div>
             </div>
         </div>
     </div>
 </div>



</body>
</html>