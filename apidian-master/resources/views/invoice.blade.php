<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css'>
	<title>FACTURA ELECTRONICA</title>
</head>
<body>
<style type="text/css">

    * {
        margin:0; padding:0;
        font-family:'sans-serif'
    }
    html,body{
        vertical-align:baseline
    }
    article,aside,details,figcaption,figure,footer,header,hgroup,menu,nav,section{
        display:block
    }
    body{
        line-height:1
    }
    ol,ul{
        list-style:none
    }
    blockquote,q{
        quotes:none
    }
    blockquote:before,blockquote:after,q:before,q:after{
        content:'';
        content:none
    }
    table{
        border-collapse:collapse;
        border-spacing:0
    }
    body{
        font-family:'sans-serif';
        font-size:14px
    }
    strong{
        font-weight:700
    }
    .row{
        font-size: 11px;
    }
    #container{
        position: relative;
        padding:4%;
        width: 750px;
        margin: 0 auto;

    }
    #header{
        height:80px
    }
    #header > #reference{
        position: absolute;
        margin-top: 20px;
    }
    #reference{
        font-size: 10px;
    }
    #header > #reference h3{
        margin:0
    }
    #header > #reference h4{
        margin:0;
        font-size:85%;
        font-weight:600
    }
    #header > #reference p{
        margin:0;
        margin-top:2%;
        font-size: 11px;
        text-align: center;

    }
    #header > #logo{
        width:100%;
        float:left
    }
    #fromto{
        height:160px
    }
    #fromto > #from,#fromto > #to{
        width:33%;
        min-height:90px;
        margin-top:30px;
        font-size:85%;
        padding:1.5%;
        line-height:120%
    }
    #fromto > #from{
        float:left;
        width:33%;
        background:#efefef;
        margin-top:30px;
        font-size:85%;
        padding:1.5%
    }
    #fromto > #to{
        float:left;
        margin-left: 12px;
        width: 31%;
        border:solid grey 1px
    }
    .subheader{
        margin-top:10px
    }
    .subheader > p{
        font-weight:700;
        text-align:right;
        margin-bottom:1%;
        font-size:65%
    }
    .subheader > table{
        width:100%;
        font-size:85%;
        border:solid grey 1px
    }
    .subheader > table th:first-child{
        text-align:left
    }
    .subheader > table th{
        font-weight:400;
        padding:1px 4px
    }
    .subheader > table td{
        padding:1px 4px
    }
    .subheader > table th:nth-child(2),.subheader > table th:nth-child(4){
        width:45px
    }
    .subheader > table th:nth-child(3){
        width:60px
    }
    .subheader > table th:nth-child(5){
        width:80px
    }
    .subheader > table tr td:not(:first-child){
        text-align:right;
        padding-right:1%
    }
    .subheader table td{
        border-right:solid grey 1px
    }
    .subheader table tr td{
        padding-top:3px;
        padding-bottom:3px;
        height:10px
    }
    .subheader table tr:nth-child(1){
        border:solid grey 1px
    }
    .subheader table tr th{
        border-right:solid grey 1px;
        padding:3px
    }
    .subheader table tr:nth-child(2) > td{
        padding-top:8px
    }
    .items{
        margin-top:10px
    }
    .items > p{
        font-weight:700;
        text-align:right;
        margin-bottom:1%;
        font-size:65%
    }
    .items > table{
        width:100%;
        font-size:85%;
        border:solid grey 1px
    }
    .items > table th:first-child{
        text-align:left
    }
    .items > table th{
        font-weight:400;
        padding:1px 4px
    }
    .items > table td{
        padding:1px 4px
    }
    .items > table th:nth-child(2),.items > table th:nth-child(4){
        width:45px
    }
    .items > table th:nth-child(3){
        width:60px
    }
    .items > table th:nth-child(5){
        width:80px
    }
    .items > table tr td:not(:first-child){
        text-align:right;
        padding-right:1%
    }
    .items table td{
        border-right:solid grey 1px
    }
    .items table tr td{
        padding-top:3px;
        padding-bottom:3px;
        height:10px
    }
    .items table tr:nth-child(1){
        border:solid grey 1px
    }
    .items table tr th{
        border-right:solid grey 1px;
        padding:3px
    }
    .items table tr:nth-child(2) > td{
        padding-top:8px
    }
    .summary{
        height:130px;
        margin-top:30px
    }
    .summary #note{
        float:left
    }
    .summary #note h4{
        font-size:10px;
        font-weight:600;
        font-style:italic;
        margin-bottom:4px
    }
    .summary #note p{
        font-size:10px;
        font-style:italic
    }
    .summary #total table{
        font-size:85%;
        width:260px;
        float:right;
        margin-top: 40px;
    }
    .summary #total table td{
        padding:3px 4px
    }
    .summary #total table tr td:last-child{
        text-align:right
    }
    .summary #total table tr:nth-child(3){
        background:#efefef;
        font-weight:600
    }
    #footer{
        margin:auto;
        margin-top: 20px;
        left:4%;
        bottom:4%;
        right:4%;
        border-top:solid grey 1px
    }
    #footer p{
        margin-top:1%;
        font-size:65%;
        line-height:140%;
        text-align:center
    }
    .sinbode tr td,.sinbode tr, .sinbode tr th{
        border:none!important;
    }
    .summarys{
        border: solid grey 1px;
        margin-top: 10px;
        padding: 10px;
    }
    .summaryss{
        border: solid grey 1px;
        margin-top: 10px;
        padding: 3px;
    }
    #fromto > #from, #fromto > #qr {
        width: 11%;
        min-height: 90px;
        margin-top: 30px;
        font-size: 85%;
        padding: 1.5%;
        line-height: 120%;
    }
    #fromto > #from {
        width: 46%;
        min-height: 90px;
        margin-top: 30px;
        font-size: 85%;
        padding: 1.5%;
        line-height: 120%;
    }
    #fromto > #qr {
        float: right;
        /* border: solid grey 1px;
        */
    }
    .summary #firma table td,.summary #firma table tr{
        border:none !important;
    }
    #empresa-header{
        text-align: center;
        font-size: 10px;
    }

