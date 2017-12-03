<% require css(html5video/css/video.css) %>
<% require javascript('framework/thirdparty/jquery/jquery.js') %>
<% require javascript(html5video/javascript/html5video.js) %>

<% include SideBar %>
<div class="content-container unit size3of4 lastUnit">
	<article>
    	<h1>$Title</h1>
	    $Content
		<div class="video-holder">
        	<% include VideoList %>
        </div>

	</article>
    $Form
    $CommentsForm
</div>