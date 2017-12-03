<ul class="square-tab-menu row-3">
    <% loop $ResourceItems %>
        <li>
            <div class="tab-item">

                <% if $Photo %>
                    <img src="$Photo.filename" class="cover-image"/>
                <% else %>
                    <img src="$ThemeDir/assets/images/no-image-found.png" class="cover-image"/>
                <% end_if %>

                <div class="overlay">
                    <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                    <h1 class="menu-title">$Title</h1>
                </div>
                <a href="$Photo.Filename" target="_blank" class="button full download-bar" download="filename">
                    <span>Download</span>
                </a>

            </div>
        </li>
    <% end_loop %>
</ul>
<% include Modal %>
<script>
    $(document).ready(function () {
        max_image_event();
    });
</script>
