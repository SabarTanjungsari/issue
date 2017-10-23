<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo base_url(); ?>">
                <img src="<?php echo base_url(); ?>assets/images/trs.jpg" style="width: 150px;height: 40px; margin-top: -10px;" class="img-rounded">
            </a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1"> 
            <?php if ($this->session->userdata('username')) : ?>
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="<?php echo base_url('index.php/Ticket') ?>">Home</a>                    
                    </li>
                    <!--<li>
                        <a class="fa fa-user dropdown-toggle" data-toggle="dropdown" >&nbsp;
                    <?php echo $this->session->userdata('username') ?>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="#" onclick="reset_password(<?php echo $this->session->userdata('user_id') ?>)">
                                    Reset Password</a>
                            </li>
                            <li><a href="#">User Info : <?php echo $this->session->userdata('username') ?></a></li>
                        </ul>
                    </li>
                    -->
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <!-- The Profile picture inserted via div class below, with shaping provided by Bootstrap -->
                            <div class="img-rounded profile-img">
                            </div>
                            <i class="fa fa-user"></i>
                            <?php echo $this->session->userdata('username') ?>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="#" onclick="reset_password(<?php echo $this->session->userdata('user_id') ?>)">
                                    <i class="fa fa-cog"></i> Reset Password
                                </a>
                            </li>
                            <li role="separator" class="divider"></li>
                            <li>
                                <a href="<?php echo base_url('index.php/Login'); ?>">
                                    <i class="fa fa-sign-out"></i> Logout
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            <?php endif; ?>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>

<!-- Reset Password-->
<script>

    function saveuser()
    {
        var url;
        url = "<?php echo site_url('ResetPassword/reset') ?>";

        // ajax adding data to database
        $.ajax({
            url: url,
            type: "POST",
            data: $('#formreset').serialize(),
            dataType: "JSON",
            success: function (data)
            {
                //alert('test');
                //if success close modal and reload ajax table
                $('#reset-signup-modal').modal('hide');
                location.reload();// for reload a page
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error adding / update data')
            }
        });
    }

    function checkPass()
    {
        //Store the password field objects into variables ...
        var pass1 = document.getElementById('password');
        var pass2 = document.getElementById('confirmpassword');
        //Store the Confimation Message Object ...
        var message = document.getElementById('confirmMessage');
        //Set the colors we will be using ...
        var goodColor = "#66cc66";
        var badColor = "#ff6666";
        //Compare the values in the password field 
        //and the confirmation field
        if (pass1.value == pass2.value) {
            //The passwords match. 
            //Set the color to the good color and inform
            //the user that they have entered the correct password 
            password.style.backgroundColor = goodColor;
            message.style.color = goodColor;
            message.innerHTML = ""
            $("#btnSaveUser").removeClass("hidden");
        } else {
            //The passwords do not match.
            //Set the color to the bad color and
            //notify the user.
            password.style.backgroundColor = badColor;
            message.style.color = badColor;
            message.innerHTML = "Passwords Do Not Match!"
            $("#btnSaveUser").addClass("hidden")
        }
    }

    function reset_password(id)
    {
        $('#form')[0].reset();
        $.ajax({
            url: "<?php echo site_url('ResetPassword/ajax_reset/'); ?>" + id,
            type: "GET",
            dataType: "JSON",
            success: function (data) {
                $('[name="user_id"]').val(data.user_id);
                $('[name="username"]').val(data.username);
                $('[name="password"]').val(data.password);
                //$('[name="email"]').val(data.email);
                $('#reset-signup-modal').modal('show');
                $('.modal-title').text('Reset Password');
            }
            ,
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        }
        );
    }
</script>

<!-- Bootstrap modal -->
<div id="reset-signup-modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">

        <!-- login modal content -->
        <div class="modal-content" id="login-modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><span class="glyphicon glyphicon-lock"></span> Login Now!</h4>
            </div>

            <div class="modal-body">
                <form action="#" id="formreset" name="formreset">
                    <input class="hidden" value="" name="user_id"/>

                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon"><span class="fa fa-user"></span></div>
                            <input name="username" id="username" type="text" class="form-control input-lg" 
                                   placeholder="Enter Username" readonly="true">
                        </div>                      
                    </div>                    
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon"><span class="fa fa-lock"></span></div>
                            <input name="password" id="password" type="password" class="form-control input-lg" 
                                   placeholder="Enter Password">
                        </div>                      
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon"><span class="fa fa-lock"></span></div>
                            <input name="confirmpassword" id="confirmpassword" type="password" class="form-control input-lg" 
                                   placeholder="Retype Password" placeholder="Enter again to validate" onkeyup="checkPass()">
                            <span id="confirmMessage" class="confirmMessage"></span>
                        </div>                      
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" id="btnSaveUser" onclick="saveuser()" class="btn btn-danger hidden">
                    <span class="fa fa-save"></span>
                    Reset</button>
                <button type="button" class="btn btn-success" data-dismiss="modal">
                    <span class="fa fa-close"></span>
                    Cancel</button>
            </div>

        </div>
        <!-- login modal content -->

    </div>
</div>