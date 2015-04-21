<?php
//Inclui o arquivo class.phpmailer.php localizado na pasta phpmailer
require("../../controller/mail/class.phpmailer.php");

session_start();
if($_SESSION["idusuario"]==NULL){
header('Location: ../login/login.php?acao=5&tipo=2');
}

//Inicia a classe PHPMailer
$mail = new PHPMailer();

$dados = (isset($_POST['dados']))? $_POST['dados']:'';
$turno = (isset($_POST['turno']))? $_POST['turno']:'';
$tipoOS = (isset($_POST['tipoOS']))? $_POST['tipoOS']:'';

 if($turno == 1){
 	$turno = "06:00 as 18:00";
 }else if($turno == 2){
 	$turno = "18:00 as 06:00"; 
 }else{
 	$turno ="Turno não Cadastrado!";
 	}

//Define os dados do servidor e tipo de conexão
$mail->IsSMTP(); // Define que a mensagem será SMTP
$mail->Host = "192.168.0.13"; // Endereço do servidor SMTP
$mail->SMTPAuth = true; // Autenticação
$mail->Username = 'monitoramento@grupofortress.br'; // Usuário do servidor SMTP
$mail->Password = 'Fortress1'; // Senha da caixa postal utilizada

//Define o remetente
$mail->From = "monitoramento@grupofortress.br"; 
$mail->FromName = "Monitoramento";

//Define os destinatário(s)
$mail->AddAddress('marcelo@grupofortress.br', 'Marcelo Ribeiro');
$mail->AddCC('vanessa@grupofortress.br', 'Vanessa Reis'); // Copia
$mail->AddCC('diego@grupofortress.br', 'Diego'); // Copia
$mail->AddCC('erica@grupofortress.br', 'Erica Fernandes'); // Copia
$mail->AddCC('maycon@grupofortress.br', 'Maycon Toledo'); // Copia
//$mail->AddCC('lukas@grupofortress.br', 'Lukas Roberto'); // Copia

//$mail->AddBCC('fulano@dominio.com.br', 'Fulano da Silva'); // Cópia Oculta

//Define os dados técnicos da Mensagem
$mail->IsHTML(true); // Define que o e-mail será enviado como HTML
$mail->CharSet = 'UTF-8'; // Charset da mensagem (opcional)

//Texto e Assunto
$mail->Subject  = "O.S ".$tipoOS." - Turno das ".$turno." - Monitor(a) ".$_SESSION["nome"]; // Assunto da mensagem
$mail->Body = $dados;


//Envio da Mensagem
$enviado = $mail->Send();

//Limpa os destinatários e os anexos
$mail->ClearAllRecipients();
$mail->ClearAttachments();

//Exibe uma mensagem de resultado
if ($enviado) {
header("location: ../os/lista.php?tipo=1&acao=mail");
} else {
echo "Não foi possível enviar o e-mail (informe o Dpartamento de Informatica...)";
echo "Informações do erro: 
" . $mail->ErrorInfo;
}
?>