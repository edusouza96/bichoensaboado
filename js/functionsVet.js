function vetDeliveryChecked(search, idField){
    var fieldAddress = document.getElementById('address'+idField);
    var fieldDistrict = document.getElementById('district'+idField);
    if(search.checked){
        var fieldAddressHidden = document.getElementById('hiddenAddress'+idField).value;
        var fieldDistrictHidden = document.getElementById('hiddenDistrict'+idField).value;
        fieldAddress.innerHTML = fieldAddressHidden;
        fieldDistrict.innerHTML = fieldDistrictHidden;
    }else{
        fieldAddress.innerHTML = '<input type="hidden" id="hiddenAddress'+idField+'" value="'+fieldAddress.innerHTML+'" >';
        fieldDistrict.innerHTML = '<input type="hidden" id="hiddenDistrict'+idField+'" value="'+fieldDistrict.innerHTML+'" >';
    }

}

function vetFinish(idVet,status){
    if(status == -1){
        var password = document.getElementById('password').value; 
        var idVet = document.getElementById('idCanc').value;            
            if(password == '4518' || password == 'admin1996'){
            var url = "../ajax/vetFinish.php?idVet=" + idVet + "&status=" + status; 
            ajaxFinish(url);
        }else{
            alert('Senha Incorreta!');
        }
    }else{
        var url = "../ajax/vetFinish.php?idVet=" + idVet + "&status=" + status; 
        ajaxFinish(url);
    }
}

function vetPayAnticipate(idVet){
    location.assign("../sales/CashDesk.php?vet="+idVet);
}

function vetSave(idField, date){
    var service = document.getElementById('serviceSelect'+idField).value;            
    var owner = document.getElementById('owner'+idField).value;
    var search = document.getElementById('search'+idField).checked;
    var deliveryPrice = document.getElementById('deliveryPrice'+idField).value;

    if(service == 0){
        alert("Selecione um Serviço");
    }else if(owner == 0){
        alert("Selecione um Proprietario");
    }else if(search == true && (deliveryPrice == "" || deliveryPrice == null || isNaN(deliveryPrice)) ){
        alert("Preecha a taxa de entrega");
    }else{
        // var search = document.getElementById('search'+idField).checked;
        if(search == true){
            search = 1;
        }else{
            search = 0;
        }
        var price = document.getElementById('price'+idField).innerHTML;
        // var deliveryPrice = document.getElementById('deliveryPrice'+idField).innerHTML;
        if(isNaN(deliveryPrice) || deliveryPrice == ""){
            deliveryPrice = 0;
        }
        var totalPrice = parseFloat(price) + parseFloat(deliveryPrice);
        var hour = document.getElementById('hour'+idField).innerHTML;
        var dateHour = date+' '+hour;
        var paramSave = owner + '|' + service + '|' + search + '|' + price + '|' + deliveryPrice + '|' + totalPrice + '|' + dateHour;

        $.get( "../ajax/vetSave.php", { 
            idField: idField, 
            owner: owner,
            service: service, 
            search: search,
            price: price, 
            deliveryPrice: deliveryPrice,
            totalPrice: totalPrice, 
            dateHour: dateHour
        }).done(function() {
            showMessage('Horario Marcado!');
            location.reload();
        }).fail(function() {
            showMessage('Falha no agendamento, tente novamente');
        });
    }
}

function vetSelectOwner(nameAnimal, idField){
    var url = "../ajax/completeSelectOwner.php?nameAnimal=" + nameAnimal + "&idField=" + idField; 
    ajaxSelectOwner(url);
}

function vetCompleteField(idClient, idField){
    var url = "../ajax/completeFull.php?idClient=" + idClient + "&idField=" + idField; 
    ajax(url);
}

function vetAddRow(hour, date){
    setTimeout(function () {
        $.get( "../ajax/vetServices.php", function(option){

            var pRow = window.sessionStorage.getItem('pRow');
            var table=document.getElementById('tableVet');
            var row=table.insertRow(pRow);
            var id = (table.rows.length);
            var colCount=table.rows[0].cells.length;
            row.setAttribute("onClick", "vetPositionRow(this);");

            for(var i=0;i<colCount;i++){
                var newcell=row.insertCell(i);
                
                if (i == 0) {
                    newcell.innerHTML = hour;
                    newcell.setAttribute('onClick', "vetAddRow('"+hour+"');");
                    newcell.setAttribute('id', 'hour'+id);
                }else if (i == 1){
                    newcell.innerHTML = "<input type='text' id='nameAnimal"+id+"' name='nameAnimal' onKeyPress='completeNameAnimal();' onBlur='vetSelectOwner(this.value,"+id+");' class='form-control nameAnimal ui-autocomplete-input' autocomplete='off'>";
                }else if( i == 2){
                    newcell.setAttribute('id', 'breed'+id);   
                }else if(i == 3){
                    newcell.setAttribute('id', 'ownerTD'+id);
                }else if( i == 4){
                    newcell.innerHTML = "<input type='checkbox' id='search"+id+"' onClick='vetDeliveryChecked(this, "+id+");' name='search' value='1' class='form-control'>";
                }else if( i == 5){
                    newcell.setAttribute('id', 'address'+id);   
                }else if( i == 6){
                    newcell.setAttribute('id', 'district'+id);   
                }else if( i == 7){
                    newcell.setAttribute('id', 'phone1'+id);   
                }else if( i == 8){
                    newcell.setAttribute('id', 'phone2'+id);   
                }else if( i == 9){
                    newcell.innerHTML = "<select id='serviceSelect"+id+"' name='service' class='form-control' onChange='vetSelectValuation(this.value,"+id+" );' >"+option+"</select>"; 
                }else if( i == 10){
                    newcell.setAttribute('id', 'price'+id);
                }else if( i == 11){
                    newcell.innerHTML = "<input type='text' id='deliveryPrice"+id+"' onBlur='vetCalcGross(this.value, "+id+");' name='deliveryPrice' class='form-control'>";
                }else if( i == 12){
                    newcell.setAttribute('id', 'totalPrice'+id);   
                }else if( i == 13){
                    newcell.innerHTML = "<input type='button' id='save"+id+"' onClick='vetSave("+id+",&quot;"+date+"&quot;)' value='Agendar'/>";
                }

            }
        });
            
    }, 500)
}

