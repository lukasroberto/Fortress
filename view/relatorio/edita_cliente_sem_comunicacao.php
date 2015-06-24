        <?php 
        ini_set('display_errors', 1);
        ini_set('log_errors', 1);
        ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
        error_reporting(E_ALL);
        
        session_start();
        $server = $_SERVER['SERVER_NAME']; 
        $endereco = $_SERVER ['REQUEST_URI'];
        $_SESSION["link"] = "http://" . $server . $endereco;
        
        if($_SESSION["idusuario"]==NULL){
        header('Location: ../login/login.php?acao=5&tipo=2');
        }
        require_once("../../controller/chip.controller.class.php");
        require_once("../../model/chip.class.php");
        include_once("../../functions/functions.class.php");
        include_once("../../functions/query.class.php");

        
        $controller     = new ChipController();
        $chip           = new Chip();
        $functions	    = new Functions;
        $query          = new query();
        
        if(isset($_POST['submit'])) {
        
        $chip->setCodigo($_POST['codigo']);
        $chip->setImei($_POST['imei']);
        $chip->setOperadora($_POST['operadora']);
        $chip->setDataEnvio($_POST['dataenvio']);
        $chip->setCliCodigo($_POST['clicodigo']);
        $chip->setStatus($_POST['status']);
        
        
            $operaçao = $_POST['update'];
        if($operaçao == "update"){
            $controller->update($chip, 'chip_codigo',$chip->getCodigo());
            $query->log("Update Chip id: ".$_POST['codigo']);
            header('Location: lista.php?acao=2&tipo=1');
        }else{
            $controller->save($chip, 'chip_codigo');
            $query->log("Cadastrado Chip imei: ".$_POST['imei']);
        header('Location: lista.php?acao=1&tipo=1');
        }
        }
        
        if(isset($_GET['chipcodigo'])){
        $chip = $controller->loadObject($_GET['chipcodigo'], 'chip_codigo');
        }
        
        ?>
        
        <!DOCTYPE html>
        <html lang="en">
        <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        
        <!-- Estilos -->
        <link href="../../css/bootstrap.css" rel="stylesheet">
        <link href="../../css/geral.css" rel="stylesheet">
        <link href="../../css/validation.css" rel="stylesheet">
        <link rel="stylesheet" href="../../css/jquery-ui.css" />
        </head>
        
        <body onload="initialize()">
        <?php include_once("../../view/menu/menu.php");?>
        <div class="container"> 
        
        <!-- Título -->
        <blockquote>
        <h2>Edição de Chips</h2>
        <small>Utilize o formulário abaixo para cadastrar ou editar Chips</small> </blockquote>
        
        <!-- Mensagem de Retorno -->
        <?php
        if(!empty($_GET["tipo"])){
        $functions->mensagemDeRetorno($_GET["tipo"],$_GET["acao"]);
        }
        ?>

        <div style="max-width:400px;">
        <form class="form-horizontal" id="contact-form" action="edita.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
        </input>
        <label for="codigo">Código</label>
        <input class="form-control" type="hidden" name="update" id="update" value="<?php if(!empty($_GET["operacao"]))echo"update"; ?>">
        <input name="codigo" id="codigo" type="text" class="form-control"  value="<?php echo ($chip->getCodigo() > 0 ) ? $chip->getCodigo() : ''; ?>">
        </div>
        <div class="form-group">
        <label for="nome">Imei</label>
        <input class="form-control" type="text" name="imei" id="imei" required value="<?php echo ($chip->getCodigo() > 0 ) ? $chip->getImei() : ''; ?>">
        </div>
        <div class="form-group">
        <label for="empresa">Operadora</label>
        <select class="form-control" name="operadora"id="operadora" required>
        <option>Selecionar</option>
        <option value="CLARO" <?php echo ($chip->getCodigo() > 0 && $chip->getOperadora() == 'CLARO') ? 'Selected' : ''; ?>>CLARO</option>
        <option value="VIVO" <?php echo ($chip->getCodigo() > 0 && $chip->getOperadora() == 'VIVO') ? 'Selected' : ''; ?>>VIVO</option>
        <option value="TIM(DATORA)" <?php echo ($chip->getCodigo() > 0 && $chip->getOperadora() == 'TIM(DATORA)') ? 'Selected' : ''; ?>>TIM(DATORA)</option>
        </select>
        </div>
        <div class="form-group">
        <label for="tel-secundario">Data de envio Fulltime</label>
        <input class="form-control" type="text" name="dataenvio" id="dataenvio" required value="<?php echo ($chip->getCodigo() > 0 ) ? $functions->converterData($chip->getDataEnvio()) : ''; ?>">
        </div>
        <div class="form-group">
        <label for="sublocality">Cliente que esta instalado</label>       
        <div class="input-group">
        <input class="form-control" type="text" name="clicodigo" id="clicodigo" value="<?php echo ($chip->getCodigo() > 0 ) ? $chip->getCliCodigo() : ''; ?>">
        <span class="input-group-btn">
        <button class="btn btn-primary" type="button" data-toggle="modal" data-target=".bs-example-modal-lg">Selecionar Cliente</button>
        </span>
        </div>
        </div>
        <div class="form-group">
        <label for="empresa">Status</label>
        <select class="form-control" name="status"id="status" required>
        <option>Selecionar</option>
        
        <option value="1" <?php echo ($chip->getCodigo() > 0 && $chip->getStatus() == '1') ? 'Selected' : ''; ?>>Ativo</option>
        <option value="2" <?php echo ($chip->getCodigo() > 0 && $chip->getStatus() == '2') ? 'Selected' : ''; ?>>Estoque</option>
        <option value="3" <?php echo ($chip->getCodigo() > 0 && $chip->getStatus() == '3') ? 'Selected' : ''; ?>>Cancelado</option>
        <option value="4" <?php echo ($chip->getCodigo() > 0 && $chip->getStatus() == '4') ? 'Selected' : ''; ?>>Cancelar</option>
        </select>
        </div>
        <div class="form-group">
        <input type="submit" class="btn btn-success btn-large" value="Salvar" name="submit">
        </div>
        </form>
        </div>

        <!--modal -->      
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div style="padding:30px;"> 
        
        <!-- Título -->
        <blockquote>
        <h2>Selecionar Chip</h2>
        <small>Selecione abaixo em qual cliente esta instalado este chip</small> </blockquote>
      <form id="form-pesquisa" action="" method="post">
      <input class="form-control" type="text" name="pesquisa" id="pesquisa" placeholder="Digite um nome para Filtrar">
      <br>
  </form>
  <div class="resultados"> </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
      </div>
