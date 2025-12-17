<?php

	const BASE_URL = "http://localhost/TiendaVirtual-php";	

	//conexion a la base de datos
	const DB_HOST = "localhost";
	const DB_NAME = "db_tiendavirtual";
	const DB_USER = "root";
	const DB_PASSWORD = "";
	const DB_CHARSET = "charset=utf8";

	//delimitador de decimales
	const SPD = ".";
	const SPM = ",";

	//simbolo de la moneda
	const SMONEY = "$";
	const CURRENCY = "USD";

	//API de paypal
	//SANBOX DESARROLLO
	const URLPAYPAL = "https://api-m.sandbox.paypal.com";
	const IDCLIENTE = "AXcu4igqOIlCNdB7j8XzRjTpC7fQGV3uVtyfPDCqWEYj29fRb_7VWhavvEAbFbB7f2Cua6q_MXhpsi2x";
	const SECRET = "EH-5YQ7O382ApTYbYllqRgRZgIv7ozujgImSSG5UirU-X4ykdqKVHrZyjI7smb1RqhadiAFlpLT-YoWA";
	// LIVE PRODUCCION
    //const URLPAYPAL = "https://api-m.paypal.com";
	//const IDCLIENTE = "AfK8ZEd3Uk6G7U2VsRz0PavEBakAeD7mTvSGbwR36Bs8SYzgmEPBy6mG918u6rjkLm9m3aTyXvnv_6K7";
	//const SECRET = "EGv2iiHY2O3w-jdRJgasmZWkxk0hEwQa2Hf_WSg3GWl8li9BzLTT1lN4VYbEr3kCY7AvJMHVVUqhik4z";

	//envio de correo
	const NOMBRE_REMITENTE = "Tienda Virtual";
    const EMAIL_REMITENTE = "no-reply@mail.com";
    const WEB_EMPRESA = "www.miher.com";
    const NOMBRE_EMPRESA = "MiherSoluciones";

    //detalles de la empresa
    const DIRECCION = "Jr. Los Pino N° 262 - Pillcomarca";
    const TELEMPRESA = "957 533 395";
    const WHATSAPP = "+51957533395";
    const EMAIL_EMPRESA = "empresa@mail.com";
    const EMAIL_PEDIDOS = "gracmi8dsc@mkzaso.com"; //email donde se va a registrar los pedidos
    const EMAIL_SUSCRIPCION = "miherxrxr@gmail.com";
    const EMAIL_CONTACTO = "miherxrxr@gmail.com";
    const DESCRIPCION = "La tienda virtual que esta de moda";
    const SHAREDHASH = "TiendaVirtual";

    const CAT_SLIDER = "4,5,8";
    const CAT_BANNER = "1,7,9";
    const CAT_FOOTER = "2,3,5,7";

    const KEY = "miher";
    const METHODENCRIPT = "AES-256-ECB";

    const COSTOENVIO = 10;

    //modulos
    const MCLIENTES = 3;
    const MPEDIDOS = 5;
    const MSUSCRIPTORES = 7;
    const MCONTACTOS = 8;
    const MPAGINAS = 9;

    //paginas
    const PPREGUNTAS = 6;
    const PTERMINOS = 7;
    const PERROR = 10;

    //roles
    const RADMINISTRADOR = 1;
    const RCLIENTES = 7;

    const STATUS = array('Completado', 'Aprobado', 'Cancelado', 'Reembolsado', 'Pendiente', 'Entregado');

    // Para mostrar la cantidad por pagina
    const CANTPRODHOME = 4;
    const PRODPORPAGINA = 6;
    const PROCATEGORIA = 2;
    const PROBUSCAR = 3;

    //redes sociales

    const FACEBOOK = "https://www.facebook.com/mijailherder/";
    const INSTAGRAM = "https://www.facebook.com/mijailherder/";
    const LINKEDIN = "https://www.linkedin.com/in/mijail-herder-701323239/";

?>