function ajax(url) {
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
      var returnn = req.responseText.split(",");
      var idField = parseInt(returnn[0]);
      
      var breed = document.getElementById("breed"+idField);
      var address = document.getElementById("address"+idField);
      var district = document.getElementById("district"+idField);
      var phone1 = document.getElementById("phone1"+idField);
      var phone2 = document.getElementById("phone2"+idField);
        breed.innerHTML = returnn[1];
        address.innerHTML = returnn[4]+', '+returnn[3]+'\n'+returnn[2];
        district.innerHTML = returnn[5];
        phone1.innerHTML = returnn[6];
        phone2.innerHTML = returnn[7];
      
    } else{
      alert("Houve um problema ao obter os dados:n" + req.statusText);
    }
  }
}