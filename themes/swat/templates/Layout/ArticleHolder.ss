<div class="content-container">
    <article>
        <h1>$Title</h1>
        <div class="content">
            $Content
        </div>

        <% if $Children %>
            <div>
                <ul class="square-tab-menu $TabCount">
                    <% loop $Children %>
                        <li>
                            <div class="tab-item">

                                <% if $CoverImage %>
                                    <img src="$CoverImage.filename" class="cover-image"/>
                                <% else %>
                                    <img src="$ThemeDir/assets/images/no-image-found.png" class="cover-image"/>
                                <% end_if %>

                                <div class="overlay">
                                    <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                </div>

                                <h2 class="menu-title">$MenuTitle</h2>

                                <% if $Presentation %>
                                    <a href="$Presentation.URL" download>
                                        <span class="menu-button">Download<span class="glyphicon glyphicon glyphicon-save" aria-hidden="true"></span></span>
                                    </a>
                                <% end_if %>

                            </div>

                            <% if $Content %>
                                <div class="tab-item-article">
                                    <div class="tab-item-title">
                                        <h2>$Title</h2>
                                    </div>
                                    <div class="tab-item-content">
                                        <p>$Content.FirstParagraph<a href="$Link">...continue reading</a></p>
                                    </div>
                                </div>
                            <% end_if %>
                        </li>
                    <% end_loop %>
                </ul>
            </div>
        <% end_if %>
    </article>
    $Form
    $CommentsForm
</div>
<% include Modal %>
<script>
    $(document).ready(function () {

        $(".overlay").on("click", function () {

            var tab_item = $(this).parent();
            var img = tab_item.find('.cover-image');

            $('#imagepreview').attr('src', img.attr('src'));
            $('#myModalLabel').text(tab_item.find('.menu-title').text());
            $('#imagemodal').modal('show');
        });

    });
</script>