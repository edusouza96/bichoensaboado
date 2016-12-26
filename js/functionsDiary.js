    function finish(idDiary){
        var url = "ajax/finish.php?idDiary=" + idDiary; 
        ajaxFinish(url);
    }

    function save(idField, date){
        var owner = document.getElementById('owner'+idField).value;
        var service = document.getElementById('serviceSelect'+idField).value;
        var search = document.getElementById('search'+idField).checked;
        if(search == true){
            search = 1;
        }else{
            search = 0;
        }
        var price = document.getElementById('price'+idField).innerHTML;
        var deliveryPrice = document.getElementById('deliveryPrice'+idField).innerHTML;
        var totalPrice = document.getElementById('totalPrice'+idField).innerHTML;
        var hour = document.getElementById('hour'+idField).innerHTML;
        var dateHour = date+' '+hour;
        var paramSave = owner + '|' + service + '|' + search + '|' + price + '|' + deliveryPrice + '|' + totalPrice + '|' + dateHour;
        var url = "ajax/save.php?paramSave=" + paramSave + "&idField=" + idField; 
        // console.log(url);
        ajaxSave(url);
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
                    newcell.innerHTML = "<input type='checkbox' id='search"+id+"' name='search' value='1' class='form-control'>";
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
