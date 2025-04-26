<!-- Modal -->
<div class="modal fade" id="modalFormPedido" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header headerUpdate">
                <h5 class="modal-title" id="titleModal">Actualizar pedido</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formUpdatePedido" name="formUpdatePedido">
                    <input type="hidden" name="idPedido" id="idPedido" value="" required>
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td width="210px">N° Pedido: </td>
                                <td>12</td>
                            </tr>
                            <tr>
                                <td>Cliente: </td>
                                <td>Miher</td>
                            </tr>
                            <tr>
                                <td>Importe total: </td>
                                <td>$ 3234324</td>
                            </tr>
                            <tr>
                                <td>Transaccion: </td>
                                <td><input type="text" name="txtTransaccion" id="txtTransaccion" class="form-control" value="" required></td>
                            </tr>
                            <tr>
                                <td>Tipo pago:</td>
                                <td>
                                    <select name="listTipoago" id="listTipoago" class="form-control selectpicker" data-live-search="true" required>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Estado: </td>
                                <td> 
                                    <select name="listEstado" id="listEstado" class="form-control selectpicker" required>
                                    </select>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="tile-footer">
                        <button id="btnActionForm" class="btn btn-info" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span>Actulizar</span> </button>&nbsp;&nbsp;&nbsp;
                        <button class="btn btn-danger" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>