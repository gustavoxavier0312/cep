<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de CEP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 600px;
            width: 100%;
        }
        h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
            text-align: center;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-size: 16px;
            color: #333;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }
        button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 100%;
            margin-top: 10px;
        }
        button:hover {
            background-color: #0056b3;
        }
        .message {
            margin-top: 20px;
            padding: 10px;
            border-radius: 4px;
            font-size: 16px;
            text-align: center;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
        a {
            display: block;
            margin-top: 20px;
            text-align: center;
            text-decoration: none;
            color: #007bff;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
    <script>
        function buscarCEP() {
            var cep = document.getElementById('cep').value.replace(/\D/g, '');
            if (cep !== '') {
                var validacep = /^[0-9]{8}$/;
                if (validacep.test(cep)) {
                    var script = document.createElement('script');
                    script.src = 'https://viacep.com.br/ws/' + cep + '/json/?callback=preencherEndereco';
                    document.body.appendChild(script);
                } else {
                    alert("Formato de CEP inválido.");
                }
            }
        }

        function preencherEndereco(conteudo) {
            if (!('erro' in conteudo)) {
                document.getElementById('logradouro').value = conteudo.logradouro;
                document.getElementById('bairro').value = conteudo.bairro;
                document.getElementById('cidade').value = conteudo.localidade;
                document.getElementById('estado').value = conteudo.uf;
            } else {
                alert("CEP não encontrado.");
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Consulta de CEP</h1>
        <form action="salvar_endereco.php" method="post">
            <div class="form-group">
                <label for="cep">Digite o CEP:</label>
                <input type="text" id="cep" name="cep" required pattern="\d{5}-?\d{3}" placeholder="Ex: 01001-000">
            </div>
            <button type="button" onclick="buscarCEP()">Consultar</button>
            <div class="form-group">
                <label for="logradouro">Logradouro:</label>
                <input type="text" id="logradouro" name="logradouro" readonly>
            </div>
            <div class="form-group">
                <label for="bairro">Bairro:</label>
                <input type="text" id="bairro" name="bairro" readonly>
            </div>
            <div class="form-group">
                <label for="cidade">Cidade:</label>
                <input type="text" id="cidade" name="cidade" readonly>
            </div>
            <div class="form-group">
                <label for="estado">Estado:</label>
                <input type="text" id="estado" name="estado" readonly>
            </div>
            <div class="form-group">
                <label for="numero">Número:</label>
                <input type="text" id="numero" name="numero" required>
            </div>
            <button type="submit">Salvar Endereço</button>
            <a href="index.php">Voltar para a página inicial</a>
        </form>
    </div>
</body>
</html>
