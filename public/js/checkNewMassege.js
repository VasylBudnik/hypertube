$(document).ready(function () {

    var userId = $(".avat").attr('userid');
    var test = [];
    setInterval(function () {
        $.ajax({
            url: "checkNewMassege",
            data: {"id": userId},
            type: "POST",
            success: function(data) {

                if (data.errors === false) {
                    console.log("Error");
                } else {
                    var chat = new Object();
                    chat = JSON.parse(data);
                    var i = 0;
                    var len = chat.length;
                    if (test.length === 0) {
                        while (i < len) {
                            test[i] = chat[i]['count'];
                            i++;
                        }
                    }
                    i = 0;
                    while (i < len) {
                        if (test[i] === chat[i]['count']) {
                            i++;
                            continue;
                        }
                        else {
                            test[i] = chat[i]['count'];
                            i++;
                            checkMessage();
                            continue;
                        }
                    }
                }
            },
            error: function (request, status, error) {
                console.log("ERROR");
            }
        });
    }, 2000);

    $(document).click(function (event) {
        if ($(event.target).closest('#newMassege').length) {
            $(".global-chat").show();
            $('.popup-window').popup();
            checkMessage();
        }

        if ($(event.target).closest('.backpopup,.close').length) {
            $(".global-chat").hide();
            $('.popup-window').fadeOut();
            $('.backpopup').fadeOut();
        }

    });

    function checkMessage() {
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
});
