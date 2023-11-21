<?php
	date_default_timezone_set('America/Sao_Paulo');
	$pdo = new PDO('mysql:host=localhost;dbname=sistema','root','');
?>

<!DOCTYPE html>
<html>
<head>
	<title>Barbearia</title>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

</head>
<link href="https://fonts.googleapis.com/css?family=Lato:400,700" rel="stylesheet">
<style type="text/css">
	* {
			margin: 0;
			padding: 0;
			box-sizing: border-box;
			font-family: "Lato";
		}

		body {
			background: rgb(225, 225, 225);
		}

		header {
			padding: 10px 0;
			background: #333;
			color: white;
		}

		nav.menu ul {
			list-style-type: none;
		}

		nav.menu li {
			display: inline-block;
			padding: 0 8px;
		}

		nav.menu a {
			color: white;
			text-decoration: none;
		}

		.logo {
			float: left;
		}

		.clear {
			clear: both;
		}

		nav.menu {
			position: relative;
			top: 4px;
			float: right;
		}

		.center {
			max-width: 1100px;
			margin: 0 auto;
			padding: 0 2%;
		}

		section.reserva {
			padding: 40px 0;
			text-align: center;
		}

		section.reserva select {
			width: 100%;
			height: 30px;
			border: 1px solid #ccc;
		}

		section.reserva input[type=text] {
			width: 100%;
			height: 30px;
			padding-left: 7px;
			margin-bottom: 10px;
		}

		section.reserva input[type=submit] {
			background: #4286f4;
			width: 200px;
			height: 30px;
			border: 0;
			cursor: pointer;
			color: white;
			font-size: 19px;
			font-weight: bold;
			margin-top: 10px;
		}

		.sucesso {
			width: 100%;
			margin: 10px 0;
			padding: 8px 15px;
			color: #3c763d;
			background: #dff0d8;
		}
</style>
<body>
	<header>
		<div class="center">
			<div class="logo">
				<h2>Barbearia</h2>
			</div>

			<nav class="menu">
				<ul>
					<li><a href="">Reservas</a></li>
				</ul>
			</nav>
			<div class="clear"></div>
		</div>
	</header>

	<section class="reserva">
		<div class="center">
			<?php
				if(isset($_POST['acao'])){
					$nome = $_POST['nome'];
					$dataHora = $_POST['data_hora'];

					$sql = $pdo->prepare("INSERT INTO tb_agendados (nome, horario) VALUES (?, ?)");
					$sql->execute(array($nome, $dataHora));

					echo '<div class="sucesso">Seu horário foi agendado com sucesso!</div>';
				}
			?>
			<form method="post">
				<input type="text" name="nome" placeholder="Seu nome...">
				<label for="data_hora">Escolha uma data e hora:</label>
				<input type="datetime-local" id="data_hora" name="data_hora">
				<input type="submit" name="acao" value="Enviar!">
			</form>
		</div>
	</section>
	<script>
    $(document).ready(function () {
        $('form').submit(function (event) {
            event.preventDefault();

            var nome = $('input[name="nome"]').val();
            var dataHora = $('#data_hora').val();

            var formattedDateTime = moment(dataHora).format('YYYY-MM-DD HH:mm:ss');

            $.ajax({
                type: 'POST',
                url: 'index.php',
                data: {
                    acao: 'inserir',
                    nome: nome,
                    data_hora: formattedDateTime
                },
                success: function (response) {
                    console.log(response);
                    alert('Seu horário foi agendado com sucesso!');
                },
                error: function (error) {
                    console.error('Erro ao enviar o formulário:', error);
                }
            });
        });
    });
</script>
</body>
</html>