
<link href="<?php echo base_url('assets/jquery/jquery-ui.css') ?>" rel="stylesheet" type="text/css" media="all">
<script src="<?php echo base_url('assets/jquery/external/jquery/jquery.js') ?>"></script>
<script src="<?php echo base_url('assets/jquery/jquery-ui.min.js') ?>"></script>

<input type="text" id="birds"/>

<script type="text/javascript">

    $(function () {
        $("#birds").autocomplete({
            source: "birds/get_birds" // path to the get_birds method
        });
    });

</script>


