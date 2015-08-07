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
                require_once("../../controller/empresa.controller.class.php");
                require_once("../../model/empresa.class.php");
                
                include_once("../../functions/functions.class.php");
                
                $empresa 	= new EmpresaController;
                
                $registros 	= $empresa->listObjectsGroup();
                $functions	= new Functions;
                
                $id = ( isset($_GET['idempresa']) ) ? $_GET['idempresa'] : 0;
                
                if ($id > 0) {
                if($_SESSION["nivuser"]==1){
                    $empresa = new Empresa();
                    $empresa->setStatus("False");
                    $controller    = new EmpresaController;
                    $controller->update($empresa, 'emp_id', $id);

                //$load = $usuario->remove($id, 'log_id');
                header('Location: lista.php?acao=3&tipo=1');
                }else{
                header('Location: lista.php?tipo=2');
                }
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
                
                <body>
                <?php include_once("../../view/menu/menu.php");?>
                <div class="container"> 
                
                <!-- Título -->
                <blockquote>
                <h2>Gerenciar Empresas</h2>
                <small>Utilize os campos abaixo para cadastrar ou editar empresas</small> </blockquote>
                
                <!-- Mensagem de Retorno -->
                <?php
                if(!empty($_GET["tipo"])){
                if(!empty($_GET["acao"])){
                $functions->mensagemDeRetorno($_GET["tipo"],$_GET["acao"]);
                }else{
                $functions->mensagemDeRetornoPersonalizada($_GET["tipo"],"Você não tem Permissão para editar ou exluir este usuário! Contate o Administrador em caso de duvidas.");
                }
                }
                ?>

                <hr>
                <div class="form-group">
                <a href="edita.php" class="btn btn-primary btn-large">Cadastrar uma nova Empresa</a>
                </div>
                <?php
                if($registros){
                ?>
                <!-- Lista -->
                <table id="tabela" class="tablesorter table table-hover table-striped">
                <thead>
                <tr>
                <th class="iconorder">Código</th>
                <th class="iconorder">Razão Social</th>
                <th class="iconorder">Cidade</th>
                <th class="iconorder">CNPJ</th>
                <th class="iconorder">Logo</th>
                <th style="text-align:center"><i class="glyphicon glyphicon-pencil"></i></th>
                <th style="text-align:center"><i class="glyphicon glyphicon-trash"></i></th>
                </tr>
                </thead>
                <tbody>
                <?php
                while($reg = sqlsrv_fetch_array($registros)){
                ?>
                <tr>
                <td><?php echo $reg["emp_id"]; ?></td>
                <td><?php echo $reg["emp_razao_social"]; ?></td>
                <td><?php echo $reg["emp_cidade"]; ?></td>
                <td><?php echo $reg["emp_cnpj"]; ?></td>
                <td><img src="../../img/logo/<?php echo $reg["emp_id"];?>P.png"/></td>
                <td style="text-align:center"><a type="button" title="Editar" href="edita.php?idempresa=<?php echo $reg["emp_id"]; ?>"><i class="glyphicon glyphicon-pencil"></i></a></td>
                <td style="text-align:center"><a type="button" title="Excluir" class="vermelho-excluir" href="lista.php?idempresa=<?php echo $reg["emp_id"]; ?>"><i class="glyphicon glyphicon-trash"></i></a></td>
                </tr>
                <?php
                }
                ?>
                </tbody>
                </table>
                
                <!--
                <div class="pagination">
                <ul>
                <li><a href="#">Prev</a></li>
                <li><a href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li class="active"><a href="#">3</a></li>
                <li><a href="#">4</a></li>
                <li><a href="#">5</a></li>
                <li><a href="#">6</a></li>
                <li><a href="#">Next</a></li>
                </ul>
                </div>
                -->
                
                <?php
                }else{
                ?>
                <div class="text-center">
                <h2>Opsss!!!</h2>
                <p>Sua pesquisa não retornou nenhum resultado válido.</p>
                </div>
                <?php
                }
                ?>
                <?php include_once("../../view/footer/footer.php");?>
                </div>
                <!-- /container --> 
                
                <script src="../../js/jquery.validate.min.js"></script> 
                <script src="../../js/bootstrap.min.js"></script> 
                <script src="../../js/jquery-ui.js"></script> 
                <script src="../../js/jquery.tablesorter.js"></script>
                
                <script type="text/javascript">
                $(document).ready(function() { 
                $("#tabela").tablesorter()
                });
                </script>
                 </body>
                </html>