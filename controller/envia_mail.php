<?php
require_once '../phpmailer/class.phpmailer.php';
require_once '../phpmailer/class.smtp.php';

//classe de email
 class Email{
    //INFOS PARA CONEXÃO ETC
    //troca o nome das variaveis e usa quantas precisar
    public $usuarioSmtp;
    public $senhaSmtp;
    public $from;
    public $FromName;


    //chamar função para quando smtp não tiver setado
    private function setNoreplay(){
    	$this->usuarioSmtp = 'no-reply@sistemamutley.com.br';
    	$this->senhaSmtp = 'mutleynoreply';
    	$this->from = "no-reply@sistemamutley.com.br";
    	$this->FromName = "Não responda";
    }


    /**
     *	chamar essa função para definir usuario e senha de smtp
     * 	@var usuario => Usuário do servidor SMTP (endereço de email)
     * 	@var senha => Senha do servidor SMTP (senha do email usado) 
     */
    public function setSmtp($usuario,$senha){
    	$this->usuarioSmtp = $usuario;
    	$this->senhaSmtp = $senha;
    }

    /**
     *	chamar essa função para definir usuario e senha de smtp
     * 	@var remetenteEmail => seu e-mail
     * 	@var remetenteNome => Seu nome 
     */
    public function setSender($remetenteEmail, $remetenteNome){
    	$this->from = $remetenteEmail;
    	$this->FromName = $remetenteNome;
    } 


    /**
     *	enviar email
     * 	@var destinatarios => array com 'nome' => nome do destinarios, 'email' => 'emaildestinarios@email.com.br'
     * 	@var destinatariosCC => array com 'nomeCC' => nome do destinarios, 'email' => 'emaildestinariosCC@email.com.br'
     *  @var destinatariosBCC => array com 'nomeBCC' => nome do destinarios, 'email' => 'emaildestinariosBCC@email.com.br'
     * 	@var mensagem => mensagem a ser enviada
     */
    public function send($destinatarios, $mensagem, $assunto, $destinatariosCC = null, $destinatariosCCO = null){
        $mail = new PHPMailer();
        // Define os dados do servidor e tipo de conexão
        // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
        $mail->SMTPDebug = 2;
        $mail->IsSMTP(); // Define que a mensagem será SMTP
        $mail->Host = "smtp.sistemamutley.com.br"; // Endereço do servidor SMTP (caso queira utilizar a autenticação, utilize o host smtp.seudomínio.com.br)
        $mail->SMTPAuth = true; // Usar autenticação SMTP (obrigatório para smtp.seudomínio.com.br)
        //teste de contingencia se usario e senha não forem setados antes de enviar o email
        if($this->usuarioSmtp != null && $this->senhaSmtp != null){
        	$mail->Username = $this->usuarioSmtp; // Usuário do servidor SMTP (endereço de email)
        	$mail->Password = $this->senhaSmtp; // Senha do servidor SMTP (senha do email usado)
        }else{
         $this->setNoreplay();
         $mail->Username = $this->usuarioSmtp;
         $mail->Password = $this->senhaSmtp;
        }
    	// Define o remetente
		// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		$mail->From = $this->from; // Seu e-mail
		$mail->Sender = $this->from; // Seu e-mail
		$mail->FromName = $this->FromName; // Seu nome
		// Define os destinatário(s)
		// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		//se existir mais de um destinario
		foreach ($destinatarios as $destinatario ) {
            $mail->AddAddress($destinatario['email'],$destinatario['nome']);
        }
        // Define os dados técnicos da Mensagem
        // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
        $mail->IsHTML(true); // Define que o e-mail será enviado como HTML
        //$mail->CharSet = 'iso-8859-1'; // Charset da mensagem (opcional)

        // Define a mensagem (Texto e Assunto)
        // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
        $mail->Subject  = $assunto; // Assunto da mensagem
        $mail->Body = $mensagem;
        $mail->AltBody = $mensagem;

        // Define os anexos (opcional)
        // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
        //$mail->AddAttachment("/home/login/documento.pdf", "novo_nome.pdf");  // Insere um anexo

        // Envia o e-mail
            $enviado = $mail->send();

        // Limpa os destinatários e os anexos
            $mail->ClearAllRecipients();
            $mail->ClearAttachments();

            return $enviado;
        }

    }
