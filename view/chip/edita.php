        <?php 
        ini_set('display_errors', 1);
        ini_set('log_errors', 1);
        ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
        error_reporting(E_ALL);
        
        session_start();
        if($_SESSION["idusuario"]==NULL){
        header('Location: ../login/login.php?acao=5&tipo=2');
        }
        require_once("../../controller/chip.controller.class.php");
        require_once("../../model/chip.class.php");
        include_once("../../functions/functions.class.php");
        
        $controller     = new ChipController();
        $chip           = new Chip();
        $functions	= new Functions;
        
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
        header('Location: lista.php?acao=2&tipo=1');
        }else{
        $controller->save($chip, 'chip_codigo');
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
        <label for="sublocality">Cód. Cliente</label>
        <input class="form-control" type="text" name="clicodigo" id="clicodigo" value="<?php echo ($chip->getCodigo() > 0 ) ? $chip->getCliCodigo() : ''; ?>">
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
        <?php include_once("../../view/footer/footer.php");?>
        </div>
        <!-- /container --> 
        
        <!-- Javascript --> 
        <script src="../../js/jquery.validate.min.js"></script> 
        <script src="../../js/bootstrap.min.js"></script> 
        <script src="../../js/jquery-ui.js"></script> 
        </body>
        </html>