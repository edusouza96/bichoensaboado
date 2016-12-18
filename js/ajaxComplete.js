function ajaxComplete(url, div) {
  req = null;
  if (window.XMLHttpRequest) {
    req = new XMLHttpRequest();
    req.onreadystatechange = processReqChange1;
    req.open("GET", url, true);
    req.send(null);
  } else if (window.ActiveXObject) {
    req = new ActiveXObject("Microsoft.XMLHTTP");
    if (req) {
      req.onreadystatechange = processReqChange1;
      req.open("GET", url, true);
      req.send(null);
    }
  }
}

function processReqChange1() {
  if (req.readyState == 4) {
    if (req.status ==200) {
      var returnn = req.responseText;
      var arrayReturnn = returnn.split(",");
      var breed = document.getElementById("breed");
      var address = document.getElementById("address");
      var district = document.getElementById("district");
      var phone1 = document.getElementById("phone1");
      var phone2 = document.getElementById("phone2");
      
      for (i = 0; i < arrayReturnn.length; i++) {
        var arrayReturnnId = arrayReturnn[i].split("_"); 
        breed.value = arrayReturnnId[0];
        address.value = arrayReturnnId[1];
        district.value = arrayReturnnId[2];
        phone1.value = arrayReturnnId[3];
        phone2.value = arrayReturnnId[4];
      }

      
    } else{
      alert("Houve um problema ao obter os dados:n" + req.statusText);
    }
  }
}