function sucsLogin() {
    var client = new XMLHttpRequest();

    document.querySelector("#roundAvatar").src = "/api/v1/image.php?type=avatar";
    client.onreadystatechange = function () {
        if (client.readyState != 4) return;
        var wrapper = document.createElement('div');
        wrapper.innerHTML = client.responseText;
        var div = wrapper.firstChild;

        document.querySelector(".main").insertBefore(div, document.querySelector(".main").querySelector(".message_box"));
        loadScriptAndRun(wrapper);
    };

    client.open("GET", "events.php", true);
    client.send();
}

function loadScriptAndRun(element) {
    var scripts = element.getElementsByTagName("script");

    for (var i = 0; i < scripts.length; i++) {
        var src = scripts.item(i).attributes.getNamedItem("src");
        if (src == null)
            eval('(' + scripts.item(i).innerText || scripts.item(i).textContent + ');');
        else {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status != 404) {
                    eval(xhr.responseText);
                }
            };
            xhr.open('GET', src.value, true);
            xhr.send();
        }
    }
}