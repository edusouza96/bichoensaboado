function deleteRegister(id,module){
    var url = "../ajax/deleteRegister.php?id=" + id + "&module=" + module; 
    ajaxDeleteRegister(url);
}

function showFinancial(tableVisible,tableInvisible){
    document.getElementById(tableVisible).style.display = '';
    document.getElementById(tableInvisible).style.display = 'none';
}