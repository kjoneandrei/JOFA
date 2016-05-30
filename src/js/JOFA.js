/**
 * Created by Ferenc_S on 5/20/2016.
 */
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});

function loadUserNameId() {
    if ($('#recipient').is(':empty')) {
        var data = {
            "action": "loadUserNameId"
        };
        data = $(this).serialize() + "&" + $.param(data);
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "ajaxmanager.php",
            data: data,
            success: function (data) {
                fillUserList(data);
            }
        });
    }
}

function fillUserList(users) {
    var select = document.getElementById('recipient');
    for (var i = 0; i < users.length; i++) {
        var option = document.createElement('option');
        option.value = users[i]['id'];
        option.innerHTML = users[i]['username'];
        select.appendChild(option);
    }
}