<!-- Main Menu Layout -->
<div class="content-container">
    <ul class="main-menu" id="main-menu">
        <% loop $MenuPages %>
            <% if $Menu %>

                <li id="$MenuTitle" class="<% if $Pos==1 || $Pos==5 %>start-of-row<% end_if %> $Menu_style">
                    <a href="<% if $MenuTitle=='Logout' %>$absoluteBaseURL/Security/logout<% else %>$link<% end_if %>">
                        <h4>$MenuTitle</h4>
                    </a>
                </li>

            <% end_if %>
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

