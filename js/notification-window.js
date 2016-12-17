/**
 * Created by lionzxy on 15.12.16.
 */
(function () {
  var cross = document.querySelectorAll(".cross").forEach(function (item) {
      item.addEventListener("click",function (e) {
          e.parentElement.parentElement.classList.add("hide");
      })
  });
});