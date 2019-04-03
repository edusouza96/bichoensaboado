function deliveryChecked(search, idField) {
    var fieldAddress = document.getElementById('address' + idField);
    var fieldDistrict = document.getElementById('district' + idField);
    var fieldDeliveryPrice = document.getElementById('deliveryPrice' + idField);
    if (search.checked) {
        var fieldAddressHidden = document.getElementById('hiddenAddress' + idField).value;
        var fieldDistrictHidden = document.getElementById('hiddenDistrict' + idField).value;
        var fieldDeliveryPriceHidden = document.getElementById('hiddenDeliveryPrice' + idField).value;
        fieldAddress.innerHTML = fieldAddressHidden;
        fieldDistrict.innerHTML = fieldDistrictHidden;
        fieldDeliveryPrice.innerHTML = fieldDeliveryPriceHidden;
    } else {
        fieldAddress.innerHTML = '<input type="hidden" id="hiddenAddress' + idField + '" value="' + fieldAddress.innerHTML + '" >';
        fieldDistrict.innerHTML = '<input type="hidden" id="hiddenDistrict' + idField + '" value="' + fieldDistrict.innerHTML + '" >';
        fieldDeliveryPrice.innerHTML = '<input type="hidden" id="hiddenDeliveryPrice' + idField + '" value="' + fieldDeliveryPrice.innerHTML + '" >';
    }

    var price = isNaN(parseFloat($("#price" + idField).html())) ? 0 : parseFloat($("#price" + idField).html());
    var priceVet = isNaN(parseFloat($("#priceVet" + idField).html())) ? 0 : parseFloat($("#priceVet" + idField).html());
    var deliveryPrice = isNaN(parseFloat($("#deliveryPrice" + idField).html())) ? 0 : parseFloat($("#deliveryPrice" + idField).html());

    $("#totalPrice" + idField).html(price + priceVet + deliveryPrice);

}

function finish(idDiary, status) {
    if (status == -1) {
        var password = document.getElementById('password').value;
        var idDiary = document.getElementById('idCanc').value;

        if (password == '4518' || password == 'admin1996') {
            var url = "ajax/finish.php?idDiary=" + idDiary + "&status=" + status;
            ajaxFinish(url);
        } else {
            alert('Senha Incorreta!');
        }
    } else {
        var url = "ajax/finish.php?idDiary=" + idDiary + "&status=" + status;
        ajaxFinish(url);
    }
}

function payAnticipate(idDiary) {
    location.assign("sales/CashDesk.php?diary=" + idDiary);
}

function save(idField, date) {
    var service = document.getElementById('serviceSelect' + idField).value;
    var serviceVet = document.getElementById('serviceVetSelect' + idField).value;
    var owner = document.getElementById('owner' + idField).value;

    if (service + serviceVet == 0) {
        alert("Selecione um Serviço");
    } else if (owner == 0) {
        alert("Selecione um Proprietario");
    } else {
        var search = document.getElementById('search' + idField).checked;
        if (search == true) {
            search = 1;
        } else {
            search = 0;
        }
        var price = isEmpty($('#price' + idField).html()) ? 0 : $('#price' + idField).html();
        var priceVet = isEmpty($('#priceVet' + idField).html()) ? 0 : $('#priceVet' + idField).html();
        var deliveryPrice = isEmpty($('#deliveryPrice' + idField).html()) ? 0 : $('#deliveryPrice' + idField).html();
        if (isNaN(deliveryPrice)) {
            deliveryPrice = 0;
        }
        var dateHourPackage = ($('#dateHourPackage').val() == "" ? "" : JSON.parse($('#dateHourPackage').val()));
        var totalPrice = parseFloat(priceVet) + parseFloat(price) + parseFloat(deliveryPrice);
        var hour = document.getElementById('hour' + idField).innerHTML;
        var dateHour = date + ' ' + hour;

        $.get("ajax/save.php", {
            idField: idField,
            owner: owner,
            search: search,
            service: service,
            price: price,
            serviceVet: serviceVet,
            priceVet: priceVet,
            deliveryPrice: deliveryPrice,
            totalPrice: totalPrice,
            dateHour: dateHour,
            dateHourPackage: dateHourPackage
        }).done(function() {
            showMessage('Horario Marcado!');
            location.reload();
        }).fail(function(error) {
            console.log(error.responseText);
            showMessage('Falha no agendamento, tente novamente');
        });
    }
}

