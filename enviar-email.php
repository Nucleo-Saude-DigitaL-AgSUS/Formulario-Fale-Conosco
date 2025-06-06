<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

$mail = new PHPMailer(true);

try {
    
    $mail->isSMTP();
    $mail->Host       = 'smtp.agenciasus.org.br';  // Ex: smtp.gmail.com
    $mail->SMTPAuth   = true;
    $mail->Username   = 'gustavo.oliveira@agenciasus.org.br'; // Seu e-mail
    $mail->Password   = 'suasenha';               // Sua senha (ou App Password)
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // Remetente e destinatário
    $mail->setFrom('gustavo.oliveira@agenciasus.org.br', 'Formulário Website');
    $mail->addAddress('faleconosco@agenciasus.org.br'); // Para quem vai o e-mail

    // Anexo (se existir)
    if (!empty($_FILES['arquivo']['tmp_name'])) {
        $mail->addAttachment($_FILES['arquivo']['tmp_name'], $_FILES['arquivo']['name']);
    }

    // Conteúdo
    $mail->isHTML(true);
    $mail->Subject = 'Nova mensagem do formulário';
    $mail->Body    = "
      <h3>Nova mensagem recebida</h3>
      <p><strong>Nome:</strong> {$_POST['nome']}</p>
      <p><strong>Email:</strong> {$_POST['email']}</p>
      <p><strong>Mensagem:</strong><br>{nl2br($_POST['mensagem'])}</p>
    ";

    $mail->send();
    echo 'Mensagem enviada com sucesso!';
} catch (Exception $e) {
    echo "Erro ao enviar: {$mail->ErrorInfo}";
}