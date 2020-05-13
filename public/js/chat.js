$(document).ready(function () {
     $('.open').click(function () {
        $('.popup-window').popup();
    });
    $('.backpopup,.close').click(function () {
        $('.popup-window').fadeOut();
        $('.backpopup').fadeOut();
    });

    function findGetParameter(parameterName) {
        var result = null,
            tmp = [];
        location.search
            .substr(1)
            .split("&")
            .forEach(function (item) {
                tmp = item.split("=");
                if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
            });
        return result;
    }

    if (findGetParameter("open") == 1) {
        setTimeout(function(){$('#open').click();}, 100);
    }

});

$.fn.popup = function () {
    this.css('position', 'absolute').fadeIn();
    this.css('top', ($(window).height() - this.height()) / 2 + $(window).scrollTop() + 'px');
    this.css('left', ($(window).width() - this.width()) / 2  + 'px');
    $('.backpopup').fadeIn();
};

$(document).ready(function () {
    $('#shoutbox-comment').click(function(t){
        $(this).on('keyup', function (ev) {
            $("#error-message").text("");
            var keycode = ev.keyCode;
            if (keycode == '13') {
                var text = $('#shoutbox-comment').val();
                if ((text.trim()).length > 0 && (text.trim()).length < 100) {
                    var userId = document.getElementById("userId").value;
                    var mass = document.getElementById("ma");
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "sendMassage", false);
                    xhr.onreadystatechange = function () {
                         if (xhr.readyState == 4 && xhr.status == 200) {
                             if (xhr.responseText) {
                                 var li = document.createElement('li');
                                 li.className = "massage";
                                 li.innerHTML = text;
                                 mass.appendChild(li);
                                 document.getElementById('shoutbox-comment').value = "";
                             }
                         } else {
                             document.getElementById('shoutbox-comment').value = "";
                         }
                    };
                    var data = {
                        'message':text,
                        'id':userId
                    };
                    data = JSON.stringify(data);
                    setTimeout( function () {
                        reloadMyMessage();
                    }, 500);
                    xhr.setRequestHeader('Content-type', 'application/json');
                    xhr.send(data);

                } else {
                    document.getElementById('shoutbox-comment').value = "";
                    $("#error-message").text('Сообщение не может быть пустым, или быть длинее 240 символов');
                }
            }
        });
    });
    var el = document.getElementById('submit-massage');
    if (el) {
        $("#submit-massage").on("click", function (e) {
            var text = document.getElementById('shoutbox-comment').value;
            $("#error-message").text("");
            if (text.length > 0 && text.length < 100) {
                var userId = document.getElementById("userId").value;
                var mass = document.getElementById("ma");
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "sendMassage", false);
                xhr.onreadystatechange = function () {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        if (xhr.responseText) {
                            var li = document.createElement('li');
                            li.className = "massage";
                            li.innerHTML = text;
                            mass.appendChild(li);
                            document.getElementById("shoutbox-comment").value = "";
                        }
                    }
                };
                var data = {
                    'message':text,
                    'id':userId
                };
                data = JSON.stringify(data);
                setTimeout( function () {
                    reloadMyMessage();
                }, 500);
                xhr.setRequestHeader('Content-type', 'application/json');
            if (xhr.send(data)) {
                    alert("Сообщение отправлено! Оповещение выслано владельцу фото :)");
                }
            } else {
                $("#error-message").text('Сообщение не может быть пустым, или быть длинее 240 символов');
            }
        });
    }
});


function reloadMyMessage() {
    var massegeReload = document.getElementById("ma");
    var userId = document.getElementById("userId").value;
    var sesionId = $(".avat").attr('userId');
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "reloadMassage", true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            if (xhr.responseText) {
                var comment = new Object();
                comment = JSON.parse(xhr.responseText);
                $('.massage').remove();
                $('.massage2').remove();
                $('.date').remove();
                for (i = 0; i < comment.length; i++) {
                    var li = document.createElement('li');
                    if (i == 0) {
                        var li3 = document.createElement('li');
                        li3.className = "date";
                        li3.innerHTML = comment[0]['date'];
                        massegeReload.appendChild(li3);
                    }
                    var cla;
                    if (i > 0 ) {
                        if (comment[i]['date'] != comment[i - 1]['date']) {
                            var li2 = document.createElement('li');
                            li2.className = "date";
                            li2.innerHTML = comment[i]['date'];
                            massegeReload.appendChild(li2);
                        }
                    }
                    if (comment[i]['user_id'] == sesionId) {
                        cla = 'class="chatIm"';
                        li.className = "massage2";
                        li.innerHTML = '<span ' + cla + '>' + comment[i]['text'] + '</span>   ' + '<span class="time" >' + comment[i]['time'] + '</span>';
                    } else {
                        li.className = "massage";
                        li.innerHTML = '<span class="time" >' + comment[i]['time'] + '</span>' + '   ' + '<span class="chat_u" >' + comment[i]['text'] + '</span>';
                    }
                    massegeReload.appendChild(li);
                }
            }
        }
    };
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send('id=' + userId);
};


    $(document).ready(function () {
        $(".sm").bind("click", function(){
            var smile = $(this)[0].innerText;
            var text = $("#shoutbox-comment").val();
            var res = $("#shoutbox-comment").val(text + smile);
        });
});
