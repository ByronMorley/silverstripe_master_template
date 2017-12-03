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
                $exercise_result
                <div class="content">$Content</div>
            </article>
        <% end_if %>

        <a href="#" class="next-arrow button full" direction="next">
            <span>Next Page</span>
        </a>
    </div>
</div>