</div>
  </div>
</div>
        <!--Fim modal -->

        <?php include_once("../../view/footer/footer.php");?>
        </div>
        <!-- /container --> 
        
        <!-- Javascript --> 
        <script src="../../js/jquery.validate.min.js"></script> 
        <script src="../../js/bootstrap.min.js"></script> 
        <script src="../../js/jquery-ui.js"></script> 

<script type="text/javascript">
function passarParametro(parametro) {
document.getElementById('clicodigo').value=document.getElementById(parametro).id;
}
</script>

        <script type="text/javascript">
$(function(){
                        //LISTA TODOS ANTES DE FILTRAR
                        $.post('buscaClientesInst.class.php', function(retorna){     $(".resultados").html(retorna);
                        });
        
        //PESQUISA INSTANTANEA PELO INPUT
        $("#pesquisa").keyup(function(){
                //Recupera oque está sendo digitado no input de pesquisa
                var pesquisa    = $(this).val();

                //Recupera oque foi selecionado
                var campo               = $("#campo").val();

                //Verifica se foi digitado algo
                if(pesquisa != ''){
                        //Cria um objeto chamado de 'dados' e guarda na propriedade 'palavra' a pesquisa e na propriedade campo o campo a ser pesquisado
                        var dados = {
                                palavra : pesquisa,
                                campo   : campo
                        }
                        
                        //Envia por AJAX pelo metodo post, a pequisa para o arquivo 'busca.php'
                        //O paremetro 'retorna' é responsável por recuperar oque vem do arquivo 'busca.php'
                        $.post('buscaClientesInst.class.php', dados, function(retorna){
                                //Mostra dentro da ul com a class 'resultados' oque foi retornado
                                $(".resultados").html(retorna);
                        });
                }else{
                        $(".resultados").html('');
                }
        });
        });
</script>
        </body>
        </html>
