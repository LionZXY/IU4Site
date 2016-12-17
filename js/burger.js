(function () {
    document.querySelector(".burger").addEventListener("click", function (e) {
        e.preventDefault();
        var drawer = document.querySelector("#drawerMenu");
        if(this.classList.contains("isActive") === true){
            this.classList.remove("isActive");
            drawer.classList.remove("open");
        } else {
            this.classList.add("isActive");
            drawer.classList.add("open");
        }
    });

})();