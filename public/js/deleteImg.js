var arr = document.getElementsByName("delete");

function dell_foto(img){
    var foto = document.getElementById(img);
    var foto1 = foto.parentNode;
    var foto2 = foto1.parentNode;
    foto2.removeChild(foto1);
}

function dell_img(img){
    var xhr = new XMLHttpRequest();
    xhr.open("POST", '/personalArea/delimg', true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            if ( xhr.responseText.indexOf("true") == -1)
            {
                dell_foto(img);
                alert("Фото удалено");
            }
        }
    }
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send('foto=' + img);
}

for(var foto  in arr)
{
    if(typeof(arr[foto]) == 'object')
    {
        var img = arr[foto].getAttribute('id');

        arr[foto].setAttribute('onclick', "dell_img("+img+")");
    }
}