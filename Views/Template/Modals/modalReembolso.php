<?php 
//dep($data);exit();
    // DATOS DE LA TRANSACCION
    $tsr = $data->purchase_units[0];
    $idTransaccion = $tsr->payments->captures[0]->id;    
    $moneda = $tsr->payments->captures[0]->amount->currency_code;
    //DATOS DEL CLIENTE
    $cl = $data->payer;
    $nombreCliente = $cl->name->given_name.' '.$cl->name->surname;
    $emailCliente = $cl->email_address;
    $telCliente = isset($cl->phone) ? $cl->phone->phone_number->national_number : "";   
    $emailComercio = $tsr->payee->email_address;
 
    //Detalle pago
    $totalCompra =  $tsr->payments->captures[0]->seller_receivable_breakdown->gross_amount->value;
    $comision = $tsr->payments->captures[0]->seller_receivable_breakdown->paypal_fee->value;
    $importeNeto = $tsr->payments->captures[0]->seller_receivable_breakdown->net_amount->value;
?>
<!-- Modal -->
<div class="modal fade" id="modalReembolso" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" >
        <div class="modal-content">
            <div class="modal-header header-primary">
                <h5 class="modal-title" id="titleModal">Modal Reembolso</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <input type="hidden" id="idtransaccion" value="<?= $idTransaccion ?>">
                    <tbody>
                        <tr>
                            <td>Transaccion:</td>
                            <td><?= $idTransaccion ?></td>
                        </tr>
                        <tr>
                            <td>Datos contacto:</td>
                            <td><?= $nombreCliente ?> <br> <?= $emailCliente ?> <br> <?= $telCliente ?></td>
                        </tr>
                        <tr>
                            <td>Importe total reembolso:</td>
                            <td><?= $totalCompra.' '.$moneda ?></td>
                        </tr>
                        <tr>
                            <td>Importe neto reembolso:</td>
                            <td><?= $importeNeto.' '.$moneda ?></td>
                        </tr>
                        <tr>
                            <td>Comision reembolso por Paypal:</td>
                            <td><?= $comision.' '.$moneda ?></td>
                        </tr>
                        <tr>
                            <td>Observacion:</td>
                            <td>
                                <textarea class="form-control" id="txtObservacion"></textarea>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <button type="button" class="btn btn-primary " onclick="fntReembolsar()" data-dismiss="modal"><i class="fa fa-reply-all"></i> Reembolsar</button>
                <button type="button" class="btn btn-secondary " data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>