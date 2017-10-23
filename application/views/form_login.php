
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="../../favicon.ico">

        <title>Signin to Application</title>

        <!-- Bootstrap core CSS -->
        <link rel="stylesheet" href="<?php echo base_url("assets/bootstrap/css/bootstrap.min.css"); ?>" />

        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <!--<link rel="stylesheet" href="<?php echo base_url("/assets/bootstrapcss/ie10-viewport-bug-workaround.css"); ?>" />-->

        <!-- Custom styles for this template -->
        <link rel="stylesheet" href="<?php echo base_url("assets/bootstrap/css/signin.css"); ?>" />

        <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
        <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
        <!--<script src="../../assets/js/ie-emulation-modes-warning.js"></script>-->

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>

    <body>

        <div class="container">

            <div><?=validation_errors() ?></div>
            <div><?=$this->session->flashdata('error') ?></div>
            <?= form_open('login', ['class' => 'form-horizontal']) ?>
            <div class="form-group">
                <label for="inputUsername" class="col-sm-2 control-label">Username</label>

                <div class="col-sm-10">
                    <input type="text" class="form-control" name="username" placeholder="Username">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword" class="col-sm-2 control-label">Password</label>

                <div class="col-sm-10">
                    <input type="password" class="form-control" name="password" placeholder="Password">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword" class="col-sm-2 control-label"></label>
                <div class="col-sm-2">
                    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
                </div>
            </div>
        </form>

    </div> <!-- /container -->


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <!--<script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>-->
</body>
</html>
