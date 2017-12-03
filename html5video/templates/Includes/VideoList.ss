<div class="video-list">
	<% loop $VideoList %>
		<div class="video">
			<div class="unit size1of3">
				<a href="$Link">
					<% if $Image %>$Image.CroppedImage(800,450)<% else %><img src="/html5video/images/PreviewUnavailable.jpg"><% end_if %>
				</a>
			</div>
			<div class="unit lastunit size2of3">
				<h3><a href="$Link">$Title</a><% if $Time %> - $Time<% end_if %></h3>
				<% if $Content %><p>$Content.FirstParagraph</p><% end_if %>
			</div>
			<div class="clear"></div>
		</div>
	<% end_loop %>
	
	<div class="clear"></div>
	
	<% with $VideoList %>
		<% include VideoPagination %>
	<% end_with %>
</div>