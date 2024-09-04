<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salvar Endereço</title>
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
            max-width: 500px;
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
</head>
<body>
    <div class="container">
        <h1>Salvar Endereço</h1>

        <?php
        // Dados de conexão ao banco de dados
        include 'include/include.php';

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $cep = trim($_POST["cep"]);
            $logradouro = trim($_POST["logradouro"]);
            $bairro = trim($_POST["bairro"]);
            $cidade = trim($_POST["cidade"]);
            $estado = trim($_POST["estado"]);
            $numero = trim($_POST["numero"]);

            // Validação dos dados recebidos
            if (empty($cep) || empty($logradouro) || empty($bairro) || empty($cidade) || empty($estado) || empty($numero)) {
                echo "<div class='message error'>Todos os campos são obrigatórios.</div>";
            } else {
                // Preparar a instrução SQL para inserção
                $stmt = $conn->prepare("INSERT INTO usuarios (cep, logradouro, bairro, cidade, estado, numero) VALUES (?, ?, ?, ?, ?, ?)");

                if ($stmt === false) {
                    echo "<div class='message error'>Erro na preparação da instrução: " . htmlspecialchars($conn->error) . "</div>";
                } else {
                    // Fazer o binding dos parâmetros
                    $stmt->bind_param("ssssss", $cep, $logradouro, $bairro, $cidade, $estado, $numero);

                    // Executar a instrução SQL
                    if ($stmt->execute()) {
                        echo "<div class='message success'>Endereço salvo com sucesso.</div>";
                    } else {
                        echo "<div class='message error'>Erro ao salvar o endereço: " . htmlspecialchars($stmt->error) . "</div>";
                    }

                    // Fechar a instrução
                    $stmt->close();
                }
            }

            // Fechar a conexão com o banco de dados
            $conn->close();
        }
        ?>

        <a href="index.php">Voltar para a página inicial</a>
    </div>
</body>
</html>