</style>
<div id="container">
    <div id="header">
        <div class="row">
            <div class="col-sm-2">
                <div id="reference" style="text-align: center;">
                    <p style="text-align: center;"><strong> FACTURA DE VENTA No</strong></p>
                    <p style="color: red;
                        font-weight: bold;
                        text-align: center;
                        margin-top: 3px;
                        margin-bottom: 3px;
                        border: 1px solid #000;
                        padding: 5px;
                        line-height: 10px;
                        border-radius: 6px;"> {{$request->number}} </p>
                    <p>Fecha: {{ $date }}</p>
                </div>
            </div>
            <div class="col-sm-6">
                <div id="empresa-header">
                    {{$user->name}} <br>
                    NIT: {{$company->identification_number}} {{$company->type_regime->name}}<br>
                    Documento Oficial de Autorización de Numeración de Facturación No. {{$resolution->resolution}} <br>
                    de {{$resolution->resolution_date}} Rango {{$resolution->from}} Al {{$resolution->to}} IMPRESA POR COMPUTADOR<br>
                    Actividad Economica {{$company->type_operation->name}} {{$company->type_operation->code}} Tarifa 9.66 x 1000 <br>
                    {{$company->address}} - {{$company->municipality->name}} - {{$company->country->name}} PBX - {{$company->phone}}<br>
                    Email: {{$user->email}} <br>
                </div>
            </div>
            <div class="col-sm-2">
            <img src="{{$imgLogo}}" width="100%" alt="logo_mcs">
            </div>
        </div>

        

    </div>
    <br/><br/>
    <div class="client" style="width:750px">
    <div class="row">
        <div class="col-sm-5">
            <p>
                <strong>Nit : {{$customer->company->identification_number}} {{$customer->company->identification_number}}</strong><br> Contacto: ANA DILFA RODRÍGUEZ G. <br> Cargo: ANALISTA ABASTECIMIENTO Y LOGÍSTICA<br> Sucursal: CASANARÉ   <br> Ciudad: {{$customer->company->municipality->name}} - CASANARÉ    - {{$customer->company->country->name}}  <br> Dirección: {{$customer->company->address}}<br>
            </p>
        </div>
        <div class="col-sm-4">
            <p>
                <strong>Forma de Pago:</strong>30 Dias<br>
                <strong>Fecha Vencimiento:</strong> 2019-Jun-07<br>
                <strong>Teléfono Cliente: {{$customer->company->phone}}</strong><br>
            </p>
        </div>

        <div class="col-sm-2">
            <img style="width: 90px;" src="{{$imageQr}}">
        </div>


    </div>
    <br/>
    <br>
    <div class="row">
        <div class="col-sm-12">
            <table class="table table-bordered table-condensed table-striped table-responsive">
                <thead>
                    <tr>
                        <th class="text-center">Código</th>
                        <th class="text-center">Nombre</th>
                        <th class="text-center">Cantidad</th>
                        <th class="text-center">Val. Unit</th>
                        <th class="text-center">IVA</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($request['invoice_lines'] as $item)
                        <tr>
                            <td>{{$item['code']}}</td>
                            <td>{{$item['description']}}</td>
                            <td class="text-right">{{$item['invoiced_quantity']}}</td>
                            <td class="text-right">{{$item['tax_totals'][0]['taxable_amount']}}</td>
                            <td class="text-right">{{$item['tax_totals'][0]['tax_amount']}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="summarys">
        <div id="note">
            <h4>Anexos :</h4>
            <br>
            <p>REPORTE DE RESULTADOS DE LABORATORIO No.<br>
            <strong>SON</strong>: CINCO MILLONES CUATROCIENTOS CATORCE MIL QUINIENTOS PESOS M/CTE*********.</p>
        </div>
    </div>

    <div class="summary" >
        <div id="note">
            <p>INFORME EL PAGO AL FAX 679-7855 EXT: 107 o email {{$user->email}}<br> NO SE ACEPTA LA DEVOLUCION DE LA FACTURA DESPUES DE CINCO (5)<br> DIAS DE RECIBIDA
                <br>
                <div id="firma">
                    <p><strong>FIRMA ACEPTACIÓN:</strong></p><br>
                    <p><strong>CC:</strong></p><br>
                    <p><strong>FECHA:</strong></p><br>
                </div>
            </p>
        </div>

        <div id="total">
            <table>
                {{-- @foreach ($request->tax_totals as $item)
                    <tr>
                        <td>SubTotal</td>
                        <td>{{$item['taxable_amount']}}</td>
                    </tr>
                    <tr>
                    <td>IVA ({{$item['taxable_amount']}}%)</td>
                    <td>{{$item['tax_amount']}}</td>
                    </tr>
                    <tr>
                        <td>Total</td>
                        <td>{{$item['taxable_amount'] + $item['tax_amount']}}</td>
                    </tr>
                @endforeach --}}
            </table>
        </div>
    </div>
    <br/>
    <div class="summaryss" >
        <div id="note">
            <p style="font-size: 11px;text-align: justify;line-height: 16px;">
                <strong>Realice su pago en cualquiera de las siguientes cuentas corriente</strong> :Cuenta de Ahorros Bancoomeva 050802325801 a nombre de <br><strong> MCS CONSULTORIA Y MONITOREO AMBIENTAL.</strong> <br>
                <strong>SI ES AGENTE RETENEDOR POR FAVOR REALIZAR EL 11% Y DE ICA EN BOGOTA EL 9.66 X MIL.</strong> <br> 1) EN CASO DE MORA EN EL PAGO SE CAUSARA EL INTERES AUTORIZADO POR LA LEY ART 65 LEY 45/90 Y <br> CONCORDANTES CON EL CODIGO DE COMERCIO.<br>                2) PARA LA CANCELACION DE ESTA FACTURA SIRVASE GIRAR CHEQUE CRUZADO CON SELLO RESTRICTIVO DE ENDOSO <br> AL PRIMER BENEFICIARIO.<br> 3) ESTA FACTURA ES PRUEBA DE QUE EL CONTRATO EN REFERENCIA HA SIDO DEBIDAMENTE EJECUTADO .
            </p>
        </div>
    </div>
    <div class="summaryss">
        <div id="note">
            <p style="font-size: 8px;text-align: justify;">
                Condiciones de pago: Para efectos legales del Articulo 774 del Codigo de Comercio, el comprador y aceptante declara haber recibido real y materialmente las mercancias detalladas en este mismo<br> titulo-valor, obligandose a pagar su valor
                al vendedor, en forma descrita en esta factura. Pago se hara en la ciudad de Bogota D.C. en moneda legal colombiana. Esta factura se asimila en sus efectos<br> de cambio (Articulo 774 del Cigo de Comercio). Esta factura causara intereses
                por mora a partir de su vencimiento de acuerdo con el Articulo 884 del Codigo de Comercio. .
            </p>
        </div>
    </div>
    <div id="footer">
        <p>ORIGINAL Usuario: administrador Factura No: {{$request->number}} Pagina 1 de 1 Fecha: {{$date}} <br> CUFE: <strong>93b8be786b03638179bb275fdc336b92111c20b5b113250a8ccb1bc28275a1a5b1f15a7c48ce3af42f47ce7507e2a390</strong></p>
    </div>
</div>
</body>
</html>
