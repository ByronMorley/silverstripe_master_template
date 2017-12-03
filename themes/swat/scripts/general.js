var max_image_event = function() {
    $(".overlay").on("click", function () {
        var tab_item = $(this).parent();
        var img = tab_item.find('.cover-image');

        $('#imagepreview').attr('src', img.attr('src'));
        $('#myModalLabel').text(tab_item.find('.menu-title').text());
        $('#imagemodal').modal('show');
    });
};

var video_init = function(){
    $('.anim-enter').find('video').attr('id');
    var id = $('video').attr('id');
    if(videojs.getPlayers()[id]) {
        delete videojs.getPlayers()[id];
    }
    videojs(id, { "aspectRatio":"16:9", "playbackRates": [1, 1.5, 2] }, function(){
        console.log('video player initialised');
    });
};