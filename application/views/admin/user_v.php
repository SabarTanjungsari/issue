
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            User
            <small>List Users</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-home"></i>Home</a></li>
            <li><a href="#">Master</a></li>
            <li class="active">Data users</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <body>
                            <button id="btnAdd" class="btn btn-success" onclick="add_user()"><i class="fa fa-user-plus"></i></button>
                            <h3 class="box-title">Data Table User Registration</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <table id="tableid" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="hidden"></th>
                                    <th>Username </th>                   
                                    <th>Email.</th>
                                    <th>Role</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $user) : ?>
                                    <tr>
                                        <td class="hidden"><?php echo $user->user_id; ?></td>
                                        <td><?php echo $user->username; ?></td>                     
                                        <td><?php echo $user->email; ?></td>
                                        <td><?php echo $user->role; ?></td>
                                        <td>
                                            <button id="btnEdit" class="btn btn-warning" onclick="edit_user(<?php echo $user->user_id; ?>)"><i class="glyphicon glyphicon-edit"></i></button>
                                            <button id="btnDelete" class="btn btn-danger" onclick="delete_user(<?php echo $user->user_id; ?>)"><i class="glyphicon glyphicon-trash"></i></button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Bootstrap modal -->
<div class="modal fade" id="adduser_modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title" id="myModalLabel">&nbsp;</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form_user">
                    <input class="hidden" value="" name="user_id"/>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon"><span class="fa fa-user-circle-o"></span></div>
                            <input name="username" id="username" type="text" class="form-control input-lg"
                                   onkeyup="validateForm()">
                        </div>                      
                    </div> 
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon"><span class="fa fa-group"></span></div>
                            <select id="role_id"  name="role_id" class="form-control">   
                                <?php foreach ($roles->result() as $role) { ?>
                                    <option value="<?php echo $role->role_id ?>"><?php echo $role->name ?></option>
                                <?php } ?>
                            </select>
                        </div>                      
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon"><span class="fa fa-envelope-o"></span></div>
                            <input name="email" id="email" type="email" class="form-control input-lg"
                                   onkeyup="validateForm()">
                        </div>                      
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon"><span class="fa fa-key"></span></div>
                            <input name="password" id="password" type="password" class="form-control input-lg"
                                   onkeyup="validateForm()">
                        </div>                      
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon"><span class="fa fa-info-circle"></span></div>
                            <input name="confirmpassword" id="confirmpassword" type="password" class="form-control input-lg"
                                   onkeyup="validateForm()">
                            <span id="confirmMessage" class="confirmMessage"></span>
                        </div>                      
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSaveUser" onclick="saveUser()" class="btn btn-success hidden">
                    <span class="fa fa-save"></span>
                    Save</button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">
                    <span class="fa fa-close"></span>
                    Cancel</button>
            </div>
        </div>
    </div>
</div><!-- /.modal -->
<!-- End Bootstrap modal -->

<script>
    function validate_form() {
        $('#form_user').validate({
            rules: {
                username: {
                    minlength: 3,
                    maxlength: 15,
                    required: true
                },
                password: {
                    minlength: 3,
                    maxlength: 15,
                    required: true
                },
                confirmpassword: {
                    equalTo: "#password"
                },
            },
            highlight: function (element) {
                $(element).closest('.form-group').addClass('has-error');
            },
            unhighlight: function (element) {
                $(element).closest('.form-group').removeClass('has-error');
            },
            errorElement: 'span',
            errorClass: 'help-block',
            errorPlacement: function (error, element) {
                if (element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            }
        });
    }

    var save_method; // for save method string
    var table;
    function add_user() {
        save_method = 'add';
        $("#form_user")[0].reset(); // reset form on modal
        $("#adduser_modal").modal('show'); // show bootstrap modal
        $(".modal-header #myModalLabel").text("Add User");
        validate_form();
    }

    function validateForm() {
        if (!$("#form_user").validate().form()) {
            //return false; //doesn't validate
            $("#btnSaveUser").addClass("hidden");
        } else
        {
            $("#btnSaveUser").removeClass("hidden");
        }
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
            message.innerHTML = "Confirm Passwords Do Not Match!"
            $("#btnSaveUser").addClass("hidden")
        }
    }

    function saveUser()
    {
        var url;
        
        if (save_method == 'add')
        {
            url = "<?php echo site_url('User/add_user') ?>";
        } else
        {
            url = "<?php echo site_url('User/update_user') ?>";
        }

        // ajax adding data to database
        $.ajax({
            url: url,
            type: "POST",
            data: $('#form_user').serialize(),
            dataType: "JSON",
            success: function (data)
            {
                //if success close modal and reload ajax table
                $('#adduser_modal').modal('hide');
                location.reload(); // for reload a page
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error adding / update data')
            }
        });
    }

    function edit_user(id)
    {
        validate_form();
        save_method = 'update';
        $('#form_user')[0].reset();
        $.ajax({
            url: "<?php echo site_url('User/ajax_edit/'); ?>" + id,
            type: "GET",
            dataType: "JSON",
            success: function (data) {
                $('[name="user_id"]').val(data.user_id);
                $('[name="username"]').val(data.username);
                $('[name="password"]').val(data.password);
                $('[name="email"]').val(data.email);
                $('[name="role_id"]').val(data.role_id);
                $('#adduser_modal').modal('show');
                $('.modal-title').text('Edit User');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }

    function delete_user(id) {
        if (confirm('Are you sure delete this data?'))
        {
            // ajax delete data from database
            $.ajax({
                url: "<?php echo site_url('User/user_delete') ?>/" + id,
                type: "POST",
                dataType: "JSON",
                success: function (data)
                {

                    location.reload();
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error deleting data');
                }
            });
        }
    }

</script>