<!-- Main Menu Layout -->
<div class="content-container">

    <ul class="main-menu" id="main-menu">

        <% loop $Children %>

            <li id="" class="$LinkingMode <%if $Odd %>medium-grey-style<% else %>red-style<% end_if %> <% if $first %>dark-grey-style start-of-row<% end_if %>" >
            <a href="$link">
                <h4>$Title</h4>
            </a>
        </li>
        <% end_loop %>
    </ul>
</div>
<script>
    $(document).ready(function () {

        set_menu_item_height();
        $(window).on('resize', function () {
            set_menu_item_height();
        });

    });

    var set_menu_item_height = function () {
        var list_item = $('#main-menu li');
        var width = list_item.css('width');
        list_item.find('h4').css('line-height', width);
        list_item.css('height', width);
    };

</script>

