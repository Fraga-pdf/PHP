<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Meu Diário</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <main>
        <h2>Histórico do Diário de Estresse</h2>
        
        <nav style="margin-bottom: 20px;">
            <a href="?p=feed">Voltar</a> | 
            <a href="?p=humor-criar" style="color: #1da1f2;">Registrar humor</a>
        </nav>

        <table>
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Nível de Estresse</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                
                if (empty($listaHumor)): 
                ?>
                    <tr><td colspan="3">Nenhum registro encontrado. Comece a monitorar seu estresse!</td></tr>
                <?php else: ?>
                    <?php 
        
                    foreach ($listaHumor as $h): 
                    ?>
                        <tr>
                            <td><?php echo date('d/m/Y', strtotime($h->data_registro)); ?></td>
                            <td><strong><?php echo $h->nivel_estresse; ?></strong></td>
                            <td>
                                <a href="?p=humor-editar&id=<?php echo $h->id; ?>" style="color: #1da1f2; text-decoration: none; margin-right: 15px;"> Editar</a>
                                <a href="?p=humor-excluir&id=<?php echo $h->id; ?>" onclick="return confirm('Tem certeza que deseja apagar este registro?');" style="color: #e0245e; text-decoration: none;">Excluir</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </main>

</body>
</html>