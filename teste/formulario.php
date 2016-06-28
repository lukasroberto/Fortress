<center><br><h2>WebMaster.PT</h2<br>Inserindo Campos em Formulário Dinâmico<br><Br></center>
<?php
if(isset($_POST["campo"])) {
    echo "<br><br>
    <b>Formulário:</b><br><br>

    <form name='form' method='POST' action='formulario_envia.php'>
    <table width='100%' border='0' cellspacing='0' cellpadding='5'>
    ";

    // Faz loop pelo array dos campos:
    foreach($_POST["campo"] as $campo) {
    $nome_arquivo = $campo;
    

        echo "<tr><td>$campo</td> <td><input type='text' name='campo[$nome_arquivo]' size='40'></td></tr>";
    }
}else{
        echo "Você não adicionou dados em nenhum campo!";
}

echo "<tr><td colspan='2'><center><input type='submit' name='submit' value='enviar'></center></td></tr>
    </table></form>";


?>
