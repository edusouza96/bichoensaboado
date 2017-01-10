function deleteRegister(id,module){
    var url = "../ajax/deleteRegister.php?id=" + id + "&module=" + module; 
    ajaxDeleteRegister(url);
}