$('a').click(function(e) {
    e.preventDefault();
    var url = this.href;
    $.get(url, function(html) {
        $('.newpage').html(html).animate({ left: "-= 1000px" }, function() {
            window.history.pushState({}, "New Page Title", url );
        });
    });
    return false;
});
