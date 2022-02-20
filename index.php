<?php
session_start();
error_reporting(0);

$nome = 'Kauã Torres'; // Nome do Cliente
$loja = 'Loja do KT'; // Nome da loja 
$total = 1000; // Valor da compra
$produto = "Ar condicionado";
//Gera o nº do pedido
$Pedido = Random(4)."-".Random(4)."-".Random(4)."-".Random(4);
function Random($qtd){ 
$Caracteres = '0123456789'; 
$QuantidadeCaracteres = strlen($Caracteres); 
$QuantidadeCaracteres--; 

$Hash=NULL; 
    for($x=1;$x<=$qtd;$x++){ 
        $Posicao = rand(0,$QuantidadeCaracteres); 
        $Hash .= substr($Caracteres,$Posicao,1); 
    } 

return $Hash; 
} 

//************************* GERAR QR CODE  ************************* \\
$solicitacao = [
    'referenceId' => $Pedido,
    'callbackUrl' => 'http://'.$_SERVER['HTTP_HOST'].'/notificacao.php',
    'value' => $total,
    'buyer' => [
        'firstName' => $nome,
        'lastName' => '- '. $loja,
        'document' => '123.456.789-10',
        'email' => $email,
        'phone' => '+55 51 00000-0000'
    ]
];
$picPayToken = 'SeuToken'; //Token PicPay
// inicializar o cURL
$ch = curl_init();
// fornecer a url de destino
curl_setopt($ch, CURLOPT_URL, 'https://appws.picpay.com/ecommerce/public/payments');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($solicitacao));
curl_setopt($ch, CURLOPT_POST, true);

// enviar os headers obrigatórios
$headers = [];
$headers[] = 'Content-Type: application/json';
$headers[] = 'X-Picpay-Token: ' . $picPayToken;
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
// fazer a requisição
$result = curl_exec($ch);
// armazenar a resposta
$resposta = json_decode($result);
// fechar a conexão
curl_close($ch);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>PicPay - Pagamento</title>
  <meta name="author" content="Kauã Torres - @kauatorress">
  <link rel="stylesheet" href="https://raw.githubusercontent.com/Templarian/MaterialDesign-Webfont/master/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="http://www.urbanui.com/wagondash/template/vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="http://www.urbanui.com/wagondash/template/css/horizontal-layout-dark/style.css">
  <script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link rel="icon" href="../favicon.ico" type="image/x-icon" />
  <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@500&display=swap" rel="stylesheet">
  <script>
  if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
  }  
  var clearTimer = setInterval(function(){
      var req = new XMLHttpRequest();
      var resposta = "<span style='color:lime;'><i class='fa fa-check'></i> Compra efetuada.</span>";  
      req.onreadystatechange = function(){
      if (req.readyState == 4 && req.status == 200) {
              document.getElementById('status').innerHTML = req.responseText;
      }
        if (document.getElementById('status').innerHTML == "pago"){
              $('#status').html(resposta);
              req.status == 200;
              clearInterval(clearTimer);
              clearTimer = 0;
        } 
      }
      req.open('GET', 'status.php?referencia=<?= $resposta->referenceId;?>', true);
      req.send();
  }, 1500);
  
  </script>
  <style type="text/css">
  @import url('https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.css');
  *{font-family: 'Ubuntu', sans-serif;}.col-centered{float: none;margin: 0 auto;}
  </style>
</head>

