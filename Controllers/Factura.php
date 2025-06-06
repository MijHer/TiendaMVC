<?php 

require 'Libraries/domPDF/vendor/autoload.php';
use Dompdf\Dompdf;

class Factura extends Controllers
{
	
	public function __construct()
	{
		parent::__construct();
		session_start();
		session_regenerate_id(true);
		if (empty($_SESSION['login'])) {
			header('Location: '.base_url().'/login');
			die();
		}
		getPermisos(5);
	}

	public function generarFactura($idpedido)
	{	
		if ($_SESSION['permisosMod']['r']) {
				if (is_numeric($idpedido)) {			
				$idpersona = "";
				if ($_SESSION['permisosMod']['r'] AND $_SESSION['userData']['idrol'] == RCLIENTES) {
					$idpersona = $_SESSION['userData']['idpersona'];
				}
				$data = $this->model->selectPedido($idpedido, $idpersona);

				if (empty($data)) {
					echo "no existe este pedido";
				}else{
					ob_end_clean();
					$idpedido = $data['orden']['idpedido'];
					$html = getFile('Template/Modals/comprobantePDF', $data);
					$dompdf = new Dompdf();
					$dompdf->loadHtml($html);
					$dompdf->setPaper('A4', 'portrait');
					$dompdf->render();
					$dompdf->stream("Factura-".$idpedido.".pdf", ["Attachment" => false]);
					//$html2pdf = new Html2Pdf();
					//$html2pdf->writeHTML($html);
					//$html2pdf->output();
				}			
			}else{
				echo "no es numero";
			}
		}else{
			header('Location: '.base_url().'/login');
			die();
		}
		
	}
}

?>