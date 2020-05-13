$(document).ready(function(){
    $(".stream").click(function () {
        let searchParams = new URLSearchParams(window.location.search);
        var id = searchParams.get('id');
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "pageMovie/viewedMovie", false);
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                ;
            }
        }
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.send('idMovie=' + id);

    })

    $(".like").click(function (e) {
        let searchParams = new URLSearchParams(window.location.search);
        var id = searchParams.get('id');
        var inactive_like = '/public/img/like.png';
        var active_like = '/public/img/like_activ.png';
        var like = $(".like");
        var src_nuw = like.attr('src');
        if (src_nuw == '/public/img/like.png') {
            like.attr("src",  active_like);
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "movieLike/add", false);
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    ;
                }
            }
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.send('idMovie=' + id);
        }
        if (src_nuw == '/public/img/like_activ.png') {
            like.attr("src",  inactive_like);
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "movieLike/del", false);
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    ;
                }
            }
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.send('idMovie=' + id);
        }
    })
});