function selectOwner(nameAnimal, idField) {
    var url = "ajax/completeSelectOwner.php?nameAnimal=" + nameAnimal + "&idField=" + idField;
    ajaxSelectOwner(url);
}

function selectValuation(idService, idField, type) {
    $.get("ajax/completeValuation.php", {
        idService: idService,
        idField: idField
    }).done(function(data) {

        data = JSON.parse(data);

        var price = $("#price" + data.idField);
        var priceVet = $("#priceVet" + data.idField);

        var deliveryPrice = $("#deliveryPrice" + data.idField);
        var totalPrice = $("#totalPrice" + data.idField);

        if (type == 'P') {
            price.html(data.valuation);

            valueOtherService = isNaN(parseFloat(priceVet.html())) ? 0 : parseFloat(priceVet.html());

            if (deliveryPrice.html().indexOf("hidden") == -1) {

                if (isNaN(parseFloat(deliveryPrice.html()))) {
                    totalPrice.html(valueOtherService + parseFloat(data.valuation));
                } else {
                    totalPrice.html(valueOtherService + parseFloat(deliveryPrice.html()) + parseFloat(data.valuation));
                }
            } else {
                totalPrice.html(valueOtherService + parseFloat(data.valuation));

            }
        } else {
            priceVet.html(data.valuation);

            valueOtherService = isNaN(parseFloat(price.html())) ? 0 : parseFloat(price.html());

            if (deliveryPrice.html().indexOf("hidden") == -1) {

                if (isNaN(parseFloat(deliveryPrice.html()))) {
                    totalPrice.html(valueOtherService + parseFloat(data.valuation));
                } else {
                    totalPrice.html(valueOtherService + parseFloat(deliveryPrice.html()) + parseFloat(data.valuation));
                }
            } else {
                totalPrice.html(valueOtherService + parseFloat(data.valuation));

            }
        }

        //  checar se é um serviço de pacote 
        var package = data.package;
        if (package > 0) {
            showFormSelectDaysPackage(package);
        }

    }).fail(function(err) {
        alert("Houve um problema ao obter os dados");
        console.log(err);
    });
}

function completeField(idClient, idField) {
    $.get("ajax/completeFull.php", {
        idClient: idClient,
        idField: idField
    }).done(function(data) {
        data = JSON.parse(data);

        $("#breed" + data.idField).html(data.breed);
        addressValue = data.addressNumber + '\n' + data.addressComplement;
        $("#address" + data.idField).html('<input type="hidden" id="hiddenAddress' + data.idField + '" value="' + addressValue + '" >');
        $("#district" + data.idField).html('<input type="hidden" id="hiddenDistrict' + data.idField + '" value="' + data.district + '" >');
        $("#phone1" + data.idField).html(data.phone1);
        $("#service" + data.idField).html(data.service);
        $("#deliveryPrice" + data.idField).html('<input type="hidden" id="hiddenDeliveryPrice' + data.idField + '" value="' + data.deliveryPrice + '" >');

        var option = '<option value>-- Selecione --</option>';
        for (var servic in data.servicPet) {
            option += '<option value=' + servic + '>' + data.servicPet[servic] + '</option>';
        }
        $("#service" + data.idField).html('<select id="serviceSelect' + data.idField + '" name="service" onChange="selectValuation(this.value,' + data.idField + ', &quot;P&quot;);" class="form-control">' + option + '</select>');

        option = '<option value>-- Selecione --</option>';
        for (var servic in data.servicVet) {
            option += '<option value=' + servic + '>' + data.servicVet[servic] + '</option>';
        }
        $("#serviceVet" + data.idField).html('<select id="serviceVetSelect' + data.idField + '" name="serviceVet" onChange="selectValuation(this.value,' + data.idField + ', &quot;V&quot;);" class="form-control">' + option + '</select>');

    }).fail(function(err) {
        alert("Houve um problema ao obter os dados");
        console.log(err);
    });
}

