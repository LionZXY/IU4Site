<div class="login_background">
    <div class="login_window login_state">
        <form method="post" enctype="multipart/form-data" onsubmit="return onClickLoginOrRegister();">
            <div class="btns">
                <div class="login_btn">Авторизация</div>
                <div class="register_btn">Регистрация</div>
            </div>
            <div class="register_field">
                <div class="group">
                    <input class="matimp" type="text" name="name" pattern="^([А-Яа-яA-Za-z]+ [А-Яа-яA-Za-z]+)$" title="Имя должно состоять из двух слов. В словах должны быть только буквы русского и латинского алфавита">
                    <span class="highlight"></span>
                    <span class="bar"></span>
                    <label>Видимое имя</label>
                </div>
            </div>
            <div>
                <div class="group">
                    <input class="matimp" type="text" name="login" pattern="^([A-Za-z0-9]+)$" title="В логине пользователя можно использовать только символы латинского алфавита" required>
                    <span class="highlight"></span>
                    <span class="bar"></span>
                    <label>Имя пользователя</label>
                </div>
            </div>
            <div>
                <div class="group">
                    <input class="matimp" type="password" name="password" required>
                    <span class="highlight"></span>
                    <span class="bar"></span>
                    <label>Пароль</label>
                </div>
            </div>
            <div class="file_input register_field">
                <input type="file" name="image" id="avatar_file" class="inputfile"/>
                <label for="avatar_file">
                    <svg width="20" height="17" viewBox="0 0 20 17">
                        <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"></path>
                    </svg>
                    <span>Выберите изображение</span></label>
            </div>
            <script src="js/material_input_file.js"></script>
            <div class="submit_btn">
                <button>Войти</button>
            </div>
        </form>
    </div>
</div>

<script src="js/login.js"></script>