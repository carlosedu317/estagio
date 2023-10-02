<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Comaptible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, 
    initial-scale=1.0">

    <link rel="stylesheet" href="<?php echo base_url("assets/css/bootstrap.min.css"); ?>" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url("assets/css/swetalert2.min.css"); ?>" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url("assets/css/style.css"); ?>" type="text/css" />
    <title>login - Sistema de Estagio</title>
</head>

<body class="h-100 bg-primary">
    <div class="container-fluid d-flex aling-items center justify-content-center">
        <div class="content bg-light">
            <h1 class="text-center"> Acesso ao sistema</h1>
            <form method="post">
                <div class="form-group mb-4">
                    <label for="loginTxt" class="control-lanbel">Usuario:</label>
                    <input class="form-control bg-primary text-light" placeholder="Digite seu usuario" name="loginTxt" id="loginTxt" maxlength="15" />
                </div>
                <div class="form-group mb-4">
                    <label for="senhaTxt" class="control-label">Senha:</label>
                    <input type="password" class="form-control bg-primary text-light" placeholder="Digite sua senha" name="senhaTxt" id="senhaTxt" maxlength="20">
                </div>
                <div class="row m-0 p-0">
                    <button type="button" id="loginBtn" class="btn btn-sucsess btn-block">
                        ACESSAR
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
<script src="<?php echo base_url("assets/js/jquery-3.6.0.min.js"); ?>" type="text/javascript"></script>
<script src="<?php echo base_url("assets/js/sweetalert2.all.min.js"); ?>" type="text/javascript"></script>
<script src="<?php echo base_url("assets/js/bootstrap.min.js"); ?>" type="text/javascript"></script>


<script type="text/javascript" charset="utf-8">
    var base_url = "<?= base_url(); ?>"
    $(document).ready(function() {
    $('#loginBtn').on('click', async function(e) {
        e.preventDefault();

        const config = {
            method: "post",
            headers: {
                'Accept': 'application/json',
                'content-Type': 'application/json'
            },
            body: JSON.stringify({
                usuario : $('#loginTxt').val(),
                senha   : $('#senhaTxt').val()
            })
        };

        const request = await fetch(base_url + 'professor/loginProf', config);
        const response = await request.json();

        if (response.codigo == 1) {

            Swal.fire({
                title: 'Acesso liberado',
                text: 'bem-vindo ao Sistema de Estagio',
                icon: 'sucess'
            });
        } else {
            Swal.fire({
                title: 'Atençao!',
                text: response.codigo + ' - ' + response.msg,
                icon: 'error'
            });
        }
    });
    });
</script>
</body>
</html>