function addRow(hour, date) {
    setTimeout(function() {
        var pRow = window.sessionStorage.getItem('pRow');
        var table = document.getElementById('tableDiary');
        var row = table.insertRow(pRow);
        var id = (table.rows.length);
        var colCount = table.rows[0].cells.length;
        row.setAttribute("onClick", "positionRow(this);");
        for (var i = 0; i < colCount; i++) {
            var newcell = row.insertCell(i);

            if (i == 0) {
                newcell.innerHTML = hour;
                newcell.setAttribute('onClick', "addRow('" + hour + "');");
                newcell.setAttribute('id', 'hour' + id);
            } else if (i == 1) {
                newcell.innerHTML = "<input type='text' id='nameAnimal" + id + "' name='nameAnimal' onKeyPress='completeNameAnimal();' onBlur='selectOwner(this.value," + id + ");' class='form-control nameAnimal ui-autocomplete-input' autocomplete='off'>";
            } else if (i == 2) {
                newcell.setAttribute('id', 'breed' + id);
            } else if (i == 3) {
                newcell.setAttribute('id', 'ownerTD' + id);
                // newcell.innerHTML = "<select id='owner"+id+"' name='owner'  onChange='completeField(this.value,"+id+");' class='form-control'><option value='0'>-- Selecione --</option>";
            } else if (i == 4) {
                newcell.innerHTML = "<input type='checkbox' id='search" + id + "' onClick='deliveryChecked(this, " + id + ");' name='search' value='1' class='form-control'>";
            } else if (i == 5) {
                newcell.setAttribute('id', 'address' + id);
            } else if (i == 6) {
                newcell.setAttribute('id', 'district' + id);
            } else if (i == 7) {
                newcell.setAttribute('id', 'phone1' + id);
            } else if (i == 8) {
                newcell.setAttribute('id', 'service' + id);
            } else if (i == 9) {
                newcell.setAttribute('id', 'price' + id);
                // newcell.innerHTML = "<input type='text' id='price"+id+"' name='price' class='form-control'>";
            } else if (i == 10) {
                newcell.setAttribute('id', 'serviceVet' + id);
            } else if (i == 11) {
                newcell.setAttribute('id', 'priceVet' + id);
            } else if (i == 12) {
                newcell.setAttribute('id', 'observation' + id);
            } else if (i == 13) {
                newcell.setAttribute('id', 'deliveryPrice' + id);
            } else if (i == 14) {
                newcell.setAttribute('id', 'totalPrice' + id);
            } else if (i == 15) {
                newcell.innerHTML = "<input type='button' id='save" + id + "' onClick='save(" + id + ",&quot;" + date + "&quot;)' value='Agendar'/>";
            }

        }
    }, 500)
}

function positionRow(pRow) {
    window.sessionStorage.setItem('pRow', (pRow.rowIndex += 1));
}

function modalEdit(paramId, paramDate, paramHour) {
    document.getElementById('idEdit').value = paramId;
    document.getElementById('dateEdit').value = paramDate;
    document.getElementById('hourEdit').value = paramHour;
}

function activeFiedsForUpdate() {
    var idField = document.getElementById('idEdit').value;
    var date = document.getElementById('dateEdit').value;
    var hour = document.getElementById('hourEdit').value;
    var password = document.getElementById('password1').value;
    if (password == 3098 || password == 'admin1996') {
        var search = document.getElementById('search_' + idField);
        if (search.disabled) {
            search.disabled = false;
        } else {
            search.disabled = true;
        }
        search.setAttribute('onClick', "deliveryCheckedUpdate(this, " + idField + ");");
        document.getElementById('status' + idField).innerHTML = "<input type='button' value='Salvar' onClick='updateDiary(" + idField + ")'/>";
        document.getElementById('hour_' + idField).innerHTML = "<input type='date' id='date_" + idField + "' value=" + date + "><input type='time' id='time_" + idField + "' value=" + hour + ">";
        document.getElementById('hour_' + idField).removeAttribute('onClick');
        document.getElementById('servicWithFieldEdit' + idField).style.display = 'block';
        document.getElementById('servicVetWithFieldEdit' + idField).style.display = 'block';
        document.getElementById('servicWithoutFieldEdit' + idField).style.display = 'none';
        document.getElementById('servicVetWithoutFieldEdit' + idField).style.display = 'none';
    }

}