<body >
  <div class="container-scroller">  
   <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <div class="main-panel"style="background: url(../../assets/public/images/bg2.jpg) fixed no-repeat;background-size:100% 100%;">
        <div class="content-wrapper p-0 pt-4">

          <div class="welcome-message" style="background-color: #154134;color: #fff;">
            <div class="d-lg-flex justify-content-between align-items-center">
              <div class="pr-5 image-border"><img src="images/dashboard/welcome.png" alt="welcome"></div>
              <div class="pl-4">
                <h2 class="text-white font-weight-bold mb-3">Bem vindo!</h2>
                <p class="pb-0 mb-1">Aqui o pagamento é feito somente pelo <b>PicPay</b>, caso você queira comprar com outro meio de pagamento, entre em contato com alguém da equipe criando seu ticket especificando o produto que quer adquirir.</p>
              </div>
              <div class="pl-4">
                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#tutorial" style="margin: 10px;">Como escanear?</button>
              </div>
            </div>
          </div>

        <div class="content-wrapper">
          <div class="row">
              <div class="col-lg-9 col-centered">
                  <div class="card px-2">
                      <div class="card-body">
                          <h3 align="center">PEDIDO: #<?=$Pedido;?></h3>
                          <hr>
                          <div class="container-fluid d-flex justify-content-between">
                            <div class="col-lg-8 pl-0">
                                <div class="table-responsive w-100">
                                  <table class="table">
                                    <tbody>
                                      <tr class="text-right">
                                        <td class="text-left">Referência</td>
                                        <td class="">#1</td>
                                      </tr>
                                      <tr class="text-right">
                                        <td class="text-left">Pedido</td>
                                        <td class="">#<?=$Pedido;?></td>
                                      </tr>
                                      <tr class="text-right">
                                        <td class="text-left">Produto</td>
                                        <td class=""><?=$produto;?></td>
                                      </tr>
                                      <tr class="text-right">
                                        <td class="text-left">Valor</td>
                                        <td class="">R$ <?=number_format($total);?></td>
                                      </tr>
                                       <tr class="text-right">
                                        <td class="text-left">Gateway</td>
                                        <td class=""> PicPay</td>
                                      </tr>
                                      <tr class="text-right">
                                        <td class="text-left">Status</td>
                                        <td class=""> <span id="status"><i class='fa fa-spinner fa-spin'></i> Carregando</span></td>
                                      </tr>
                                      
                                    </tbody>
                                  </table>
                                </div>
                            </div>
                            <div class="col-lg-3 pr-0">
                              <p>
                                <img src="images/picpay.png" style="width: 250px;position: relative;left: -40px;">
                                <span style="color: #ccc;position: relative;top: -5px;">Abra o PicPay em seu celular e escaneie o código abaixo</span>
                                <img src="<?= $resposta->qrcode->base64;?>" alt="QR Code" width="200px" height="200px" style="position: relative;left: -20px;">
                              </p>
                            </div>

                          </div>
                        <span class="text-center">
                          Após a confirmação do pagamento, seu pedido será entregue automaticamente.
                        </span>
                        
                        <div class="modal fade" id="tutorial" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Tutorial de como escanear QR Code</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <ol>
                                <li>Abra o aplicativo <b>PicPay</b></li>
                                <li>Clique no botão de scan que fica no topo do aplicativo</li>
                                <li>
                                  Aponte a câmera do seu celular para o QR Code e pronto, seu produto será liberado no mesmo instante.
                                </li>
                              </ol>
                              <div class="text-center" style="color:orange;">
                                Caso você queira comprar com outro meio de pagamento, entre em contato com alguém da equipe criando seu ticket.
                              </div>  
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-light" data-dismiss="modal">Fechar</button>
                            </div>
                          </div>
                        </div>
                      </div>

                      </div>
                  </div>
              </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:../../partials/_footer.html -->
        <footer class="footer" align="center" style="background-color: #1e1e2400;">
          <div class="container">
            <div class="w-100 clearfix">
              <span class="d-block text-center text-sm-left d-sm-inline-block">Copyright © <?=date("Y");?>. </span>
            </div>
          </div>
        </footer>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <!-- base:js -->
  <script src="http://www.urbanui.com/wagondash/template/vendors/js/vendor.bundle.base.js"></script>
  <script src="http://www.urbanui.com/wagondash/template/vendors/chart.js/Chart.min.js"></script>
  <script src="http://www.urbanui.com/wagondash/template/js/off-canvas.js"></script>
  <script src="http://www.urbanui.com/wagondash/template/js/hoverable-collapse.js"></script>
  <script src="http://www.urbanui.com/wagondash/template/js/template.js"></script>
  <script src="http://www.urbanui.com/wagondash/template/js/settings.js"></script>
  <script src="http://www.urbanui.com/wagondash/template/js/todolist.js"></script>
  <script src="http://www.urbanui.com/wagondash/template/js/dashboard.js"></script>
  <script src="http://www.urbanui.com/wagondash/template/js/todolist.js"></script>
  <script src="https://www.bootstrapdash.com/demo/wagondash/template/js/modal-demo.js"></script>
</body>
</html>