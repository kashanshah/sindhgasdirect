<?php
include("common.php");
if(isset($_SESSION['Admin']) && $_SESSION['Admin']==true)
	header("Location: index.php");

	$msg = "";
	if(isset($_POST["Submit"]) && $_POST["Submit"] == "Submit")
	{
		if(isset($_POST["Username"]))
			$Username=trim($_POST["Username"]);
		if(isset($_POST["Password"]))
			$Password=trim($_POST["Password"]);
			
		if ($Username=="")
		{
			$msg = "Please Enter Username.";
		}
		
		else if ($Password=="")
		{
			$msg = "Please Enter Password.";
		}
			
		else if($msg=='')
		{
			$query="SELECT ID, Username, RoleID, Password ,Email FROM users WHERE Status=1 AND Username='".dbinput($Username)."'";
			$result = mysql_query($query) or die("Query error: ". mysql_error());
			$num = mysql_num_rows($result);
			// echo $num;
			// exit();
			if($num==0)
			{
				$_SESSION["Admin"]=false;
				$_SESSION["AdminID"]="";
				$_SESSION["Email"]="";
				$msg = "<div for=\"login-email\" class=\"help-block animation-slideDown\">Invalid Username/Password</div>";
				
			}
			else
			{

				$row = mysql_fetch_array($result);
				// echo dboutput($row["Password"]);
				// exit();
				if(dboutput($row["Password"]) == $Password)
				{
					
						$_SESSION["Admin"]=true;
						$ssql = "SELECT * FROM users WHERE ID = ".$row['ID']."";
						$datap = mysql_query($ssql);
						$rows = mysql_fetch_assoc($datap);
						foreach($rows as $key => $value)
						{
							$_SESSION[$key]=$value;
						}
					
					header("Location: dashboard.php");
				}
				else
				{
					$_SESSION["User"]=false;
					$_SESSION["UserID"]="";
					$_SESSION["Email"]="";
					$msg = "<div for=\"login-email\" class=\"help-block animation-slideDown\">Invalid Username/Password</div>";
				}
			}
		}
	}
?><!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo SITE_TITLE ?> - Login</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="plugins/iCheck/square/blue.css">
    <!-- Clock -->
	<script language="javascript" src="plugins/local_clock.js" type="text/javascript"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="hold-transition login-page" style="background: url('images/bg_login.jpg');background-size: cover;display: flex;align-content: center;min-height: 100vh;">
    <div class="login-box" style="margin:auto;">
      <div class="login-logo">
        <strong><a href="index.php" style="color: #fff"><?php echo COMPANY_NAME; ?></a></strong>
      </div><!-- /.login-logo -->
      <div class="login-box-body" style="border: 10px solid #000; border-radius: 10px">
        <p class="login-box-msg" id="clockdisp">
            <script language="javascript">localclock();</script>
      	</p>
        <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
          <div class="input-group <?php echo ($msg != '' ? 'has-error' : '') ?>">
            <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
            <input type="text" name="Username" class="form-control" placeholder="Username">
          </div>
          <br/>
          <div class="form-group input-group <?php echo ($msg != '' ? 'has-error' : '') ?>" >
            <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
            <input type="password" name="Password" class="form-control" placeholder="Password">
          </div>
          <?php echo ($msg != '' ? '<div class="form-group input-group has-error" >
          	<label class="control-label" for="inputError"><i class="fa fa-times-bell-o"></i> Incorrect Username or Password!</label>
          </div>' : '') ?>
          <div class="row">
            <div class="col-xs-8">
              <div class="checkbox icheck">
                <label>
                  <input type="checkbox" name="remember_me"> Remember Me
                </label>
              </div>
            </div><!-- /.col -->
            <div class="col-xs-4">
              <button type="submit" name="Submit" value="Submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
            </div><!-- /.col -->
          </div>
        </form>

<!--        <div class="social-auth-links text-center">
          <p>- OR -</p>
          <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using Facebook</a>
          <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using Google+</a>
        </div><!-- /.social-auth-links 

        <a href="#">I forgot my password</a><br>
        <a href="register.html" class="text-center">Register a new membership</a>
-->
      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="plugins/iCheck/icheck.min.js"></script>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>
  </body>
</html>
