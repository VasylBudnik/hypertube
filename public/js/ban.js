$(document).ready(function () {
   var current_url = window.location.protocol + "//" + window.location.host;
   if ($("#ban")) {
       addEventListener('click', function (event) {
           if (event.toElement.src == current_url + "/public/img/ban.png"){
               event.toElement.src = current_url + "/public/img/ban_n.png";
              var id_user = (event.toElement.attributes.value.value);
               $.post(current_url + "/userbandell", {
                   idUser: id_user
               },);
           } else if (event.toElement.src == current_url + "/public/img/ban_n.png") {
               event.toElement.src = current_url + "/public/img/ban.png";
               var id_user = (event.toElement.attributes.value.value);
               $.post(current_url + "/userbanadd", {
                   idUser: id_user
               },);
           }
       });
   }
});
