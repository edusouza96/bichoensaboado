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
    if (req.status == 200) {
      var returnn = req.responseText.split("||");
      var idField = parseInt(returnn[0]);

      var breed = document.getElementById("breed" + idField);
      var address = document.getElementById("address" + idField);
      var district = document.getElementById("district" + idField);
      var phone1 = document.getElementById("phone1" + idField);
      var phone2 = document.getElementById("phone2" + idField);
      var service = document.getElementById("service" + idField);
      var deliveryPrice = document.getElementById("deliveryPrice" + idField);
      var option = '<option value>-- Selecione --</option>';
      for (var i = 9; i < returnn.length; i++) {
        var optionFormat = returnn[i].split("|");
        option += '<option value=' + optionFormat[0] + '>' + optionFormat[1] + '</option>';
      }
      breed.innerHTML = returnn[1];
      addressValue = returnn[3] + '\n' + returnn[2];
      address.innerHTML = '<input type="hidden" id="hiddenAddress' + idField + '" value="' + addressValue + '" >';
      districtValue = returnn[5];
      district.innerHTML = '<input type="hidden" id="hiddenDistrict' + idField + '" value="' + districtValue + '" >';
      phone1.innerHTML = returnn[6];
      phone2.innerHTML = returnn[7];
      service.innerHTML = '<select id="serviceSelect' + idField + '" name="service" onChange="selectValuation(this.value,' + idField + ');" class="form-control">' + option + '</select>';
      deliveryPriceValue = returnn[8];
      deliveryPrice.innerHTML = '<input type="hidden" id="hiddenDeliveryPrice' + idField + '" value="' + deliveryPriceValue + '" >';
      // deliveryPrice.value = returnn[8];

    } else {
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
    if (req.status == 200) {
      var returnn = req.responseText.split(",");
      var idField = parseInt(returnn[0]);

      var price = document.getElementById("price" + idField);
      var deliveryPrice = document.getElementById("deliveryPrice" + idField);
      var totalPrice = document.getElementById("totalPrice" + idField);
      if (deliveryPrice.innerHTML.indexOf("hidden") == -1) {
        price.innerHTML = returnn[1];
        totalPrice.innerHTML = parseFloat(deliveryPrice.innerHTML) + parseFloat(returnn[1]);
      } else {
        price.innerHTML = returnn[1];
        totalPrice.innerHTML = parseFloat(returnn[1]);
      }

      //  checar se é um serviço de pacote 
      var package = returnn[2];
      if (package > 0) {
        showFormSelectDaysPackage(package);
      }

    } else {
      alert("Houve um problema ao obter os dados:n" + req.statusText);
    }
  }
}


/**
 *Cria select de donos
 */
function ajaxSelectOwner(url) {
  req = null;
  if (window.XMLHttpRequest) {
    req = new XMLHttpRequest();
    req.onreadystatechange = processReqSelectOwner;
    req.open("GET", url, true);
    req.send(null);
  } else if (window.ActiveXObject) {
    req = new ActiveXObject("Microsoft.XMLHTTP");
    if (req) {
      req.onreadystatechange = processReqSelectOwner;
      req.open("GET", url, true);
      req.send(null);
    }
  }
}

function processReqSelectOwner() {
  if (req.readyState == 4) {
    if (req.status == 200) {
      var returnn = req.responseText.split(",");
      var idField = parseInt(returnn[0]);

      var option = '<option value>-- Selecione --</option>';
      for (var i = 1; i < returnn.length; i++) {
        var optionFormat = returnn[i].split("|");
        option += '<option value=' + optionFormat[0] + '>' + optionFormat[1] + '</option>';
      }

      var selectOwner = document.getElementById("ownerTD" + idField);
      selectOwner.innerHTML = '<select id="owner' + idField + '" name="owner" onChange="completeField(this.value,' + idField + ');" class="form-control">' + option + '</select>';

    } else {
      alert("Houve um problema ao obter os dados:n" + req.statusText);
    }
  }
}


/**
 *Salva os dados e modifica a visualização da linha(deprecated)
 */
function ajaxSave(url) {
  req = null;
  if (window.XMLHttpRequest) {
    req = new XMLHttpRequest();
    req.onreadystatechange = processReqSave;
    req.open("GET", url, true);
    req.send(null);
  } else if (window.ActiveXObject) {
    req = new ActiveXObject("Microsoft.XMLHTTP");
    if (req) {
      req.onreadystatechange = processReqSave;
      req.open("GET", url, true);
      req.send(null);
    }
  }
}

function processReqSave() {
  if (req.readyState == 4) {
    if (req.status == 200) {
      if (req.responseText) {
        showMessage('Horario Marcado!');
        location.reload();
      } else {
        showMessage('Falha no agendamento, tente novamente');
      }
    } else {
      alert("Houve um problema ao obter os dados:n" + req.statusText);
    }
  }
}