function vetPositionRow(pRow) {
    window.sessionStorage.setItem('pRow', (pRow.rowIndex+=1));
}

function vetActiveFiedsForUpdate(){
    var idField = document.getElementById('idEdit').value;
    var date = document.getElementById('dateEdit').value;
    var hour = document.getElementById('hourEdit').value;
    var password = document.getElementById('password1').value;
    if(password == 3098 || password == 'admin1996'){
        var search = document.getElementById('search_'+idField);
        if(search.disabled){
            search.disabled = false;
        }else{
            search.disabled = true;
        }
        search.setAttribute('onClick', "deliveryCheckedUpdate(this, "+idField+");");
        document.getElementById('status'+idField).innerHTML = "<input type='button' value='Salvar' onClick='updateVet("+idField+")'/>";
        document.getElementById('hour_'+idField).innerHTML = "<input type='date' id='date_"+idField+"' value="+date+"><input type='time' id='time_"+idField+"' value="+hour+">";
        document.getElementById('hour_'+idField).removeAttribute('onClick');
        document.getElementById('servicWithFieldEdit'+idField).style.display = 'block';
        document.getElementById('servicWithoutFieldEdit'+idField).style.display = 'none';
    }
    
}

function vetCanc(idField){
    document.getElementById('idCanc').value = idField;
}

function vetDataToModal(idField, hour, date){
    document.getElementById('idEdit').value = idField;
    document.getElementById('dateEdit').value = date;
    document.getElementById('hourEdit').value = hour;
}

function vetSelectValuation(idService,idField){
    var url = "../ajax/completeValuation.php?idService=" + idService + "&idField=" + idField; 
    ajaxValuation(url);
}

function vetCalcGross(value, idField){
    var price = $('#price'+idField).text();
    if(!isNaN(price))
        $('#totalPrice'+idField).text(parseFloat(value)+parseFloat(price));
}

function updateVet(idField){
    var msgError = '';
    var date = document.getElementById('date_'+idField).value;
    var time = document.getElementById('time_'+idField).value;
    if(date == ''){
        msgError += "Preencha a Data\n";
    }
    if(time == ''){
        msgError += "Preencha o Horario\n";
    }
    if(time < '08:00' || time > '17:30'){
        msgError += "Fora do Horario de expediente\n";
    }
    var dateHour = date+' '+time;
    var search = document.getElementById('search_'+idField).checked;
    var delivery = document.getElementById('tdDeliveryPrice_'+idField).innerHTML;
    var servic= document.getElementById('serviceSelect_'+idField).value;
    
    // verificar se tem mais de um select
    delivery = parseFloat(delivery);
    if(search == true){
        search = 1;
    }else{
        search = 0;
    }
    if(isNaN(delivery)){
        delivery = 0;
    }
    if(msgError == ''){
        var idServicEdit = document.getElementById('servicWithFieldEdit'+idField);
        var selectServicEdit = idServicEdit.querySelectorAll('select');
        if(selectServicEdit.length > 1){
            var services = [];
            var idFilds = [];
            for(i=0; i<selectServicEdit.length; i++){
                services.push(selectServicEdit[i].value);
                idFilds.push(selectServicEdit[i].id);
            }
            var url = "../ajax/vetUpdate.php?idField=" + idFilds.join('|').replace(/serviceSelect/g, '') + "&dateHour=" + dateHour + "&search=" + search + "&deliveryPrice=" + delivery + "&servic=" + services.join('|'); 
        }else{
            var url = "../ajax/vetUpdate.php?idField=" + idField + "&dateHour=" + dateHour + "&search=" + search + "&deliveryPrice=" + delivery + "&servic=" + servic; 
        }
        ajaxUpdate(url);
    }else{
        alert(msgError);            
    }
}