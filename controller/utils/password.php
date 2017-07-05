<!DOCTYPE html>
  <html lang="en">
    <head>
		<link href="../../public/css/estilos.css" rel="stylesheet" type="text/css" />
    </head>
	<body>
		<main class="container">
			<h4>Email = <?php echo $_GET['email']; ?></h4><br>
			<p>	
				Implementar função de recuperação de senha!<br>
				mas testar se o usuario não está bloqueado antes<br>
			</p>
			<div class="well" style='font-size:15px;display:inline-block;'>
				<i style="color:#2196F3;">
					<span style='color:red'>se</span> usuario->bloqueado <span style='color:red'>entao</span><br>
					&nbsp;&nbsp;&nbsp;&nbsp;não permitir que recupere a senha<br>
					<span style='color:red'>senão</span><br>
					&nbsp;&nbsp;&nbsp;&nbsp;permitir que recupere a senha<br>
					<span style='color:red'>fimse</span>
				</i>
			</div>
		</main>
	</body>
</html>