/**
 *Finaliza serviço
 */
function ajaxFinish(url) {
  req = null;
  if (window.XMLHttpRequest) {
    req = new XMLHttpRequest();
    req.onreadystatechange = processReqFinish;
    req.open("GET", url, true);
    req.send(null);
  } else if (window.ActiveXObject) {
    req = new ActiveXObject("Microsoft.XMLHTTP");
    if (req) {
      req.onreadystatechange = processReqFinish;
      req.open("GET", url, true);
      req.send(null);
    }
  }
}

function processReqFinish() {
  if (req.readyState == 4) {
    if (req.status == 200) {
      var returnn = req.responseText.split("|");
      if (parseInt(returnn[0])) {
        if (parseInt(returnn[2]) == 2) {
          showMessage('Serviço Finalizado!');
          document.getElementById('status' + parseInt(returnn[1])).innerHTML = 'Finalizado';
          document.getElementById('tr' + parseInt(returnn[1])).style.background = "rgba(255,0,0,0.6)";
          if (returnn[3] == 0)
            location.href = "sales/CashDesk.php?diary=" + returnn[1];
        } else if (parseInt(returnn[2]) == 1) {
          showMessage('Check-in feito!');
          document.getElementById('status' + parseInt(returnn[1])).innerHTML = "<input type='button' onClick='finish(" + returnn[1] + ",2);' value='Finalizar'/><input type='button' onClick='dataToModal(" + returnn[1] + ",&quot;" + returnn[3] + "&quot; , &quot;" + returnn[4] + "&quot;);' data-toggle='modal' data-target='#modalEdit' value='Editar'/><input type='button' onClick='canc(" + returnn[1] + ");' data-toggle='modal' data-target='#modalCanc' value='Cancelar'/>";
          document.getElementById('tr' + parseInt(returnn[1])).style.background = "rgba(24,202,39,0.6)";
        } else if (parseInt(returnn[2]) == - 1) {
          showMessage('Serviço Cancelado!');
          location.reload();
          //  document.getElementById('status'+parseInt(returnn[1])).innerHTML = 'Cancelado';
          //  document.getElementById('tr'+parseInt(returnn[1])).style.background = "rgba(255,0,0,0.6)";
        }

      } else {
        showMessage('Falha, tente novamente');
      }
    } else {
      alert("Houve um problema ao obter os dados:n" + req.statusText);
    }
  }
}


/**
 *Deletar Registros
 */
function ajaxDeleteRegister(url) {
  req = null;
  if (window.XMLHttpRequest) {
    req = new XMLHttpRequest();
    req.onreadystatechange = processReqDeleteRegister;
    req.open("GET", url, true);
    req.send(null);
  } else if (window.ActiveXObject) {
    req = new ActiveXObject("Microsoft.XMLHTTP");
    if (req) {
      req.onreadystatechange = processReqDeleteRegister;
      req.open("GET", url, true);
      req.send(null);
    }
  }
}

function processReqDeleteRegister() {
  if (req.readyState == 4) {
    if (req.status == 200) {
      var returnn = req.responseText;
      if (returnn) {
        showMessage('Registro Excluido!');
        setTimeout(function () {
          location.reload();
        }, 2000);
      } else {
        showMessage('Falha ao Excluir Registro, Tente Novamente');
      }
    } else {
      alert("Houve um problema ao obter os dados:n" + req.statusText);
    }
  }
}


/**
 *Atualizar Registros
 */
function ajaxUpdate(url) {
  req = null;
  if (window.XMLHttpRequest) {
    req = new XMLHttpRequest();
    req.onreadystatechange = processReqUpdate;
    req.open("GET", url, true);
    req.send(null);
  } else if (window.ActiveXObject) {
    req = new ActiveXObject("Microsoft.XMLHTTP");
    if (req) {
      req.onreadystatechange = processReqUpdate;
      req.open("GET", url, true);
      req.send(null);
    }
  }
}

function processReqUpdate() {
  console.log(req);

  if (req.readyState == 4) {
    if (req.status == 200) {
      var returnn = req.responseText;
      if (returnn) {
        showMessage('Registro Atualizado!');
        location.reload();
      } else {
        showMessage('Falha ao Atualizar Registro, Tente Novamente');
      }
    } else if (req.status == 410) {
      showMessage("Falha: " + req.responseText);
    } else {
      showMessage("Houve um problema ao obter os dados:" + req.statusText);
    }
  }
}

/**
 *adicionar nome de animais do mesmo dono
 */