function updateDiary(idField) {
    var msgError = '';
    var date = document.getElementById('date_' + idField).value;
    var time = document.getElementById('time_' + idField).value;
    if (date == '') {
        msgError += "Preencha a Data\n";
    }
    if (time == '') {
        msgError += "Preencha o Horario\n";
    }
    if (time < '08:00' || time > '17:30') {
        msgError += "Fora do Horario de expediente\n";
    }
    var dateHour = date + ' ' + time;
    var search = document.getElementById('search_' + idField).checked;
    var delivery = document.getElementById('tdDeliveryPrice_' + idField).innerHTML;
    var servic = document.getElementById('serviceSelect' + idField).value;
    var servicVet = document.getElementById('serviceVetSelect' + idField).value;
    // verificar se tem mais de um select
    delivery = parseFloat(delivery);
    if (search == true) {
        search = 1;
    } else {
        search = 0;
    }
    if (isNaN(delivery)) {
        delivery = 0;
    }
    /**
     * TODO: VERIFICAR A PARTIR DAQUI COMO SALVAR
     */
    if (msgError == '') {
        var idServicEdit = document.getElementById('servicWithFieldEdit' + idField);
        var selectServicEdit = idServicEdit.querySelectorAll('select');

        var idServicVetEdit = document.getElementById('servicVetWithFieldEdit' + idField);
        var selectServicVetEdit = idServicVetEdit.querySelectorAll('select');

        if (selectServicEdit.length > 1) {
            var services = [];
            var servicesVet = [];
            var idFilds = [];
            for (i = 0; i < selectServicEdit.length; i++) {
                services.push(selectServicEdit[i].value);
                servicesVet.push(selectServicVetEdit[i].value);
                idFilds.push(selectServicEdit[i].id);
            }

            $.get("ajax/update.php", {
                idField: idFilds.join('|').replace(/serviceSelect/g, ''),
                dateHour: dateHour,
                search: search,
                deliveryPrice: delivery,
                servic: services.join('|'),
                servicVet: servicesVet.join('|')
            }).done(function() {
                showMessage('Registro Atualizado!');
                location.reload();

            });
        } else {
            $.get("ajax/update.php", {
                idField: idField,
                dateHour: dateHour,
                search: search,
                deliveryPrice: delivery,
                servic: servic,
                servicVet: servicVet
            }).done(function() {
                showMessage('Registro Atualizado!');
                location.reload();

            });
        }

    } else {
        showMessage('Falha ao Atualizar Registro, Tente Novamente');
    }
}

function deliveryCheckedUpdate(search, idField) {
    var fieldAddress = document.getElementById('tdAddress_' + idField);
    var fieldDistrict = document.getElementById('tdDistrict_' + idField);
    var fieldDeliveryPrice = document.getElementById('tdDeliveryPrice_' + idField);
    if (search.checked) {
        var fieldAddressHidden = document.getElementById('address_' + idField).value;
        var fieldDistrictHidden = document.getElementById('district_' + idField).value;
        var fieldDeliveryPriceHidden = document.getElementById('deliveryPrice_' + idField).value;
        fieldAddress.innerHTML = fieldAddressHidden;
        fieldDistrict.innerHTML = fieldDistrictHidden;
        fieldDeliveryPrice.innerHTML = fieldDeliveryPriceHidden;
    } else {
        fieldAddress.innerHTML = '<input type="hidden" id="address_' + idField + '" value="' + fieldAddress.innerHTML + '" >';
        fieldDistrict.innerHTML = '<input type="hidden" id="district_' + idField + '" value="' + fieldDistrict.innerHTML + '" >';
        fieldDeliveryPrice.innerHTML = '<input type="hidden" id="deliveryPrice_' + idField + '" value="' + fieldDeliveryPrice.innerHTML + '" >';
    }

}

function update() {
    var id = document.getElementById('idEdit').value;
    var date = document.getElementById('dateEdit').value;
    var hour = document.getElementById('hourEdit').value;
    var dateHour = date + ' ' + hour;
    var url = "ajax/update.php?idField=" + id + "&dateHour=" + dateHour;
    ajaxUpdate(url);
}

function canc(idField) {
    document.getElementById('idCanc').value = idField;
}

