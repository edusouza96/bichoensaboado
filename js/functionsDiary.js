    function deliveryChecked(search, idField){
        var fieldAddress = document.getElementById('address'+idField);
        var fieldDistrict = document.getElementById('district'+idField);
        var fieldDeliveryPrice = document.getElementById('deliveryPrice'+idField);
        if(search.checked){
            var fieldAddressHidden = document.getElementById('hiddenAddress'+idField).value;
            var fieldDistrictHidden = document.getElementById('hiddenDistrict'+idField).value;
            var fieldDeliveryPriceHidden = document.getElementById('hiddenDeliveryPrice'+idField).value;
            fieldAddress.innerHTML = fieldAddressHidden;
            fieldDistrict.innerHTML = fieldDistrictHidden;
            fieldDeliveryPrice.innerHTML = fieldDeliveryPriceHidden;
        }else{
            fieldAddress.innerHTML = '<input type="hidden" id="hiddenAddress'+idField+'" value="'+fieldAddress.innerHTML+'" >';
            fieldDistrict.innerHTML = '<input type="hidden" id="hiddenDistrict'+idField+'" value="'+fieldDistrict.innerHTML+'" >';
            fieldDeliveryPrice.innerHTML = '<input type="hidden" id="hiddenDeliveryPrice'+idField+'" value="'+fieldDeliveryPrice.innerHTML+'" >';
        }

    }

    function finish(idDiary,status){
        if(status == -1){
            if(prompt("Senha") == '4518'){
                var url = "ajax/finish.php?idDiary=" + idDiary + "&status=" + status; 
                ajaxFinish(url);
            }
        }else{
            var url = "ajax/finish.php?idDiary=" + idDiary + "&status=" + status; 
            ajaxFinish(url);
        }
    }

    function save(idField, date){
        var service = document.getElementById('serviceSelect'+idField).value;            
        var owner = document.getElementById('owner'+idField).value;

        if(service == 0){
            alert("Selecione um Serviço");
        }else if(owner == 0){
            alert("Selecione um Proprietario");
        }else{
            var search = document.getElementById('search'+idField).checked;
            if(search == true){
                search = 1;
            }else{
                search = 0;
            }
            var price = document.getElementById('price'+idField).innerHTML;
            var deliveryPrice = document.getElementById('deliveryPrice'+idField).innerHTML;
            if(isNaN(deliveryPrice)){
                deliveryPrice = 0;
            }
            var totalPrice = parseFloat(price) + parseFloat(deliveryPrice);
            var hour = document.getElementById('hour'+idField).innerHTML;
            var dateHour = date+' '+hour;
            var paramSave = owner + '|' + service + '|' + search + '|' + price + '|' + deliveryPrice + '|' + totalPrice + '|' + dateHour;
            var url = "ajax/save.php?paramSave=" + paramSave + "&idField=" + idField; 
            // console.log(url);
            ajaxSave(url);
        }
    }

    function selectOwner(nameAnimal, idField){
        var url = "ajax/completeSelectOwner.php?nameAnimal=" + nameAnimal + "&idField=" + idField; 
        ajaxSelectOwner(url);
    }

    function selectValuation(idService,idField){
        var url = "ajax/completeValuation.php?idService=" + idService + "&idField=" + idField; 
        ajaxValuation(url);
    }

    function completeField(idClient, idField){
        var url = "ajax/completeFull.php?idClient=" + idClient + "&idField=" + idField; 
        ajax(url);
    }

    function addRow(hour, date){
        setTimeout(function () {
            var pRow = window.sessionStorage.getItem('pRow');
            var table=document.getElementById('tableDiary');
            var row=table.insertRow(pRow);
            var id = (table.rows.length);
            var colCount=table.rows[0].cells.length;
            row.setAttribute("onClick", "positionRow(this);");
            for(var i=0;i<colCount;i++){
                var newcell=row.insertCell(i);
                
                if (i == 0) {
                    newcell.innerHTML = hour;
                    newcell.setAttribute('onClick', "addRow('"+hour+"');");
                    newcell.setAttribute('id', 'hour'+id);
                }else if (i == 1){
                    newcell.innerHTML = "<input type='text' id='nameAnimal"+id+"' name='nameAnimal' onKeyPress='completeNameAnimal();' onBlur='selectOwner(this.value,"+id+");' class='form-control nameAnimal ui-autocomplete-input' autocomplete='off'>";
                }else if( i == 2){
                    newcell.setAttribute('id', 'breed'+id);   
                }else if(i == 3){
                    newcell.setAttribute('id', 'ownerTD'+id);
                    // newcell.innerHTML = "<select id='owner"+id+"' name='owner'  onChange='completeField(this.value,"+id+");' class='form-control'><option value='0'>-- Selecione --</option>";
                }else if( i == 4){
                    newcell.innerHTML = "<input type='checkbox' id='search"+id+"' onClick='deliveryChecked(this, "+id+");' name='search' value='1' class='form-control'>";
                }else if( i == 5){
                    newcell.setAttribute('id', 'address'+id);   
                }else if( i == 6){
                    newcell.setAttribute('id', 'district'+id);   
                }else if( i == 7){
                    newcell.setAttribute('id', 'phone1'+id);   
                }else if( i == 8){
                    newcell.setAttribute('id', 'phone2'+id);   
                }else if( i == 9){
                    newcell.setAttribute('id', 'service'+id);   
                }else if( i == 10){
                    newcell.setAttribute('id', 'price'+id);
                    // newcell.innerHTML = "<input type='text' id='price"+id+"' name='price' class='form-control'>";
                }else if( i == 11){
                    newcell.setAttribute('id', 'deliveryPrice'+id);
                    // newcell.innerHTML = "<input type='text' id='deliveryPrice"+id+"' name='deliveryPrice' class='form-control'>";
                }else if( i == 12){
                    newcell.setAttribute('id', 'totalPrice'+id);   
                }else if( i == 13){
                    newcell.innerHTML = "<input type='button' id='save"+id+"' onClick='save("+id+",&quot;"+date+"&quot;)' value='Agendar'/>";
                }

            }
        }, 500)
    }

    function positionRow(pRow) {
        window.sessionStorage.setItem('pRow', (pRow.rowIndex+=1));
    }

    function teste(paramId, paramDate, paramHour){
        document.getElementById('idEdit').value = paramId;
        document.getElementById('dateEdit').value = paramDate;
        document.getElementById('hourEdit').value = paramHour;
    }

    function update(){
        var id = document.getElementById('idEdit').value;
        var date = document.getElementById('dateEdit').value;
        var hour = document.getElementById('hourEdit').value;
        var dateHour = date+' '+hour;
        var url = "ajax/update.php?idField=" + id + "&dateHour=" + dateHour; 
        ajaxUpdate(url);
    }