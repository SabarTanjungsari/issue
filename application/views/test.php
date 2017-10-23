<form class="form-horizontal" role="form">
    <div class="form-group">
        <label for="sampleAutocomplete" class="col-sm-3 control-label">Sample Autocomplete</label>
        <div class="col-sm-9">
            <input type="text" class="autocomplete form-control hover" id="sampleAutocomplete" data-toggle="dropdown" />
            <ul class="dropdown-menu" role="menu">
                <!--<li><a>Action</a></li>
                <li><a>Another action</a></li>
                <li><a>Something else here</a></li>
                <li><a>Separated link</a></li>-->
                <?php foreach ($customers as $customer) : ?>
                    <li><?php echo $customer->name; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <form>
        <script>
            
                $(document).on("focus keyup", "input.autocomplete", function () {
                    // Cache useful selectors
                    var $input = $(this);
                    var $dropdown = $input.next("ul.dropdown-menu");

                    // Create the no matches entry if it does not exists yet
                    if (!$dropdown.data("containsNoMatchesEntry")) {
                        $("input.autocomplete + ul.dropdown-menu").append('<li class="no-matches hidden"><a>No matches</a></li>');
                        $dropdown.data("containsNoMatchesEntry", true);
                    }

                    // Show only matching values
                    $dropdown.find("li:not(.no-matches)").each(function (key, li) {
                        var $li = $(li);
                        $li[new RegExp($input.val(), "i").exec($li.text()) ? "removeClass" : "addClass"]("hidden");
                    });

                    // Show a specific entry if we have no matches
                    $dropdown.find("li.no-matches")[$dropdown.find("li:not(.no-matches):not(.hidden)").length > 0 ? "addClass" : "removeClass"]("hidden");
                });
                $(document).on("click", "input.autocomplete + ul.dropdown-menu li", function (e) {
                    // Prevent any action on the window location
                    e.preventDefault();

                    // Cache useful selectors
                    $li = $(this);
                    $input = $li.parent("ul").prev("input");

                    // Update input text with selected entry
                    if (!$li.is(".no-matches")) {
                        $input.val($li.text());
                    }
                });
        </script>