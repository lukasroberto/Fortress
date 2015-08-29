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
                require_once("../../controller/usuario.controller.class.php");
                require_once("../../model/usuario.class.php");
                
                include_once("../../functions/functions.class.php");
                
                $teste 	= new TesteController;
                
                $registros 	= $teste->listObjectsGroup();
                $functions	= new Functions;
                                

                while($reg = sqlsrv_fetch_array($registros)){

                echo $reg["log_nome"]; 

               ?>
 