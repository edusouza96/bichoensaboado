<div class="modal fade" id="modal-alert" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content" style="width: 100%;">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">ATENÇÃO - Produto em estoque</h4>
            </div>
            <div class="modal-body">
                <div class="row"> 
                    <div class="col-xs-12 col-sm-12 col-lg-12 col-md-12"> 
                        <div class="form-group"> 
                            <p id="alertValuationExpected"></p>
                            <input type="hidden" id="optionActionProduct" name="optionActionProduct">
                        </div>
                    </div> 
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>                        
                <button type="button" class="btn btn-info" data-dismiss="modal" onClick="valueProductExpected(1);" >Manter valor inserido</button>                        
                <button type="button" class="btn btn-success" data-dismiss="modal" onClick="valueProductExpected(2);" >Manter valor sugerido</button>                        
            </div>
        </div>
    </div>
</div>
