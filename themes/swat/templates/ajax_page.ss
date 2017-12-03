<div id="trans-page-info" class="no-display" dec="slide-down" inc="slide-up"></div>
<div class="animation-layer anim-leave" id="ajax-source">
</div>
<div class="animation-layer anim-enter" sort="$Sort">
    <div class="content-container">

        <a href="#" class="back-arrow button full" direction="back">
            <span>Previous Page</span>
        </a>
        <!-- Sub Sections -->
        <% control $Sections %>
            $Me
        <% end_control %>

        <% if $is_the_last_page %>
            <% if $is_the_last_module %>
                <a href="$absoluteURL\evaluation/" class="button full" >
                    <span>Evaluation</span>
                </a>
            <% else %>
                <a href="$absoluteURL\main-menu/module-menu/module-2" class="button full" >
                    <span>Next Module</span>
                </a>
            <% end_if %>
        <% else %>
            <a href="#" class="next-arrow button full" direction="next">
                <span>Next Page</span>
            </a>
        <% end_if %>

    </div>
</div>
