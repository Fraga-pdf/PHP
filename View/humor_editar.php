<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Registro de Humor</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <main>
        <h2>Editar Registro de Humor</h2>
        
        <form action="?p=humor-atualizar" method="POST">
            
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <input type="hidden" name="id" value="<?php echo $humorAtual->id; ?>">

            <label for="nivel_estresse">Nível de Estresse:</label>
            <select name="nivel_estresse" id="nivel_estresse" required>
                <option value="">Selecione seu estado atual...</option>
                <option value="Tranquilo" <?php if($humorAtual->nivel_estresse == 'Tranquilo') echo 'selected'; ?>>Tranquilo (Tudo sob controle)</option>
                <option value="Ansioso" <?php if($humorAtual->nivel_estresse == 'Ansioso') echo 'selected'; ?>>Ansioso (Muitos prazos chegando)</option>
                <option value="Estressado" <?php if($humorAtual->nivel_estresse == 'Estressado') echo 'selected'; ?>>Estressado (No limite da paciência)</option>
                <option value="Surtando" <?php if($humorAtual->nivel_estresse == 'Surtando') echo 'selected'; ?>>Surtando (Socorro!)</option>
                <option value="Esgotado" <?php if($humorAtual->nivel_estresse == 'Esgotado') echo 'selected'; ?>>Esgotado (Preciso de férias)</option>
            </select>

            <label for="data_registro">Data do Registro:</label>
            <input type="date" name="data_registro" id="data_registro" value="<?php echo $humorAtual->data_registro; ?>" required>

            <input type="submit" value="Salvar Alterações">
        </form>

        <br>
        <a href="?p=humor">Voltar</a>
    </main>

</body>
</html>