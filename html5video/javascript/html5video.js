(function ($) {
    $(function () {
        if ($('.paginate').length) {
            var paginate = function (url) {
                var param = '&ajax=1',
                    ajaxUrl = (url.indexOf(param) === -1) ? url + '&ajax=1' : url,
                    cleanUrl = url.replace(new RegExp(param + '$'), '');
                $.ajax(ajaxUrl)
                    .done(function (response) {
                        $('.video-holder').html(response);
                        $('html, body').animate({
                            scrollTop: $('.video-holder').offset().top
                        });
                        window.history.pushState(
                            {url: cleanUrl},
                            document.title,
                            url
                        );
                    })
                    .fail(function (xhr) {
                        console.log('Error: ' + xhr.responseText);
                    });
            };
            $('.main').on('click', '.pagination a', function (e) {
                e.preventDefault();
                var url = $(this).attr('href');
                paginate(url);
            });
            window.onpopstate = function (e) {
                if (e.state.url) {
                    paginate(e.state.url);
                }
                else {
                    e.preventDefault();
                }
            };
        }
    })
})(jQuery);