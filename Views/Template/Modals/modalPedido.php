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
                <?php dep($data); ?>
                <form id="formUpdatePedido" name="formUpdatePedido">
                    <input type="hidden" name="idPedido" id="idPedido" value="" required>
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td width="210px">N° Pedido: </td>
                                <td><?= $data['orden']['idpedido'] ?></td>
                            </tr>
                            <tr>
                                <td>Cliente: </td>
                                <td><?= $data['cliente']['nombres'].' '.$data['cliente']['apellidos'] ?></td>
                            </tr>
                            <tr>
                                <td>Importe total: </td>
                                <td><?= SMONEY.' '.$data['orden']['monto'] ?></td>
                            </tr>
                            <tr>
                                <td>Transaccion: </td>                                
                                <td>                                    
                                    <input type="text" name="txtTransaccion" id="txtTransaccion" class="form-control" value="<?= $transaccion = $data['orden']['tipopagoid'] == 1 ? $data['orden']['idtransaccionpaypal'] : ""; ?>" required>
                                </td>
                            </tr>
                            <tr>
                                <td>Tipo pago:</td>                                
                                <td>
                                    <?php 
                                        if ($data['orden']['tipopagoid'] == 1) {
                                            echo $data['orden']['tipopago'];
                                        }else{ 
                                    ?>
                                    <select name="listTipopago" id="listTipopago" class="form-control selectpicker" data-live-search="true" required>
                                        <?php 
                                            for ($i = 0; $i < count($data['tiposPago']); ++$i) {
                                                $selected = "";
                                                if ($data['tiposPago'][$i]['idtipopago'] == $data['orden']['tipopagoid'] ) {
                                                    $selected = "selected";
                                                }
                                        ?>
                                        <option value="<?= $data['tiposPago'][$i]['tipopago'] ?>" <?= $selected ?> ><?= $data['tiposPago'][$i]['tipopago'] ?></option>
                                        <?php  }  ?>
                                    </select>
                                    <?php } ?>
                                </td>                                
                            </tr>
                            <tr>
                                <td>Estado: </td>
                                <td> 
                                    <select name="listEstado" id="listEstado" class="form-control selectpicker" required>
                                        <?php foreach (STATUS as $status) {
                                         ?>
                                        <option value="<?php $status ?>"><?= $status ?></option>
                                        <?php } ?>
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