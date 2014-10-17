            <?php
            ini_set('display_errors', 1);
            ini_set('log_errors', 1);
            ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
            error_reporting(E_ALL);
            
            date_default_timezone_set('America/Sao_Paulo');
            
            session_start();
            if($_SESSION["idusuario"]==NULL){
            header('Location: ../login/login.php?acao=5&tipo=2');
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
            <link href="../../css/bootstrap.min.css" rel="stylesheet">
            <link href="../../css/geral.css" rel="stylesheet">
            <link href="../../css/validation.css" rel="stylesheet">
            <link rel="stylesheet" href="../../css/jquery-ui.css" />
            
            <script type="text/javascript" src="https://www.google.com/jsapi"></script>
            <script type="text/javascript">
            google.load("visualization", "1", {packages:["corechart"]});
            google.setOnLoadCallback(drawChart);
            function drawChart() {
            
            
            
            var data = new google.visualization.DataTable(
            {
            cols: [{id: 'task', label: 'Employee Name', type: 'string'},
            {id: 'startDate', label: 'Start Date', type: 'date'}],
            rows: [{c:[{v: 'Mike'}, {v: new Date(2008, 1, 28), f:'February 28, 2008'}]},
            {c:[{v: 'Bob'}, {v: new Date(2007, 5, 1)}]},
            {c:[{v: 'Alice'}, {v: new Date(2006, 7, 16)}]},
            {c:[{v: 'Frank'}, {v: new Date(2007, 11, 28)}]},
            {c:[{v: 'Floyd'}, {v: new Date(2005, 3, 13)}]},
            {c:[{v: 'Fritz'}, {v: new Date(2011, 6, 1)}]}
            ]
            }
            );
            
            var options = {
            title: 'My Daily Activities'
            };
            
            var chart = new google.visualization.PieChart(document.getElementById('piechart'));
            
            chart.draw(data, options);
            }
            </script>
            </head>
            <body>
            <?php include_once("../../view/menu/menu.php");?>
            <div class="container"> 
            
            <!-- Título -->
            <blockquote>
            <h2>Bem-vindo</h2>
            <small>Confira abaixo os serviços pendentes.</small></blockquote>
            
            <div id="piechart" style="width: 900px; height: 500px;"></div><br><br><br><br>
            
            <?php include_once("../../view/footer/footer.php");?>
            </div>
            <!-- /container --> 
            
            <!-- Javascript --> 
            <script src="../../js/jquery.validate.min.js"></script> 
            <script src="../../js/bootstrap.min.js"></script> 
            <script src="../../js/jquery-ui.js"></script> 
            </body>
            </html>
