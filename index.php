<?php include "base-login.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Track your TV</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
    <!-- Importing Fonts -->
    <link href='http://fonts.googleapis.com/css?family=Roboto+Slab' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Droid+Sans' rel='stylesheet' type='text/css'>
    <!-- Main Style Sheet -->
    <link href="css/main_style.css" type="text/css" rel="stylesheet">
    <!-- Javascript Table Content Loader -->
    <script src="js/displayContent.js"></script>
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
            <a href="/scripts/logout.php">Logout</a>
        </div>
        <div id="create_account">
            <a><strong>Welcome! </strong><?php echo $User; ?></a>
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
                        addData();   
                    </script>
                </table>
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
            <a href="login.php">Login/Create an Account</a>
        </div>
    </header>

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
                    <td>The Big Bang Theory</td>
                    <td>Dec 11 2014</td>
                    <td>Airs Thursdays at 8:00 PM on CBS</td>
                </tr>
                <tr>
                    <td>Friends</td>
                    <td>not currently airing</td>
                    <td>Show ended</td>
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
