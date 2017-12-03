<div id="trans-page-info" class="no-display" dec="slide-down" inc="slide-up"></div>
<div class="animation-layer anim-leave" id="ajax-source">
</div>
<div class="animation-layer anim-enter" sort="$Sort">
    <div id="exercise-$ID" class="content-container">

        <a href="#" class="submit-answers back-arrow button full" direction="back">
            <span>Previous Page</span>
        </a>

        <% if $Content %>
            <article class="box shadow typography text-box">
                <h1>$Title</h1>
                <div class="content">$Content</div>
            </article>
        <% end_if %>

        <!-- ORDER EXERCISE -->

        <%if $OrderSelections %>

            <article class="box shadow typography text-box">
                <ul class="drag-and-drop">
                    <li>
                        <ul class="order">
                            <% loop $OrderSelections %>
                                <li><h4>$Pos</h4></li>
                            <% end_loop %>
                        </ul>
                    </li>
                    <li>
                        <ul id="selection-area" class="selection area">
                            <%if $check_for_save_data %>
                                <% loop $saved_selection_data %>
                                    <li id="selection-$ID" answer="$correct_order"><p>$statement</p></li>
                                <% end_loop %>
                            <% else %>
                                <% loop $OrderSelections %>
                                    <li id="selection-$ID" answer="$correct_order"><p>$statement</p></li>
                                <% end_loop %>
                            <% end_if %>
                        </ul>
                    </li>
                </ul>
            </article>
        <% end_if %>

        <!-- END ORDER EXERCISE -->

        $orderForm

        <a href="#" class="submit-answers next-arrow button full" direction="next">
            <span>Next Page</span>
        </a>

        <ul id="answers-given" class="no-display">
            <% loop $get_order_test_data %>
                <li orderid="$OrderSelectionID">$order</li>
            <% end_loop %>
        </ul>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('.drag-and-drop').hades_dnd();
        order_exercise_init();
    });
</script>