<?php
// Mantém a conformidade com o requisito de Cookies
$usuarioSalvo = $_COOKIE['lembrar_usuario'] ?? '';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <nav style="text-align: center; padding: 20px; background-color: #f5f8fa; border-bottom: 1px solid #e6ecf0;">
        <a href="?p=login" style="margin: 0 15px; text-decoration: none; font-weight: bold; color: #1da1f2;">Faça Login</a>
        <a href="?p=sobre" style="margin: 0 15px; text-decoration: none; color: #657786;">Sobre o Projeto</a>
        <a href="?p=dicas" style="margin: 0 15px; text-decoration: none; color: #657786;">Dicas de Sobrevivência</a>
        <a href="?p=contato" style="margin: 0 15px; text-decoration: none; color: #657786;">Contato da Equipe</a>
    </nav>

    <main style="max-width: 400px; margin: 40px auto; text-align: center;">
        <h2>Bem-vindo!</h2>
        <p style="color: #657786;">Faça o login para acessar seu Diário e Atividades.</p>

        <form action="?p=fazer-login" method="POST" style="box-shadow: none; padding: 0;">
            
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token'] ?? ''; ?>">
            
            <div style="text-align: left; margin-bottom: 15px;">
                <label for="usuario">Usuário:</label>
                <input type="text" name="usuario" id="usuario" placeholder="Digite seu usuário" value="<?php echo htmlspecialchars($usuarioSalvo); ?>" required>
            </div>

            <div style="text-align: left; margin-bottom: 15px;">
                <label for="senha">Senha:</label>
                <input type="password" name="senha" id="senha" placeholder="Sua senha" required>
            </div>

            <div style="text-align: left; margin-bottom: 20px;">
                <label style="font-weight: normal; font-size: 14px; cursor: pointer;">
                    <input type="checkbox" name="lembrar" <?php echo $usuarioSalvo ? 'checked' : ''; ?>>
                    Lembrar meu usuário
                </label>
            </div>

            <input type="submit" value="Entrar no Sistema">
        </form>

        <hr style="border: 1px solid #e6ecf0; margin: 20px 0; display: block;">

        <div style="text-align: center; margin-top: 15px;">
            <a href="?p=cadastro" style="font-size: 14px; color: #17bf63; font-weight: bold; margin-right: 15px;">Criar uma conta</a>
            <a href="?p=recuperar" style="font-size: 14px; color: #1da1f2;">Esqueceu a senha?</a>
        </div>

    </main>

</body>
</html>