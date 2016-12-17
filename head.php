<div id="drawerMenu">
    <div>
        <?php
        for ($i = 0; $i < 5; $i++)
            echo '<a href><span class="iconClass" style="background-position: 0px -24px;"></span>Пункт ', $i, '</a>';
        ?>
    </div>
</div>
<button class="burger">
    <span></span>
</button>
<div id="topBar">
    <div id="rightButtons">
        <a id="roundAvatar">
            <div id="triangleAva" class="triangle"></div>
        </a>
        <a id="notifications" class="iconClass" href>
            <div id="triangleNotifications" class="triangle"></div>
        </a>
        <div class="window-head">
            <div class="window_content">
                <div class="loader">Loading...</div>
            </div>
        </div>
    </div>
</div>
<script src="js/burger.js"></script>
<script src="js/head.js"></script>