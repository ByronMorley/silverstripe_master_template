<!-- Module Page Layout -->
<div class="content-container">

    <!--<a href="#" class="back-arrow button full" direction="back">
        <span>Previous Page</span>
    </a>-->

        <!-- Sub Sections -->
        <% control $Sections %>
            $Me
        <% end_control %>



    <a href="$absoluteBaseURL\main-menu" class="button full">
        <span>Main menu</span>
    </a>
</div>
<% include Modal %>
<script>
    $(document).ready(function () {
        max_image_event();
    });
</script>