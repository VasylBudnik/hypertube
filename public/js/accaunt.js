window.onload=function() {

    var im1 = document.getElementById("min1");
    var im2 = document.getElementById("min2");
    var im3 = document.getElementById("min3");
    var im4 = document.getElementById("min4");
    var im5 = document.getElementById("min5");

    if (im1) {
        document.getElementById("min1").addEventListener("click", test1);
    }
    if (im2) {
        document.getElementById("min2").addEventListener("click", test2);
    }
    if (im3) {
        document.getElementById("min3").addEventListener("click", test3);
    }
    if (im4) {
        document.getElementById("min4").addEventListener("click", test4);
    }
    if (im5) {
        document.getElementById("min5").addEventListener("click", test5);
    }

    if (document.getElementById("user_like")){
        document.getElementById("user_like").addEventListener("click", like);
    }

    if (document.getElementById("min1")){
        test1();
    }

    function test1() {

        var big = (document.getElementById("user_avatar"));
        var min = document.getElementById("min1").lastChild;
        big.removeAttribute("src");
        big.setAttribute("src", min.getAttribute("src"));
    }

    function test2() {

        var big = (document.getElementById("user_avatar"));
        var min = document.getElementById("min2").lastChild;
        big.removeAttribute("src");
        big.setAttribute("src", min.getAttribute("src"));
    }

    function test3() {
        var big = (document.getElementById("user_avatar"));
        var min = document.getElementById("min3").lastChild;
        big.removeAttribute("src");
        big.setAttribute("src", min.getAttribute("src"));

    }

    function test4() {
        var big = (document.getElementById("user_avatar"));
        var min = document.getElementById("min4").lastChild;
        big.removeAttribute("src");
        big.setAttribute("src", min.getAttribute("src"));
    }

    function test5() {
        var big = (document.getElementById("user_avatar"));
        var min = document.getElementById("min5").lastChild;
        big.removeAttribute("src");
        big.setAttribute("src", min.getAttribute("src"));
    }


    var AJAXLike = function (pathLine, id) {
        var res;
        var xhr = new XMLHttpRequest();
        xhr.open("POST", pathLine, false);
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                if (xhr.responseText.indexOf("true") == -1) {
                    res = false;
                } else {
                    res = true;
                }
            }
        };

        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.send('id=' + id);
        return (res);
    }


    function like() {
        var like = document.getElementById("user_like");
        var current_url = window.location.protocol + "//" + window.location.host;
        var text = like.getAttribute("src");
        var inactive_like = current_url + '/public/img/like.png';
        var active_like = current_url + '/public/img/like_activ.png';
        var userId = document.getElementById("img").getAttribute("userId");
        var path_php;

        if (text.indexOf(active_like) == -1) {
            path_php = "acauntLike/add";
            if (AJAXLike(path_php, userId) === true) {
                like.setAttribute("src", active_like);
            } else
                alert("Вы не можете лайкнуть данного пользователя!");

        } else {
            path_php = "acauntLike/del";
            if (AJAXLike(path_php, userId) === true) {
                like.setAttribute("src", inactive_like);

            } else {
                alert("Войдите в аккаунт чтобы убрать лайк!");
            }
        }
    }
}
