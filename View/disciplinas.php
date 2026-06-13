<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Minhas Disciplinas</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <header>
        <h2>Gerenciar Disciplinas</h2>
        
        <a href="?p=feed">Voltar</a> | 
        
        <a href="?p=disciplina-criar" style="font-weight: bold; color: green;">+ Nova Disciplina</a>
    </header>

    <hr>

    <main>
        <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; text-align: left;">
            
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome da Disciplina</th>
                    <th>Carga Horária</th>
                    <th>Ações (Editar / Excluir)</th>
                </tr>
            </thead>
            
            <tbody>
                <?php
            
                if (empty($listaDisciplinas)) {
                    
                    echo "<tr><td colspan='4'>Nenhuma disciplina cadastrada ainda. Comece adicionando uma!</td></tr>";
                } else {
                  
                    foreach ($listaDisciplinas as $disciplina) {
                ?>
                        <tr>
                            <td><?php echo $disciplina->id; ?></td>
                            <td><?php echo $disciplina->nome; ?></td>
                            <td><?php echo $disciplina->carga_horaria; ?>h</td>
                            
                            <td>
                                <a href="?p=disciplina-editar&id=<?php echo $disciplina->id; ?>">Editar</a> | 

                                <a href="?p=disciplina-excluir&id=<?php echo $disciplina->id; ?>" 
                                   style="color: red;"
                                   onclick="return confirm('Tem certeza que deseja excluir esta disciplina?');">
                                   Excluir
                                </a>
                            </td>
                        </tr>
                <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </main>

</body>
</html>