function dataToModal(idField, hour, date) {
    document.getElementById('idEdit').value = idField;
    document.getElementById('dateEdit').value = date;
    document.getElementById('hourEdit').value = hour;
}

function addAnimalSameOwner(idOwner, idDiary) {
    document.getElementById('idDiary-add').value = idDiary;

    $.get("ajax/animalSameOwner.php", {
        id: idOwner,
        field: "name"
    }).done(function(data) {
        data = JSON.parse(data);

        var select = document.createElement("select");
        select.className = 'form-control';
        select.name = 'nameAnimal';
        if (document.getElementById('idClient-idBreed') != null) {
            var sel = document.getElementById('idClient-idBreed');
            sel.parentNode.removeChild(sel);
        }
        select.id = 'idClient-idBreed';
        select.addEventListener('change', function() { listServic(this.value) });
        var option = document.createElement("option");
        option.value = 0;
        option.label = 'Selecione';
        select.appendChild(option);

        for (var i in data.animals) {
            var option = document.createElement("option");
            option.value = i;
            option.label = data.animals[i];
            select.appendChild(option);
        }
        document.getElementById('inputName').appendChild(select);
    }).fail(function(error) {
        console.log(error.responseText);
        showMessage('Houve um problema ao obter os dados');
    });
}

function listServic(idBreed) {
    id = idBreed.split('#');

    $.get("ajax/animalSameOwner.php", {
        id: id[1],
        field: "servic"
    }).done(function(data) {
        data = JSON.parse(data);

        var inpServic = document.getElementById('servicAdd');

        if (!inpServic.disabled) {
            for (i = 0; i < inpServic.length; i++) {
                inpServic.removeChild(inpServic[0]);
            }
        }
        inpServic.disabled = false;

        var option = document.createElement("option");
        option.value = 0;
        option.label = '-- Selecione --';
        inpServic.appendChild(option);
        for (var i in data.servicesPet) {
            var option = document.createElement("option");
            option.value = i;
            option.label = data.servicesPet[i].name;
            option.dataset.package = data.servicesPet[i].package;
            inpServic.appendChild(option);
        }


        var inpServicVet = document.getElementById('servicVetAdd');

        if (!inpServicVet.disabled) {
            for (i = 0; i < inpServicVet.length; i++) {
                inpServicVet.removeChild(inpServicVet[0]);
            }
        }
        inpServicVet.disabled = false;

        var option = document.createElement("option");
        option.value = 0;
        option.label = '-- Selecione --';
        inpServicVet.appendChild(option);
        for (var i in data.servicesVet) {
            var option = document.createElement("option");
            option.value = i;
            option.label = data.servicesVet[i];
            inpServicVet.appendChild(option);
        }
    }).fail(function(error) {
        console.log(error.responseText);
        showMessage('Houve um problema ao obter os dados');
    });
}

function saveAnimalSameOwner() {
    defineDateHourPackage();
    dateHourPackage = ($('#dateHourPackage').val() == "" ? "" : JSON.parse($('#dateHourPackage').val()));
    idDiary = document.getElementById('idDiary-add').value;
    idServic = document.getElementById('servicAdd').value;
    idServicVet = document.getElementById('servicVetAdd').value;
    id = document.getElementById('idClient-idBreed').value;
    id = id.split('#');
    idClient = id[0];
    idBreed = id[1];

    $.get("ajax/animalSameOwner.php", {
        id: idDiary,
        idServic: idServic,
        idServicVet: idServicVet,
        idClient: idClient,
        idBreed: idBreed,
        field: "save",
        dateHourPackage: dateHourPackage
    }).done(function(data) {
        location.reload();
    }).fail(function(error) {
        console.log(error.responseText);
        showMessage('Houve um problema ao obter os dados');
    });
}

function showMessage(message) {
    document.getElementById('alert').style.display = 'block';
    document.getElementById('msg-alert').innerHTML = message;
    document.getElementById('link-treasurer').style.display = 'none';
}

