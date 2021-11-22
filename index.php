<!DOCTYPE html>
<html>
<head>
	<title>Simple Crud</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<meta charset="UTF-8">
</head>
<body>
	<br>
	<h1 class="h1 text-center" >Gerenciamento de Usuários </h1>
	<br>
	<div class="col-10 m-auto row">
		<div class="col-6">
			<h2>Cadastro:</h2>
			<form id="registerForm" method="post">
				<div class="form-group">
					<label for="name">Nome completo:</label>
					<input type="text" id="name" name="name" class="form-control">
				</div>
				<div class="form-group">
					<label for="userName">Nome de login:</label>
					<input type="text" id="userName" name="userName" class="form-control">
				</div>
				<div class="form-group">
					<label for="zipCode">CEP</label>
					<input type="text" id="zipCode" name="zipCode" class="form-control">
				</div>
				<div class="form-group">
					<label for="email">Email:</label>
					<input type="text" id="email" name="email" class="form-control">
				</div>
				<div class="form-group">
					<label for="password">Senha (8 caracteres mínimo, contendo pelo menos 1 letra e 1 número):</label>
					<input type="password" id="password" name="password" class="form-control">
				</div>
				<input type="submit" class="btn btn-primary" value="Cadastrar">
			</form>
		</div>
		<div class="col-6">
			<h2>Busca:</h2>
			<form id="login">
				<div class="form-group">
					<label for="userName">Nome de login:*</label>
					<input type="text" id="userName" name="userName" class="form-control" required>
				</div>
				<div class="form-group">
					<label for="password">Senha:*</label>
					<input type="password" id="password" name="password" class="form-control" required>
				</div>
				<input type="submit" class="btn btn-info" value="Buscar">
			</form>
		</div>
	</div>
	<script type="text/javascript">
		$('#registerForm').submit(function(e){
			e.preventDefault();
			$.ajax({
				url: 'src/route.php?route=createUser',
				type: 'post',
				data: $('#registerForm').serialize(),
				success: function(response){
					alert("usuário criado com sucesso! id: "+response);
					$('#registerForm').trigger("reset");
				},
				error: function(XMLHttpRequest) {
					if(XMLHttpRequest.status == 422){
						XMLHttpRequest.responseJSON.forEach(msg => {
							alert(msg);					
						});
					}else{
						console.log(XMLHttpRequest);
					}
				}
			});
		});

		$('#login').submit(function(e){
			e.preventDefault();
			$.ajax({
				url: 'src/route.php?route=login',
				type: 'post',
				data: $('#login').serialize(),
				success: function(response){
					$('#name').val(response.name);
					$('#userName').val(response.userName);
					$('#zipCode').val(response.zipCode);
					$('#email').val(response.email);
				},
				error: function(XMLHttpRequest) {
					if(XMLHttpRequest.status == 401){
						alert(XMLHttpRequest.responseJSON);
					}else{
						console.log(XMLHttpRequest);
					}
				}
			});
		});

	</script>
</body>
</html>