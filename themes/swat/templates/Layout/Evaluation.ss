<!-- Evaluation Layout -->
<div class="content-container">

    <ul id="evaluation-$ID" class="survey">

        <% loop $Children %>
            <li id="question-$ID" class="eval-question" title="$Title" type="$multiple_answer_allowed">
                <article class="box shadow typography text-box">
                    <h1>$Title</h1>
                    <h2>$Content</h2>
                    <ul>
                        <% loop $Top.evaluationQuestionChoice($ID) %>
                            <li id="choice-$ID" class="eval-choice" type="$Top.has_extended_field($ID)">
                                <% if $textfieldonly %>

                                    <textarea class="comments"></textarea>
                                    <<% else %>

                                    <div class="tick-box empty"></div>
                                    <p>$choice</p>
                                    <% if $extended_field == 1%>
                                        <textarea placeholder="please specify...." class="fold" ></textarea>
                                    <% end_if %>
                                <% end_if %>
                            </li>
                        <% end_loop %>
                    </ul>
                </article>
            </li>
        <% end_loop %>
        $evaluationForm


        <a href="$absoluteBaseURL\main-menu/" id="submit-evaluation" class="button full">
            <span>Submit</span>
        </a>

    </ul>

</div>
<script>
    $(document).ready(function(){
        exercise_init();
    });
</script>