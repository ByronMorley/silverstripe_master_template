<div id="trans-page-info" class="no-display" dec="slide-down" inc="slide-up"></div>
<div class="animation-layer anim-leave" id="ajax-source">
</div>
<div class="animation-layer anim-enter" sort="$Sort">
    <div id="exercise-$ID" class="content-container" >

        <a href="#" class="submit-answers back-arrow button full" direction="back">
            <span>Previous Page</span>
        </a>

        <!-- SCENARIO EXERCISE -->
        <% if $Content %>
            <article class="box shadow typography text-box">
                <h1>$Title</h1>
                <div class="content">$Content</div>
            </article>
        <% end_if %>
        <a href="#" id="problem" class="submit-answers next-arrow button full" direction="next" >
            <span>Problem</span>
        </a>
        <a href="#" id="limitation" class="submit-answers next-arrow button full" direction="next" >
            <span>Limitation</span>
        </a>

        $scenarioForm

        <!-- END SCENARIO EXERCISE -->


        <!--<a href="#" class="submit-answers next-arrow button full" direction="next">
            <span>Next Page</span>
        </a>-->

    </div>
</div>
<script>
    $(document).ready(function(){
        scenario_exercise_init();
    });
</script>