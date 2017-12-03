<% require css(html5video/css/video.css) %>
<% include SideBar %>
<div class="content-container unit size3of4 lastUnit">
	<article>
    	<h1>$Title</h1>
	    <% if $MP4Video %>
	    	<div class="video-container">
			<video id="really-cool-video" class="video-js vjs-default-skin vjs-big-play-centered" controls preload="auto" width="800" height="450" data-setup='{"fluid": true}' <% if $Image %>poster="$Image.CroppedImage(800,450).AbsoluteURL"<% end_if %>>
				<source src="$MP4Video.AbsoluteURL" type="video/mp4" />
				<% if $WebMVideo %><source src="$WebMVideo.AbsoluteURL" type="video/webm" /><% end_if %>
				<% if $OggVideo %><source src="$OggVideo.AbsoluteURL" type="video/ogg" /><% end_if %>
                <p class="vjs-no-js">
                    To view this video please enable JavaScript, and consider upgrading to a web browser
                    that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
                </p>
			</video>
			</div>
		<% end_if %>
		$Content
		<%-- Related Videos --%>
		<% if $RelatedVideos %>
		<hr>
		<h3>Other Videos</h3>
			<% loop RelatedVideos.Limit(3).Sort('RAND()') %>
				<div class="video unit size1of3">
					<a href="$Link">
						<% if $Image %>$Image.CroppedImage(400,225)<% else %><img src="/html5video/images/PreviewUnavailable.jpg"><% end_if %>
					</a>
					<h4><a href="$Link">$Title</a><% if $Time %> - $Time<% end_if %></h4>
				</div>
			<% end_loop %>
		<% end_if %>
    </article>
    $Form
    $CommentsForm
</div>