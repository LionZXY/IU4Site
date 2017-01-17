console.log("Load script messages.js");
if (document.querySelectorAll(".events_card").length > 0)
    updateDialog(parseInt(document.querySelectorAll(".events_card")[0].getAttribute("data-row")));
[].forEach.call(document.querySelectorAll(".events_card"), function (item) {
    var message_box = document.querySelector(".message_box");
    var dialogId = parseInt(item.getAttribute("data-row"));
    item.addEventListener("click", function (e) {
        updateDialog(dialogId)
    })
});

function updateDialog(dialogId) {
    var message_box = document.querySelector(".message_box");
    console.log(message_box);
    message_box.innerHTML = "<div class='loader'></div>";
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
}

function sendMessage(dialogId) {
    var message_box = document.querySelector(".message_box");
    var client = new XMLHttpRequest();
    var formData = new FormData();
    var input = document.getElementById("sendMessage").querySelector('input[type="text"]').value;
    if (input.length == 0) {
        updateDialog();
        return false;
    }
    formData.append("dialog", dialogId);
    formData.append("msg", input);

    client.onreadystatechange = function () {
        if (client.readyState != 4) return;
        if (JSON.parse(client.responseText).status == "sucs") {
            var div = document.createElement('div');
            div.classList.add("m");
            div.classList.add("m_to");
            div.innerHTML = '<div class="">' + input + '</div>';
            document.querySelector(".messages").insertBefore(div, document.querySelector(".messages").firstChild);
        } else alert(client.responseText);
    };

    client.open("post", "api/v1/sendMessage.php", true);
    client.send(formData);
    document.getElementById("sendMessage").querySelector('input[type="text"]').value = "";
    return false;
}