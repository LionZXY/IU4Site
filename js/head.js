(function () {
    document.querySelector("#notifications").addEventListener("click", function (e) {
        e.preventDefault();
        openWindowElement(e.target, "notification-window");
    });
    document.querySelector("#roundAvatar").addEventListener("click", function (e) {
        e.preventDefault();
        openWindowElement(e.target, "login-window")
    });

    function openWindowElement(item, classWindowName) {
        var triangles = document.querySelectorAll(".triangle");
        var isOpenDialog = false;
        triangles.forEach(function (i) {
            if (i.parentElement == item && !i.classList.contains("isShow")) {
                isOpenDialog = true;
                i.classList.add("isShow");
            }
            else i.classList.remove("isShow");
        });

        var windowContent = document.querySelector(".window_content");
        windowContent.innerHTML = '<div class="loader">Loading...</div>';
        var windowClasss = document.querySelector(".window-head").classList;
        //Каждый раз при добавлении нового элемента стоит обновлять эту строку
        windowClasss.remove("login-window");
        windowClasss.remove("notification-window");
        if (isOpenDialog) {
            windowClasss.add(classWindowName);
            windowClasss.add("isShow");
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status != 404) {
                    windowContent.innerHTML = xhr.responseText;
                    loadScriptAndRun(windowContent);
                }
            };
            //TODO
            xhr.open('GET', classWindowName + '.php', true);
            xhr.send();

        } else
            windowClasss.remove("isShow");

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
})();