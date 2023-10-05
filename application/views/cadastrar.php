<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Comaptible" content="IE=edge" />

    <link rel="stylesheet" href="<?php echo base_url("assets/css/bootstrap.min.css"); ?>" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url("assets/css/swetalert2.min.css"); ?>" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url("assets/css/style.css"); ?>" type="text/css" />
    <title>Cadastro de professor</title>
</head>
<body>
<div class="container-fluid d-flex aling-items center justify-content-center">
    <div class="content bg-light">
    <h1 style="text-align:center;" >Cadastro de Professor</h1>
    <form id="cadastroForm">
        <label for="nome">Nome:</label>
        <input class="form-control bg-primary text-light" placeholder="Digite seu nome" type="text" id="nome" name="nome" required><br><br>

        <label for="usuario">Usuário:</label>
        <input  class="form-control bg-primary text-light" placeholder="crie seu Usuario" type="text" id="usuario" name="usuario" required><br><br>

        <label for="senha">Senha:</label>
        <input class="form-control bg-primary text-light" placeholder="crie sua senha" type="password" id="senha" name="senha" required><br><br>

        <label for="status">Status:</label>
        <select id="status" name="status">
            <option value="ativo">Ativo</option>
            <option value="desativado">Desativado</option>
        </select><br><br>

        
        <input type="submit" value="Cadastrar" style="width:900px;" >
    </form>
    </div>
    </div>
    <script>
    document.getElementById("cadastroForm").addEventListener("submit", function(e) {
        e.preventDefault();
        
        const nome = document.getElementById("nome").value;
        const usuario = document.getElementById("usuario").value;
        const senha = document.getElementById("senha").value;
        const status = document.getElementById("status").value;
const estatus = (status === 'desativado') ? 'D' : ''; // Mapeia 'desativado' para 'D' e qualquer outra coisa para vazio ('')
const data = {
    nome: nome,
    usuario: usuario,
    senha: senha,
    estatus: estatus


        };
        
        // Enviar os dados para a API usando AJAX
        fetch('http://localhost/estagio/professor/inserirProfessor',{
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        })
        .then(response => response.json())
        .then(result => {
            if (result.codigo === 1) {
                alert('Cadastro efetuado com sucesso!');

                window.location.href = '<?= base_url('funcoes/login') ?>';
            } else {
                // Exiba uma mensagem de erro
                alert('Erro ao cadastrar usuário: ' + result.msg);
            }
        })
        .catch(error => {
            // Trate erros de conexão
            console.error('Erro na solicitação AJAX: ' + error);
        });
    });
</script>

</body>
</html>
