
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
                    <th>Date</th>
                    <th>Marketing</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tickets as $ticket) : ?>
                    <tr>
                        <td class="hidden"><?php echo $ticket->ticket_id; ?></td>
                        <td><?php echo $ticket->customer; ?></td>                        
                        <td><?php echo $ticket->location; ?></td>
                        <td><?php echo $ticket->dateticket; ?></td>                        
                        <td><?php echo $ticket->marketing; ?></td>
                        <td>
                            <button id="btnEdit" class="btn btn-warning" onclick="detail_ticket(<?php echo $ticket->ticket_id; ?>)"><i class="fa fa-info-circle"></i></button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="col-md-1"></div>
</div>

<script>

    $(document).ready(function () {

        $('#myTable').DataTable();
        $('#dateticket').datetimepicker({
            language: 'id',
            weekStart: 1,
            todayBtn: 1,
            autoclose: 1,
            todayHighlight: 1,
            startView: 2,
            minView: 2,
            forceParse: 0
        });
        $('#datefollow').datetimepicker({
            language: 'id',
            weekStart: 1,
            todayBtn: 1,
            autoclose: 1,
            todayHighlight: 1,
            startView: 2,
            minView: 2,
            forceParse: 0
        });
        $('#isfollow').mousedown(function () {
            if (!$(this).is(':checked')) {
                $("#lblnote").show();
                $("#lbldatefollow").show();
                $("#note").attr("class", "form-control");
                $("#datefollow").attr("class", "form-control");
                //$(this).trigger("change");
            } else
            {
                $("#lblnote").hide();
                $("#lbldatefollow").hide();
                $("#note").attr("class", "hidden");
                $("#datefollow").attr("class", "hidden");
            }
        });
    }
    );
    function show_customer() {

        var site = "<?php echo site_url(); ?>";
        $(function () {
            $('#customer').autocomplete({
                // serviceUrl berisi URL ke controller/fungsi yang menangani request kita
                serviceUrl: site + '/Customer/search',
                // fungsi ini akan dijalankan ketika user memilih salah satu hasil request
                //onSelect: function (suggestion) {
                //  $('#v_nim').val('' + suggestion.nim); // membuat id 'v_nim' untuk ditampilkan
                //$('#v_jurusan').val('' + suggestion.jurusan); // membuat id 'v_jurusan' untuk ditampilkan
                //}
            });
        });
    }

    var save_method; // for save method string
    var table;

    function add_ticket() {
        save_method = 'add';
        $("#form")[0].reset(); // reset form on modal
        $("#modal_form").modal('show'); // show bootstrap modal
        $(".modal-header #myModalLabel").text("Tambah Jadwal");
        $('#isfollow').val(false);
        //$('.modal-title').text('Add Person'); // Set Title to Bootstrap modal title
        $("#description").attr("class", "form-control");
        show_customer();
    }

    function save()
    {
        var url;
        var checkbox = $("#isfollow");
        checkbox.val(checkbox[0].checked ? "true" : "false");
        if (save_method == 'add')
        {
            url = "<?php echo site_url('Ticket/add_ticket') ?>";
        } else
        {
            url = "<?php echo site_url('Ticket/update_ticket') ?>";
        }

        // ajax adding data to database
        $.ajax({
            url: url,
            type: "POST",
            data: $('#form').serialize(),
            dataType: "JSON",
            success: function (data)
            {
                //if success close modal and reload ajax table
                $('#modal_form').modal('hide');
                location.reload(); // for reload a page
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error adding / update data')
            }
        });
    }

    function edit_ticket(id)
    {
        $("#description").attr("class", "form-control");
        save_method = 'update';
        $('#form')[0].reset();
        $.ajax({
            url: "<?php echo site_url('Ticket/ajax_edit/'); ?>" + id,
            type: "GET",
            dataType: "JSON",
            success: function (data) {
                $('[name="ticket_id"]').val(data.ticket_id);
                $('[name="dateticket"]').val(data.dateticket);
                $('[name="customer"]').val(data.customer);
                $('[name="pic"]').val(data.pic);
                $('[name="location"]').val(data.location);
                $('[name="description"]').val(data.description);
                $('[name="isfollow"]').val(data.isfollow);
                if (data.isfollow == '1') {
                    $("#isfollow").attr("checked", true);
                    $("#lblnote").show();
                    $("#lbldatefollow").show();
                    $("#note").attr("class", "form-control");
                    $("#datefollow").attr("class", "form-control");
                } else {
                    $("#isfollow").attr("checked", false);
                    $("#lblnote").hide();
                    $("#lbldatefollow").hide();
                    $("#note").attr("class", "hidden");
                    $("#datefollow").attr("class", "hidden");
                }

                $('[name="note"]').val(data.note);
                $('[name="datefollow"]').val(data.datefollow);
                //alert(data.datefrom);
                $('#modal_form').modal('show');
                $('.modal-title').text('Edit Jadwal');
                show_customer();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }

    function delete_ticket(id) {
        if (confirm('Are you sure delete this data?'))
        {
            // ajax delete data from database
            $.ajax({
                url: "<?php echo site_url('Ticket/ticket_delete') ?>/" + id,
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

    function detail_ticket(id)
    {
        save_method = 'update';
        $('#form')[0].reset();
        $.ajax({
            url: "<?php echo site_url('Ticket/ajax_detail/'); ?>" + id,
            type: "GET",
            dataType: "JSON",
            success: function (data) {
                $('[name="jenis"]').val(data.typeid);
                $('#modal_detail').modal('show');
                $('.modal-title').text('Details Contact');
                $('#name').text(data.name);
                $('#jabatan').text(data.jabatan);
                $('#perusahaan').text(data.perusahaan);
                $('#contact').text(data.contact);
                $('#email').text(data.email);
                $('#alamat').text(data.alamat);
                $('#kebutuhan').text(data.kebutuhan);
                $('#businesstype').text(data.businesstype);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }
</script>

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title" id="myModalLabel">&nbsp;</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input class="hidden" value="" name="ticket_id"/>
                    <div class="form-group">
                        <label class="control-label col-md-3">Date</label>
                        <div class="date col-md-9" date-date="" data-date-format="yyyy-mm-dd">
                            <input name="dateticket" id="dateticket" class="form-control datepicker" data-date-format="yyyy-mm-dd" type="text" readonly 
                                   value="<?php echo date('Y-m-d'); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <!--<label class="control-label col-md-3">Attachment</label>
                        <div class="col-md-3">
                            <input name="attachment" class="form-control" type="file">
                        </div>-->
                        <label class="control-label col-md-3">Need Follow Up</label>
                        <div class="col-md-2">
                            <input name="isfollow" class="form-control" type="checkbox" id="isfollow">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3" id="lbldatefollow" hidden="true">Follow Up Date</label>
                        <div class="date col-md-9" date-date="" data-date-format="yyyy-mm-dd">
                            <input name="datefollow" id="datefollow" class="form-control datepicker hidden" data-date-format="yyyy-mm-dd" type="text"
                                   readonly value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3" id="lblnote" hidden="true">Note</label>
                        <div class="col-md-9">
                            <textarea name="note" id="note" placeholder="Note" class="hidden" type="text" rows="4"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Customer Name</label>
                        <div class="col-md-9">
                            <input name="customer" placeholder="Customer Name" class="form-control" id="customer" type="text">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">PIC</label>
                        <div class="col-md-9">
                            <input name="pic" placeholder="PIC" class="form-control" type="text">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Location</label>
                        <div class="col-md-9">
                            <input name="location" placeholder="Location" class="form-control" type="text">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3" id="lbldescription">Description</label>
                        <div class="col-md-9">
                            <textarea name="description" id="description" placeholder="Description" type="text" class="hidden" rows="4"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">
                    <span class="glyphicon glyphicon-floppy-save"></span>
                    Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">
                    <span class="glyphicon glyphicon-remove-sign"></span>
                    Cancel</button>
            </div>
        </div>
    </div>
</div><!-- /.modal -->
<!-- End Bootstrap modal -->


<!-- Detail Contact -->
<div class="modal fade" id="modal_detail" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-user"></span>&nbsp;</h3>
            </div>
            <div class="modal-body form">

                <span class="fa-stack fa-lg">
                    <i class="fa fa-circle fa-stack-2x"></i>
                    <i class="fa fa-user fa-stack-1x fa-inverse"></i>
                </span>
                <a id="name"></a><br>
                <span class="fa-stack fa-lg">
                    <i class="fa fa-square fa-stack-2x"></i>
                    <i class="fa fa-frown-o fa-stack-1x fa-inverse"></i>
                </span>
                <a id="jabatan"></a><br>
                <span class="fa-stack fa-lg">
                    <i class="fa fa-square fa-stack-2x"></i>
                    <i class="fa fa-university fa-stack-1x fa-inverse"></i>
                </span>
                <a id="perusahaan"></a><br> 
                <span class="fa-stack fa-lg">
                    <i class="fa fa-square fa-stack-2x"></i>
                    <i class="fa fa-phone fa-stack-1x fa-inverse"></i>
                </span>
                <a id="contact"></a><br>
                <span class="fa-stack fa-lg">
                    <i class="fa fa-square fa-stack-2x"></i>
                    <i class="fa fa-envelope-o fa-stack-1x fa-inverse"></i>
                </span>
                <a id="email"></a><br>
                <span class="fa-stack fa-lg">
                    <i class="fa fa-square fa-stack-2x"></i>
                    <i class="fa fa-home fa-stack-1x fa-inverse"></i>
                </span>
                <a id="alamat"></a><br>
                <span class="fa-stack fa-lg">
                    <i class="fa fa-square fa-stack-2x"></i>
                    <i class="fa fa-dashboard fa-stack-1x fa-inverse"></i>
                </span>
                <a id="kebutuhan"></a><br>
                <span class="fa-stack fa-lg">
                    <i class="fa fa-square fa-stack-2x"></i>
                    <i class="fa fa-mixcloud fa-stack-1x fa-inverse"></i>
                </span>
                <a id="businesstype"></a><br>
            </div> 
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">
                    <span class="fa fa-globe fa-spin"></span>
                </button>
            </div>
        </div>
    </div>
</div>