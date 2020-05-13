window.onload=function() {
    $("#addComment #submit").on("click", function (e) {
        var text = escapeHtml($('#comment').val());
        $('#comment').val("");
        if (text.length > 0 && text.length < 100) {
           var nameUser = $(".user").text();
           let searchParams = new URLSearchParams(window.location.search);
           var id = searchParams.get('id');

            var xhr = new XMLHttpRequest();

                xhr.open("POST", "pageMovie/movieComment", false);
                xhr.onreadystatechange = function () {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        $("#cont").append("<div class=\"commentin\"><span class=\"name\">" + nameUser + " :</span> <span class=\"com\" >" + text + "</span></div>");
                        var block = document.getElementById("cont");
                        block.scrollTop = block.scrollHeight;
                    }
                }
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhr.send('comment=' + JSON.stringify(text) + '&idMovie=' + id);
        }
        else{
             alert("Коментарий не может быть пустым, или быть длинее 100 символов")
         }
    });
    var block = document.getElementById("cont");
    if(block) {
        block.scrollTop = block.scrollHeight;
    }

    function escapeHtml(unsafe) {
        return unsafe
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }

}
