<?php

require_once __DIR__ . "/../Model/Humor.php";

class HumorController {

    public static function index() {
        if (!isset($_SESSION['id_usuario'])) { header("Location: ?p=login"); exit; }
        
        $listaHumor = Humor::listarTodos($_SESSION['id_usuario']);
        require __DIR__ . "/../View/humor.php";
    }

    public static function criar() {
        if (!isset($_SESSION['id_usuario'])) { header("Location: ?p=login"); exit; }
        
        require __DIR__ . "/../View/humor-criar.php";
    }

    public static function salvar() {
        if (!isset($_SESSION['id_usuario'])) { header("Location: ?p=login"); exit; }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nivel_estresse = $_POST['nivel_estresse'] ?? '';
            $data_registro  = $_POST['data_registro'] ?? date('Y-m-d');
            
            if (!empty($nivel_estresse)) {
                Humor::cadastrar($nivel_estresse, $data_registro, $_SESSION['id_usuario']);
                header("Location: ?p=feed");
                exit;
            }
        }
    }

    public static function editar() {
        if (!isset($_SESSION['id_usuario'])) { header("Location: ?p=login"); exit; }
        
        $id_humor = $_GET['id'] ?? $_GET['id_humor'] ?? null;
        
        if (!$id_humor) {
            die("<b>Erro de Diagnóstico:</b> O link de editar não enviou o ID do registo. Verifique o link na sua tabela.");
        }
        
        $humorAtual = Humor::buscarPorId($id_humor, $_SESSION['id_usuario']);
        
        if (!$humorAtual) {
            die("<b>Erro de Diagnóstico:</b> O registo com o ID (".$id_humor.") não foi encontrado na base de dados para o seu utilizador.");
        }
        
        require __DIR__ . "/../View/humor_editar.php"; 
        exit;
    }
    public static function atualizar() {
        if (!isset($_SESSION['id_usuario'])) { header("Location: ?p=login"); exit; }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_humor       = $_POST['id'] ?? '';
            $nivel_estresse = $_POST['nivel_estresse'] ?? '';
            $data_registro  = $_POST['data_registro'] ?? '';
            
            if (!empty($id_humor) && !empty($nivel_estresse)) {
                Humor::atualizar($id_humor, $nivel_estresse, $data_registro, $_SESSION['id_usuario']);
            }
            
            header("Location: ?p=feed");
            exit;
        }
    }

    public static function excluir() {
        if (!isset($_SESSION['id_usuario'])) { header("Location: ?p=login"); exit; }
        
        $id_humor = $_GET['id'] ?? null;
        
        if ($id_humor) {
            Humor::deletar($id_humor, $_SESSION['id_usuario']);
        }
        
        header("Location: ?p=feed");
        exit;
    }
}
?>