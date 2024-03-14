<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LocalDriver</title>
    <link rel="stylesheet" href="assets/bootstrap.min.css">
    <script src="assets/vue.min.js"></script>
    <script src="assets/axios.min.js"></script>
    <script src="assets/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="assets/flotante.css">
    <link rel="stylesheet" href="assets/inputFile.css">
    <!-- <link rel="stylesheet" href="assets/home.css"> -->
    <script src="assets/qrcode.min.js"></script>

<!-- INICIO DE CARD -->
<style>
        .card-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 130px !important;
            width: 100% !important;
            height: 90px;
            color: black;
        }

        .extension-text {
            position: absolute;
            top: 0px;
            right: 0px;
            background-color: orange;
            padding: 2px 5px;
            border: 2px solid #ccc;
            border-radius: 3px;
        }
        .card {
            width: 100% !important;
        }

        .qr-image {
            position: absolute;
            top: 0px;
            left: 0px;
            background-color: green;
            padding: 1px 1px;
            border: 2px solid #ccc;
            border-radius: 3px;
            cursor: pointer;
        }
    </style>
<!-- FIN DE CARD -->

</head>
<body style="background: black; color: #ffffff;">

<!-- <div id="qrcode"></div>

<div class="test"></div> -->
    

<!-- <script>

    var qrcodex = new QRCode(document.getElementById("qrcode"), {
        text: 'http://172.16.11.25:9091/store/Liquidaciones_prueba.apk',
        width: 100,
        height: 100
    });

    var qrcodex = new QRCode(document.getElementsByClassName("test")[0], {
        text: 'Ronny Matute',
        width: 100,
        height: 100
    });

</script> -->