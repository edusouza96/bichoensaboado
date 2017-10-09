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