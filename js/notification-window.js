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
        setTimeout(function () {
            cardBlock.style.display = "none";
        }, 400);
    })
});

function getChildNumber(node) {
    return Array.prototype.indexOf.call(node.parentNode.childNodes, node);
}