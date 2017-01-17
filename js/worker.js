self.addEventListener('message', function(evt) {
    var gateway = new XMLHttpRequest();
    var intie = setInterval(function() {
        gateway.open("GET",evt.data.load_url,true);
        gateway.send();
        gateway.onreadystatechange = function() {
            if (gateway.readyState==4 && gateway.status==200)
                self.postMessage(gateway.responseText);
        }
    }, 5000); //каждые 5 секунд
}, false);