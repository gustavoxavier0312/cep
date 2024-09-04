<!DOCTYPE html>
<html lang="pt-BR">
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
            max-width: 400px;
            width: 100%;
        }
        h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        input[type="text"] {
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .result {
            margin-top: 20px;
            font-size: 16px;
            color: #333;
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
</head>
<body>
    <div class="container">
        <h1>Consulta de CEP</h1>
        <form method="post" action="">
            <label for="cep">Digite o CEP:</label>
            <input type="text" id="cep" name="cep" placeholder="Ex: 01001000" required>
            <input type="submit" value="Buscar">
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $cep = $_POST["cep"];
            // Remover possíveis caracteres não numéricos do CEP
            $cep = preg_replace("/[^0-9]/", "", $cep);
            // Validar o formato do CEP
            if (preg_match("/^[0-9]{8}$/", $cep)) {
                // URL da API ViaCEP
                $url = "https://viacep.com.br/ws/$cep/json/";
                // Inicializar cURL
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                // Obter a resposta da API
                $response = curl_exec($ch);
                curl_close($ch);
                // Converter a resposta JSON para um array associativo
                $data = json_decode($response, true);
                // Verificar se o CEP foi encontrado
                if (isset($data['erro'])) {
                    echo '<div class="result">CEP não encontrado.</div>';
                } else {
                    // Exibir as informações de endereço
                    echo '<div class="result">';
                    echo "Endereço: " . htmlspecialchars($data['logradouro']) . "<br>";
                    echo "Bairro: " . htmlspecialchars($data['bairro']) . "<br>";
                    echo "Cidade: " . htmlspecialchars($data['localidade']) . "<br>";
                    echo "Estado: " . htmlspecialchars($data['uf']) . "<br>";
                    echo '</div>';
                }
            } else {
                echo '<div class="result">CEP inválido.</div>';
            }
        }
        ?>

        <a href="index.php">Voltar para a página inicial</a>
    </div>
</body>
</html>
