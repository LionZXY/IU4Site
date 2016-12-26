(function () {
});

function sucsLogin() {
    var client = new XMLHttpRequest();

    document.querySelector("#roundAvatar").src = "/api/v1/image.php?type=avatar";
    client.onreadystatechange = function () {

    };
    client.open("GET", "events.php")
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
                    console.log(xhr.responseText);
                    eval(xhr.responseText);
                }
            };
            xhr.open('GET', src.value, true);
            xhr.send();
        }
    }
}