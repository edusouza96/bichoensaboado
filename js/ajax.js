function ajax(url, div) {
  req = null;
  if (window.XMLHttpRequest) {
    req = new XMLHttpRequest();
    req.onreadystatechange = processReqChange;
    req.open("GET", url, true);
    req.send(null);
  } else if (window.ActiveXObject) {
    req = new ActiveXObject("Microsoft.XMLHTTP");
    if (req) {
      req.onreadystatechange = processReqChange;
      req.open("GET", url, true);
      req.send(null);
    }
  }
}

function processReqChange() {
  if (req.readyState == 4) {
    if (req.status ==200) {
      var returnn = req.responseText;
      var arrayReturnn = returnn.split(",");
      var owner = document.getElementById("owner");
      while (owner.length) {
        owner.remove(0);
      }
      for (i = 0; i < arrayReturnn.length; i++) {
        var arrayReturnnId = arrayReturnn[i].split("_"); 
        var opt0 = document.createElement("option");
        opt0.value = arrayReturnnId[1];
        opt0.text = arrayReturnnId[1];
        owner.add(opt0, owner.options[0]);
      }

      
    } else{
      alert("Houve um problema ao obter os dados:n" + req.statusText);
    }
  }
}