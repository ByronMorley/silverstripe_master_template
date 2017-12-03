<article class="box shadow typography text-box">
    <!-- IMAGE SECTION -->
    <% if $ShowTitle %>
        <h1>$Title</h1>
    <% end_if %>
    <% if $Photo %>
        <div class="image-wrapper">
            <img src="$Photo.filename" class="cover-image"/>
            <div class="overlay">
                <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
            </div>
        </div>
    <% end_if %>
</article>