/**
 *Completa todos campos
 */
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
      var service = document.getElementById("service"+idField);
      var deliveryPrice = document.getElementById("deliveryPrice"+idField);
      var option = '<option value>-- Selecione --</option>';
      for(var i=9; i<returnn.length; i++){
        var optionFormat = returnn[i].split("-");
        option += '<option value='+optionFormat[0]+'>'+optionFormat[1]+'</option>';
      }
      breed.innerHTML = returnn[1];
      address.innerHTML = returnn[4]+', '+returnn[3]+'\n'+returnn[2];
      district.innerHTML = returnn[5];
      phone1.innerHTML = returnn[6];
      phone2.innerHTML = returnn[7];
      service.innerHTML = '<select id="service'+idField+'" name="service" onChange="selectValuation(this.value,'+idField+');" class="form-control">'+option+'</select>';
      deliveryPrice.value = returnn[8];

    } else{
      alert("Houve um problema ao obter os dados:n" + req.statusText);
    }
  }
}

/**
 *Completa Valor do serviço
 */
function ajaxValuation(url) {
  req = null;
  if (window.XMLHttpRequest) {
    req = new XMLHttpRequest();
    req.onreadystatechange = processReqValuation;
    req.open("GET", url, true);
    req.send(null);
  } else if (window.ActiveXObject) {
    req = new ActiveXObject("Microsoft.XMLHTTP");
    if (req) {
      req.onreadystatechange = processReqValuation;
      req.open("GET", url, true);
      req.send(null);
    }
  }
}

function processReqValuation() {
  if (req.readyState == 4) {
    if (req.status ==200) {
      var returnn = req.responseText.split(",");
      var idField = parseInt(returnn[0]);
      
      var price = document.getElementById("price"+idField);
      var deliveryPrice = document.getElementById("deliveryPrice"+idField);
      var totalPrice = document.getElementById("totalPrice"+idField);
      
      price.value = returnn[1];
      totalPrice.innerHTML = parseFloat(deliveryPrice.value) + parseFloat(returnn[1]); 
      

    } else{
      alert("Houve um problema ao obter os dados:n" + req.statusText);
    }
  }
}