var loginBtn = document.querySelector(".login_btn");
var registerBtn = document.querySelector(".register_btn");
var loginWindow = document.querySelector(".login_window")
loginBtn.addEventListener("click", function () {
    if (!loginWindow.classList.contains("login_state")) {
        loginWindow.classList.add("login_state");
        loginWindow.classList.remove("register_state");
        [].forEach.call(loginWindow.querySelectorAll(".register_field"), function (div) {
            div.querySelector("input").required = false;
        });
        loginWindow.querySelector("button").innerHTML = "Войти";
    }
});

registerBtn.addEventListener("click", function () {
    if (!loginWindow.classList.contains("register_state")) {
        loginWindow.classList.add("register_state");
        loginWindow.classList.remove("login_state");
        [].forEach.call(loginWindow.querySelectorAll(".register_field"), function (div) {
            div.querySelector("input").required = true;
        });
        loginWindow.querySelector("button").innerHTML = "Зарегестрироваться";
    }
});

// input.setCustomValidity(valOrFunction(options.invalidText, window, [input]));


function onClickLoginOrRegister() {
    var client = new XMLHttpRequest();
    loginWindow.querySelector(".submit_btn").innerHTML = "<div class='loader'></div>";
    if (loginWindow.classList.contains("register_state")) {

        var formData = new FormData(loginWindow.querySelector("form"));

        client.onreadystatechange = function () {
            if (client.readyState != 4) return;
            console.log(client.responseText);
            var response = JSON.parse(client.responseText);
            //TODO всякие уведомления умные

            if (response.status == 'sucs') {
                client.onreadystatechange = function () {
                    if (client.readyState != 4) return;
                    var response = JSON.parse(client.responseText);
                    if (response.status == 'sucs') {
                        alert("Успешно");
                        document.querySelector(".login_background").style.display = "none";
                        sucsLogin();
                    } else alert("Ошибка при загрузке изображения: " + response.error_text);

                    document.querySelector(".login_background").style.display = "none";
                };

                formData = new FormData();
                formData.append("image", loginWindow.querySelector('input[name="image"]').files[0]);

                client.open("post", "/api/v1/image.php?type=avatar");
                client.send(formData);
            }
            else {
                alert(response.error_text);
                loginWindow.querySelector(".submit_btn").innerHTML = "<button>Зарегестрироваться</button>"
            }
        };

        client.open("post", "/api/v1/register.php", true);
        client.send(formData);
    } else if (loginWindow.classList.contains("login_state")) {
        var formData = new FormData(loginWindow.querySelector("form"));

        client.onreadystatechange = function () {
            if (client.readyState != 4) return;
            console.log(client.responseText);
            var response = JSON.parse(client.responseText);
            //TODO всякие уведомления умные
            if (response.status == 'sucs') {
                alert("Успешно");
                document.querySelector(".login_background").style.display = "none";
                sucsLogin();
            }
            else {
                alert(response.error_text);
                loginWindow.querySelector(".submit_btn").innerHTML = "<button>Войти</button>"
            }
        };

        client.open("post", "/api/v1/login.php", true);
        client.send(formData);
    }
    return false;
}

