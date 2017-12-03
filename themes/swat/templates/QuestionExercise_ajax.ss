<div id="trans-page-info" class="no-display" dec="slide-down" inc="slide-up"></div>
<div class="animation-layer anim-leave" id="ajax-source">
</div>
<div class="animation-layer anim-enter" sort="$Sort">
    <div id="exercise-$ID" class="content-container" >

        <a href="#" class="submit-answers back-arrow button full" direction="back">
            <span>Previous Page</span>
        </a>

        <% if $Content %>
            <article class="box shadow typography text-box">
                <h1>$Title</h1>
                <div class="content">$Content</div>
            </article>
        <% end_if %>

        <!-- QUESTION EXERCISE -->
        <% if $Questions %>
            <ul class="questions exercise">
                <% loop $Questions %>
                    <li id="question-$ID">
                        <div class="box shadow typography text-box">
                            <h4>$Question</h4>
                        </div>
                        <ul class="answers">
                            <li class="box shadow square">$answer_1</li>
                            <li class="box shadow square">$answer_2</li>
                            <li class="box shadow square">$answer_3</li>
                        </ul>
                    </li>
                <% end_loop %>
            </ul>
        <% end_if %>

        <!-- END QUESTION EXERCISE -->

        $questionForm

        <a href="#" class="submit-answers next-arrow button full" direction="next">
            <span>Next Page</span>
        </a>

        <ul id="answers-given" class="no-display">
            <% loop $get_question_test_data %>
                <li questionid="$QuestionID" >$answer_given</li>
            <% end_loop %>
        </ul>
    </div>
</div>
<script>
    $(document).ready(function(){
        question_exercise_init();
    });
</script>