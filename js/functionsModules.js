function deleteRegister(id,module){
    var url = "../ajax/deleteRegister.php?id=" + id + "&module=" + module; 
    ajaxDeleteRegister(url);
}

function showFinancial(tableVisible,tableInvisible){
    document.getElementById(tableVisible).style.display = '';
    document.getElementById(tableInvisible).style.display = 'none';
}

function valueProductExpected(option){
    $('#optionActionProduct').val(option);
    $('form').submit();
}

function alertValuationExpected(){
    var id = $('#idProduct').val();
    if(id < 1){
        var url = "../ajax/dialog.php?barcodeProduct=" + $('#barcodeProduct').val() + "&valuationProduct=" + $('#valuationProduct').val()+"&quantityProduct=" + $('#quantityProduct').val(); 
        ajaxAlertValuationExpected(url);
    }else{
        $('form').submit();
    }
}

function reportShowFilters(){
    $("#filters").removeClass('hidden');
    $("#showFilters").addClass('hidden');
}

function showChart(){
    if( $('#reportChart').hasClass('hidden') ){
        $("#reportChart").removeClass('hidden');
    }else{
        $("#reportChart").addClass('hidden');
    }
}

function exportReportToExcel(nameFileExcel){
    var dateStart = $('#dateStart').val();
    var dateEnd = $('#dateEnd').val();
    window.open(nameFileExcel+'.php?dateStart='+dateStart+'&dateEnd='+dateEnd);

}
function redirectReport(file){
    location.assign(file);
}

function moreDetails(idDiv){
    if($(idDiv).hasClass('hidden')){
        $(idDiv).removeClass('hidden');
    }else{
        $(idDiv).addClass('hidden');
    }
    
}

function showMessage(message){
    document.getElementById('alert').style.display = 'block';
    document.getElementById('msg-alert').innerHTML = message;
    document.getElementById('link-treasurer').style.display = 'none';
}

function selectTitleExpense(idCategory, idCenterCost = 0){
    $.get( "../ajax/selectTitleExpense.php", { 
        idCategory: idCategory
    }).done(function( data ) {
        data = JSON.parse(data);
        var html = '';        
        var optionSelected = '';
        for(var obj in data){
            optionSelected = (data[obj].idCenterCost == idCenterCost ? 'selected' : '');
            html = html.concat('<option value="'+ data[obj].idCenterCost +'" '+optionSelected+'>'+ data[obj].nameCenterCost +'</option>');
        }
        $('#centerCost').html(html);
    
    });
}

function addRowFinancial(){
    var divNew = `
        <div class="row"> 
            <div class="col-xs-12 col-sm-12 col-lg-3 col-md-3"> 
                <div class="form-group"> 
                    <label for="valueProduct">Custo do gasto</label> 
                    <input type="text" id="valueProduct" name="valueProduct[]" class="form-control" >
                </div>
            </div> 

            <div class="col-xs-10 col-sm-10 col-lg-3 col-md-3"> 
                <div class="form-group"> 
                    <label for="typeTreasurerFinancial">Retirar de:</label> 
                    <select id="typeTreasurerFinancial" name="typeTreasurerFinancial[]" class="form-control">
                            <option value="">-- Selecione --</option>
                            <option value="1">Caixa(gaveta)</option>
                            <option value="2">Cofre</option>
                            <option value="4">Banco</option>
                    </select>
                </div>
            </div>
        </div>
    `;
    var divRow = $('#rowMulti').html();
    $('#rowMulti').html(divRow+divNew);
}