function ajaxAnimalSameOwner(url) {
  req = null;
  if (window.XMLHttpRequest) {
    req = new XMLHttpRequest();
    req.onreadystatechange = processReqAnimalSameOwner;
    req.open("GET", url, true);
    req.send(null);
  } else if (window.ActiveXObject) {
    req = new ActiveXObject("Microsoft.XMLHTTP");
    if (req) {
      req.onreadystatechange = processReqAnimalSameOwner;
      req.open("GET", url, true);
      req.send(null);
    }
  }
}

function processReqAnimalSameOwner() {
  if (req.readyState == 4) {
    if (req.status == 200) {
      var returnn = req.responseText.split("||");
      var select = document.createElement("select");
      select.className = 'form-control';
      select.name = 'nameAnimal';
      if (document.getElementById('idClient-idBreed') != null) {
        var sel = document.getElementById('idClient-idBreed');
        sel.parentNode.removeChild(sel);
      }
      select.id = 'idClient-idBreed';
      select.addEventListener('change', function () { listServic(this.value) });
      var option = document.createElement("option");
      option.value = 0;
      option.label = 'Selecione';
      select.appendChild(option);
      for (i = 0; i < returnn.length; i++) {
        var option = document.createElement("option");
        opt = returnn[i].split('|');
        option.value = opt[0];
        option.label = opt[1];
        select.appendChild(option);
      }
      document.getElementById('inputName').appendChild(select);

    } else {
      alert("Houve um problema ao obter os dados:n" + req.statusText);
    }
  }
}

/**
 *adicionar serviço para o animal do mesmo dono
 */
function ajaxAnimalSameOwnerListServic(url) {
  req = null;
  if (window.XMLHttpRequest) {
    req = new XMLHttpRequest();
    req.onreadystatechange = processReqAnimalSameOwnerListServic;
    req.open("GET", url, true);
    req.send(null);
  } else if (window.ActiveXObject) {
    req = new ActiveXObject("Microsoft.XMLHTTP");
    if (req) {
      req.onreadystatechange = processReqAnimalSameOwnerListServic;
      req.open("GET", url, true);
      req.send(null);
    }
  }
}

function processReqAnimalSameOwnerListServic() {
  if (req.readyState == 4) {
    if (req.status == 200) {
      var returnn = req.responseText.split("||");
      if (returnn.length == 1) {
        location.reload();
      } else {
        var inpServic = document.getElementById('servicAdd');

        if (!inpServic.disabled) {
          for (i = 0; i < 5; i++) {
            inpServic.removeChild(inpServic[0]);
          }
        }
        inpServic.disabled = false;
        for (i = 0; i < returnn.length; i++) {
          opt = returnn[i].split('|');
          var option = document.createElement("option");
          option.value = opt[0];
          option.label = opt[1];
          inpServic.appendChild(option);
        }
      }

    } else {
      alert("Houve um problema ao obter os dados:n" + req.statusText);
    }
  }
}

/**
* Alerta de valor para produtos adicionados em estoque
*/
function ajaxAlertValuationExpected(url) {
  req = null;
  if (window.XMLHttpRequest) {
    req = new XMLHttpRequest();
    req.onreadystatechange = processReqAjaxAlertValuationExpected;
    req.open("GET", url, true);
    req.send(null);
  } else if (window.ActiveXObject) {
    req = new ActiveXObject("Microsoft.XMLHTTP");
    if (req) {
      req.onreadystatechange = processReqAjaxAlertValuationExpected;
      req.open("GET", url, true);
      req.send(null);
    }
  }
}

function processReqAjaxAlertValuationExpected() {
  if (req.readyState == 4) {
    if (req.status == 200) {
      var returnn = req.responseText;
      if (returnn != 0) {
        $("#modal-alert").modal();
        $("#alertValuationExpected").html(returnn);
      } else {
        $('form').submit();
      }
    } else {
      alert("Houve um problema ao obter os dados: " + req.statusText);
    }
  }
}


/**
* Abri ou fecha o caixa
*/
function ajaxOpenCloseTreasurer(url) {
  req = null;
  if (window.XMLHttpRequest) {
    req = new XMLHttpRequest();
    req.onreadystatechange = processReqAjaxOpenCloseTreasurer;
    req.open("GET", url, true);
    req.send(null);
  } else if (window.ActiveXObject) {
    req = new ActiveXObject("Microsoft.XMLHTTP");
    if (req) {
      req.onreadystatechange = processReqAjaxOpenCloseTreasurer;
      req.open("GET", url, true);
      req.send(null);
    }
  }
}

function processReqAjaxOpenCloseTreasurer() {
  if (req.readyState == 4) {
    if (req.status == 200) {
      document.getElementById('alert').style.display = 'block';
      document.getElementById('msg-alert').innerHTML = req.responseText;
      document.getElementById('link-treasurer').style.display = 'none';
      if (req.responseText == " Caixa Fechado!") {
        $('#dayMovement').modal('show');
      }
    } else {
      alert("Houve um problema ao obter os dados: " + req.statusText);
    }
  }

}