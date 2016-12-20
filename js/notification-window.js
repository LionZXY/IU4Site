/**
 * Created by lionzxy on 15.12.16.
 */

var cross = document.querySelectorAll(".cross");
var prev = performance.now();
var times = 0;

cross.forEach(function (item) {
    item.addEventListener("click", function (e) {
        item.parentElement.classList.add("hide");
        var cardBlock = item.parentElement;
        var childNum = getChildNumber(cardBlock);
    })
});

function animate(draw, duration) {
    var start = performance.now();

    requestAnimationFrame(function animate(time) {
        // определить, сколько прошло времени с начала анимации
        var timePassed = time - start;

        // возможно небольшое превышение времени, в этом случае зафиксировать конец
        if (timePassed > duration) timePassed = duration;

        // нарисовать состояние анимации в момент timePassed
        draw(timePassed);

        // если время анимации не закончилось - запланировать ещё кадр
        if (timePassed < duration) {
            requestAnimationFrame(animate);
        }

    });
}

function getChildNumber(node) {
    return Array.prototype.indexOf.call(node.parentNode.childNodes, node);
}