<?php

class DashboardController {

    public static function index() {
        
        if (!isset($_SESSION['usuario_id'])) {
            
            header("Location: index.php?p=login");
            
            exit;
        }

        $nome_usuario = $_SESSION['usuario_nome'];

        require "./Views/dashboard/index.php";
    }
}
?>