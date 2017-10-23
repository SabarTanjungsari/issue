<html lang="en-US">  
    <head>  
        <title>Codeigniter Autocomplete</title>  
        <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.6/themes/base/jquery-ui.css" type="text/css" media="all" />  
        <link rel="stylesheet" href="http://static.jquery.com/ui/css/demo-docs-theme/ui.theme.css" type="text/   css" media="all" />  
        <link href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
        
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js" type="text/javascript"></script>  
        <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.6/jquery-ui.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js') ?>"></script>
        <meta charset="UTF-8">  


        <script type="text/javascript">
            $(this).ready(function () {
                $("#id").autocomplete({

                    minLength: 1,
                    source:
                            function (req, add) {
                                $.ajax({
                                    url: "<?php echo base_url(); ?>index.php/Customer/lookup",
                                    dataType: 'json',
                                    type: 'POST',
                                    data: req,
                                    success:
                                            function (data) {
                                                if (data.response == "true") {
                                                    add(data.message);
                                                    console.log(data);
                                                }
                                            },
                                });
                            },

                });
            });
        </script>  

    </head>  
    <body>  
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10 table-responsive">
                <button id="btnAdd" class="btn btn-success" onclick="add_ticket()"><i class="fa fa-plus-circle"></i> Tambah Jadwal</button>
                <hr/>
                <table id="myTable" class="table table-stripted table-bordered table-hover table-responsive">
                    <thead>
                        <tr>
                            <th class="hidden"></th>
                            <th>Customer </th>
                            <th>Lokasi</th>                    
                            <th>Desc.</th>
                            <th>Date</th>
                            <th>Follow Up</th>
                            <th>Date Follow Up</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tickets as $ticket) : ?>
                            <tr>
                                <td class="hidden"><?php echo $ticket->ticket_id; ?></td>
                                <td><?php echo $ticket->customer; ?></td>
                                <td><?php echo $ticket->location; ?></td>                        
                                <td><?php echo $ticket->description; ?></td>
                                <td><?php echo $ticket->dateticket; ?></td>
                                <td>
                                    <input type="checkbox" onclick="return false;" <?php echo ($ticket->isfollow == 1 ? 'checked' : ''); ?>
                                           value="<?php echo $ticket->isfollow; ?>"
                                           />
                                </td>
                                <td><?php echo $ticket->datefollow; ?></td>
                                <td>
                                    <button id="btnEdit" class="btn btn-warning" onclick="edit_ticket(<?php echo $ticket->ticket_id; ?>)"><i class="glyphicon glyphicon-edit"></i></button>
                                    <button id="btnDelete" class="btn btn-danger" onclick="delete_ticket(<?php echo $ticket->ticket_id; ?>)"><i class="glyphicon glyphicon-trash"></i></button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="col-md-1"></div>
        </div>
        Country :  
        <?php
        echo form_input('customer', '', 'id="id"');
        ?>  
        <ul>  
            <div class="well" id="result"></div>  
        </ul>  
    </body>  
</html> 