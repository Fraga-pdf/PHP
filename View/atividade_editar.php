<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Atividade</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <h2>Editar Atividade</h2>
    
    <a href="?p=atividades">Cancelar</a>

    <hr>

    <form action="?p=atividade-atualizar" method="POST">
        
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

        <input type="hidden" name="id" value="<?php echo $atividadeAtual->id; ?>">

        <label for="titulo">Título da Atividade:</label><br>
        <input type="text" name="titulo" id="titulo" value="<?php echo $atividadeAtual->titulo; ?>" required><br><br>

        <label for="descricao">Descrição:</label><br>
        <textarea name="descricao" id="descricao" rows="4" cols="40"><?php echo $atividadeAtual->descricao; ?></textarea><br><br>

        <label for="data">Data de Entrega:</label><br>
        <input type="date" name="data_entrega" id="data" value="<?php echo $atividadeAtual->data_entrega; ?>" required><br><br>

        <label for="disciplina">Disciplina Associada:</label><br>
        <select name="id_disciplina" id="disciplina" required>
            <option value="">Selecione uma matéria...</option>
            <?php
        
            if (!empty($listaDisciplinas)) {
                foreach ($listaDisciplinas as $disciplina) {
                    
                    $selecionado = '';
                    if ($disciplina->id == $atividadeAtual->id_disciplina) {
                        $selecionado = 'selected';
                    }

                    echo "<option value='{$disciplina->id}' {$selecionado}>{$disciplina->nome}</option>";
                }
            }
            ?>
        </select><br><br>

        <input type="submit" value="Salvar Alterações">
    </form>

</body>
</html>