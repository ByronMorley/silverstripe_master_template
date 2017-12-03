<article class="box shadow typography text-box">
	<!-- VIDEO SECTION -->
    <% if $VideoFileID %>
        <% loop $Top.VideoFile($VideoFileID) %>
			<h1>$Title</h1>
			<h2>$Content</h2>
			<div class="video-wrapper">
				<video id="video_1" class="$Title video-js vjs-default-skin" width="640px" height="380px"
					   controls preload="none" poster='$PosterImage.Filename'>
					<source src="$MP4Video.AbsoluteURL" type="video/mp4"/>
                    <% if $WebMVideo %>
						<source src="$WebMVideo.AbsoluteURL" type="video/webm"/><% end_if %>
                    <% if $OggVideo %>
						<source src="$OggVideo.AbsoluteURL" type="video/ogg"/><% end_if %>
					<p class="vjs-no-js">
						To view this video please enable JavaScript, and consider upgrading to a web browser
						that <a href="http://videojs.com/html5-video-support/" target="_blank">supports
						HTML5 video</a>
					</p>
				</video>
			</div>
        <% end_loop %>
    <% end_if %>
</article>