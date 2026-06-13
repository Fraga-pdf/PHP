<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Minhas Atividades</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <main>
        <h2>Minhas Atividades</h2>
        
        <nav style="margin-bottom: 20px;">
            <a href="?p=feed">Voltar</a> | 
            <a href="?p=atividade-criar" style="color: #17bf63;">Nova Atividade</a>
        </nav>

        <table>
            <thead>
                <tr>
                    <th>Disciplina</th>
                    <th>O que precisa ser feito?</th>
                    <th>Prazo Final</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                
                if (empty($listaAtividades)) {
                    echo "<tr><td colspan='4'>Você não tem nenhuma atividade cadastrada.</td></tr>";
                } else {
                    
                    foreach ($listaAtividades as $ativ) {
                ?>
                        <tr>
                            <td><strong><?php echo $ativ->disciplina_nome ?? 'Sem Disciplina'; ?></strong></td>
                            
                            <td><?php echo $ativ->titulo; ?></td>
                            
                            <td style="color: #e0245e; font-weight: bold;">
                                <?php echo date('d/m/Y', strtotime($ativ->data_entrega)); ?>
                            </td>
                            
                            <td>
                                <a href="?p=atividade-editar&id=<?php echo $ativ->id; ?>">Editar</a> | 
                                
                                <a href="?p=atividade-excluir&id=<?php echo $ativ->id; ?>" 
                                   style="color: red;"
                                   onclick="return confirm('Tem a certeza de que deseja apagar esta atividade?');">
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