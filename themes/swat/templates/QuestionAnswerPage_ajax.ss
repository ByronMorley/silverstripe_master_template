<div id="trans-page-info" class="no-display" dec="slide-down" inc="slide-up"></div>
<div class="animation-layer anim-leave" id="ajax-source">
</div>
<div class="animation-layer anim-enter" sort="$Sort">
    <div id="exercise-$ID" class="content-container" >

        <a href="#" class="back-arrow button full" direction="back">
            <span>Previous Page</span>
        </a>

        <% if $Content %>
            <article class="box shadow typography text-box">
                <h1>$Title</h1>
                <div class="content">$Content</div>
            </article>
        <% end_if %>

        <article class="box shadow typography text-box">
            <div class="content"><h2 style="text-align:center">$exercise_result</h2></div>
        </article>



        <a href="#" class="next-arrow button full" direction="next">
            <span>Next Page</span>
        </a>

    </div>
</div>