function showFormSelectDaysPackage(package) {
    var buildDiv = '';
    var dateCurrent = $('#dateCurrent').val();
    var pRow = window.sessionStorage.getItem('pRow');
    var table = document.getElementById('tableDiary');
    var hourCurrent = table.rows[pRow - 1].cells[0].innerText.trim();

    var dateSplit = dateCurrent.split('-');
    dateCurrent = new Date(dateSplit[0], dateSplit[1] - 1, dateSplit[2]);

    for (var i = 0; i < (package * 2); i++) {

        buildDiv += `
            <div class="row">
                <div class="col-xs-1 col-sm-1 col-lg-1 col-md-1">
                    <div class="form-group"> 
                        <label id="modalRowPackageOrder` + i + `">` + (i + 1) + `</label>
                    </div>
                </div>

                <div class="col-xs-6 col-sm-6 col-lg-6 col-md-6">
                    <div class="form-group"> 
                        <input type="date" name="datePackage[]" id="datePackage` + i + `" value="` + dateCurrent.toISOString().split('T')[0] + `" class="form-control">
                    </div>
                </div>

                <div class="col-xs-5 col-sm-5 col-lg-5 col-md-5">
                    <div class="form-group"> 
                        <input type="time" name="hourPackage[]" id="hourPackage` + i + `" value="` + hourCurrent + `" class="form-control">
                    </div>
                </div>
            </div>
        `;

        dateCurrent.setDate(dateCurrent.getDate() + (14 / package));
        dateCurrent = new Date(dateCurrent.getFullYear(), dateCurrent.getMonth(), dateCurrent.getDate());
    }

    $('#modalRowsSelectDays').html(buildDiv);

    $('#modalSelectDaysPackage').modal('toggle');
}

function defineDateHourPackage() {
    var datesPackage = document.getElementsByName('datePackage[]');
    var hoursPackage = document.getElementsByName('hourPackage[]');

    var formatedReturn = new Array();
    for (var i = 0; i < hoursPackage.length; i++) {
        formatedReturn.push({
            'date': datesPackage[i].value,
            'hour': hoursPackage[i].value
        });
    }

    $('#dateHourPackage').val(JSON.stringify(formatedReturn));
}

function isEmpty(str) {
    return (str == "" || str == null);
}

function showFormSelectDaysPackageAnimalSameOwner() {
    var package = $('#servicAdd :selected').data('package');
    var buildDiv = '';
    var dateCurrent = $('#dateCurrent').val();
    var pRow = window.sessionStorage.getItem('pRow');
    var table = document.getElementById('tableDiary');
    var hourCurrent = table.rows[pRow - 1].cells[0].innerText.trim();

    var dateSplit = dateCurrent.split('-');
    dateCurrent = new Date(dateSplit[0], dateSplit[1] - 1, dateSplit[2]);

    for (var i = 0; i < (package * 2); i++) {

        buildDiv += `
            <div class="row">
                <div class="col-xs-1 col-sm-1 col-lg-1 col-md-1">
                    <div class="form-group"> 
                        <label id="modalRowPackageOrder` + i + `">` + (i + 1) + `</label>
                    </div>
                </div>

                <div class="col-xs-6 col-sm-6 col-lg-6 col-md-6">
                    <div class="form-group"> 
                        <input type="date" name="datePackage[]" id="datePackage` + i + `" value="` + dateCurrent.toISOString().split('T')[0] + `" class="form-control">
                    </div>
                </div>

                <div class="col-xs-5 col-sm-5 col-lg-5 col-md-5">
                    <div class="form-group"> 
                        <input type="time" name="hourPackage[]" id="hourPackage` + i + `" value="` + hourCurrent + `" class="form-control">
                    </div>
                </div>
            </div>
        `;

        dateCurrent.setDate(dateCurrent.getDate() + (14 / package));
        dateCurrent = new Date(dateCurrent.getFullYear(), dateCurrent.getMonth(), dateCurrent.getDate());
    }

    $('#modalRowsSelectDaysAnimalSameOwner').html(buildDiv);

}

function modalSetDiary(id, observation)
{
    $('#observationDiaryId').val(id);
    $('#observation').val(observation);
}

function saveObservation()
{
    var id = $('#observationDiaryId').val();
    var observation = $('#observation').val();

    $.post("ajax/saveObservation.php", {
        id: id,
        observation: observation
    }).done(function() {
        showMessage('Atualizado!');
        location.reload();
    }).fail(function(error) {
        console.log(error.responseText);
        showMessage('Falha no agendamento, tente novamente');
    });
        

}