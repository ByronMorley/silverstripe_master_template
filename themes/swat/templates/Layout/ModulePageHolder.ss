<div id="ajax-plugin-area" class="ajax-container" >

</div>
<!-- Ajax Setup -->

<ul style="display:none;" id="ajax-child-list">
    <% loop $Children %>
        <li link="$Link" title="$MenuTitle" ></li>
    <% end_loop %>
</ul>
<% include Modal %>
<script>
    $(document).ready(function(){

        $('#ajax-plugin-area').ajax_plugin({

            child_list:$('#ajax-child-list'),
            ajax_container:'ajax-container',

            nav_next_frame:'next-arrow',
            nav_prev_frame:'back-arrow',

            initialise_javascript_dependencies:function(){
                console.log("add Javascript dependencies");
                max_image_event();
            }
        });
    });
</script>