<?php include "base-login.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Track your TV</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css">

    <!-- Importing Fonts -->
    <link href='//fonts.googleapis.com/css?family=Roboto+Slab' rel='stylesheet' type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Droid+Sans' rel='stylesheet' type='text/css'>
    <!-- Main Style Sheet -->
    <link href="css/main_style.css" type="text/css" rel="stylesheet">
    <!-- Javascript Table Content Loader -->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
    <script src="js/displayContent.js"></script>

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
        .text-button button {
            background:none!important;
            border:none!important;
            padding:0!important;
            font: inherit!important;
            /*border is optional*/
            border-bottom:1px solid #444!important;
            cursor: pointer!important;
        }
        .register-fix{
            padding-left: 0px;
            margin-bottom: 1em;
        }
        .center {
            margin:0 auto!important;
            text-align:center;
        }
    </style>
</head>

<body>

<!-- USER IS LOGGED IN -->
<?php
if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']))
{
    $User = $_SESSION['Username'];
    ?>

    <header>
        <div id="logout">
            <a href="scripts/logout.php">Logout</a>
        </div>
        <div id="create_account">
            <a class="profile" data-toggle="modal" data-target="#myModal" style="cursor: pointer;"><strong>Welcome! </strong><?php echo $User; ?></a>
        </div>
    </header>

    <div class = "main-table">
        <div class = "container col-md-6 centered">
            <div class = "input-group">
                <div id="searchfield">
                    <input type= "text" id="urlText" name='urlText' class ="fix form-control biginput" placeholder= "Enter some text">
                </div>
                <span class = "input-group-btn">
                <button class = "btn btn-primary" id='submitURL' onclick="displayContent();" name='submitURL'>Search</button>
                </span>
            </div>
            </br>
            <table id ='tvResults' class ="table table-bordered">
                <tr>
                    <th>Tv Show</th>
                    <th>Next Episode</th>
                    <th>Air Date</th>
                </tr>
                <script type="text/javascript">
                    loadPreviousData();
                </script>
            </table>
        </div>
    </div>

    <script type="text/javascript">
        $(".profile").on("click", function() {
            $.ajax({
                type: 'GET',
                url: 'scripts/getCheckboxes.php',
                async: false,
                dataType: 'json',
                success: function (data) {
                    if(data[0]['email_notifications'] === "1"){
                        document.getElementById("email_notifications").checked = true;
                    }
                    if(data[0]['text_notifications'] === "1"){
                        document.getElementById("text_notifications").checked = true;
                    }
                    document.getElementById('phone_number').value = data[0]['phone_number'];
                }
            });
        });

    </script>

    <!-- Profile -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="vertical-alignment-helper">
            <div class="modal-dialog vertical-align-center">
                <div class="modal-content">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Log In</h3>
                        </div>
                        <div class="panel-body">
                            <form id="profile-modal" method="POST" action="#">
                                <fieldset>
                                    <div class="form-group">
                                        <input class="form-control" disabled="disabled" value=<?php echo $User; ?>>
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" name="phone_number" placeholder="Phone Number" id="phone_number">
                                    </div>
                                    <div class="form-group">
                                        <select id="carrier" name="carrier" class="form-control">
                                            <option value="txt.att.net">AT&T</option>
                                            <option value="messaging.sprintpcs.com">Sprint</option>
                                            <option value="tmomail.net">T-Mobile</option>
                                            <option value="vtext.com">Verizon</option>
                                            <option value="message.alltel.com">All Tell</option>
                                            <option value="pcs.rogers.com">Rogers</option>
                                            <option value="msg.telus.com">Telus</option>
                                            <option value="vmobl.com">Virgin Mobile</option>
                                        </select>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input name="emails" id="email_notifications" type="checkbox">Email Notifications
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input name="text-message" id="text_notifications" type="checkbox">Text Messages
                                        </label>
                                    </div>
                                    <div class="center">
                                        <!-- Change this to a button or input when using this as a form -->
                                        <button id="login-button" name="login-button" class="btn btn-sm btn-success center">Save</button>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
}
else
{
    ?>
    <!-- USER IS NOT LOGGED IN -->
    <header>
        <div id="create_account">
            <a data-toggle="modal" data-target="#myModal" style="cursor: pointer;">Login/Create an Account</a>
        </div>
    </header>

    <!-- Login -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="vertical-alignment-helper">
            <div class="modal-dialog vertical-align-center">
                <div class="modal-content">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Log In</h3>
                        </div>
                        <div class="panel-body">
                            <form id="login-modal" method="POST" action="#">
                                <fieldset>
                                    <p id="error"></p>
                                    <div class="form-group">
                                        <input class="form-control" required="" placeholder="Username" name="username" id="username" type="username" autofocus="">
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" required="" placeholder="Password" name="password" id="password" type="password" value="">
                                    </div>
                                    <div class="center">
                                        <div class="col-sm-12 register-fix">
                                            <a data-toggle="modal2" data-target="#myModal2" id="register-account" style="cursor:pointer;">Don't Have an account? Click here to register</a>
                                        </div>
                                        <!-- Change this to a button or input when using this as a form -->
                                        <button id="login-button" name="login-button" class="btn btn-sm btn-success center">Login</button>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Register -->
    <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="vertical-alignment-helper">
            <div class="modal-dialog vertical-align-center">
                <div class="modal-content">
                    <div class="panel panel-default">
                        <div class="panel-heading"><strong>Create an Account!</strong></div>
                        <div class="panel-body">
                            <form class="form-horizontal" id="register-modal">
                                <p id="register-error"></p>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-3 control-label">Username</label>
                                    <div class="col-sm-9">
                                        <input type="text" required="" placeholder="Username" class="form-control" name="username" >
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
                                <div class="form-group">
                                    <div class="col-md-offset-3 col-md-3">
                                        <button type="button" id="back-button" name="back-button" class="btn btn-success btn-sm">I already have an account</button>
                                    </div>
                                    <div class="col-md-offset-3 col-md-3">
                                        <button class="btn btn-sm btn-success center">Create account</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $('#register-account').on('click', function () {
            $('#myModal').modal('hide');
            $('#myModal2').modal('show');
        });
        $('#back-button').on('click', function () {
            $('#myModal2').modal('hide');
            $('#myModal').modal('show');
        });
    </script>

    <div class = "main-table">
        <div class = "container col-md-7 centered">
            <div class = "input-group fix">
                <input type= "text" id="urlText" name='urlText' class ="form-control" placeholder= "Type here to test it out">
                    <span class = "input-group-btn">
                    <button class = "btn btn-primary" id='submitURL' onclick="displayContent();" name='submitURL'>Search</button>
                    </span>
            </div>
            </br>
            <table id ='tvResults' class ="table table-bordered">
                <tr>
                    <th>Tv Show</th>
                    <th>Next Episode</th>
                    <th>Air Date</th>
                </tr>
                <tr>
                    <td>Game of Thrones</td>
                    <td>not currently airing</td>
                    <td>Airs Sundays at 9:00 PM on HBO</td>
                </tr>
                <tr>
                    <td>American Horror Story</td>
                    <td>Dec 3 2014</td>
                    <td>Airs Wednesdays at 10:00 PM EST on FX</td>
                </tr>
                <tr>
                    <td>The Walking Dead</td>
                    <td>Nov 23 2014</td>
                    <td>Airs Sundays at 9:00 PM on AMC</td>
                </tr>
                <tr>
                    <td>True Detective</td>
                    <td>not currently airing</td>
                    <td>Airs Sundays at 9:00 PM on HBO</td>
                </tr>
                <tr>
                    <td>Arrow</td>
                    <td>Dec 3 2014</td>
                    <td>Airs Wednesdays at 8:00 PM on The CW</td>
                </tr>
                <tr>
                    <td>Gotham</td>
                    <td>Nov 24 2014</td>
                    <td>Airs Mondays at 8:00 PM on FOX</td>
                </tr>
                <tr>
                    <td>Breaking Bad</td>
                    <td>not currently airing</td>
                    <td>Show ended</td>
                </tr>
            </table>
        </div>
    </div>

<?php
}
?>


</body>
</html>