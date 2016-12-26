var message_box = document.querySelector(".message_box");
[].forEach.call(document.querySelectorAll(".events_card"), function (item) {
    var dialogId = parseInt(item.getAttribute("data-row"));
    item.addEventListener("click", function (e) {
        message_box.innerHTML = "<div class='loader'></div>"
        message_box.style.justifyContent = "center";

        var client = new XMLHttpRequest();
        client.onreadystatechange = function () {
            if (client.readyState != 4) return;
            message_box.innerHTML = client.responseText;
            console.log(client.responseText);
            message_box.style.justifyContent = "";
        };

        client.open("get", "/message.php?dialog=" + dialogId, true);
        client.send();
    })
});

function sendMessage(dialogId) {
    var client = new XMLHttpRequest();
    var formData = new FormData();
    var input = document.getElementById("sendMessage").querySelector('input[type="text"]').value;
    if (input.length == 0)
    //TODO обновление диалога
        return false;
    formData.append("dialog", dialogId);
    formData.append("msg", input);

    client.onreadystatechange = function () {
        if (client.readyState != 4) return;
    };

    client.open("post", "api/v1/sendMessage.php", true);
    client.send(formData);
    return false;
}