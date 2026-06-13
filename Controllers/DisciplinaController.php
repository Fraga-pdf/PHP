<?php

require_once __DIR__ . "/../Model/Disciplina.php";

class DisciplinaController {

    public static function index() {
   
        if (!isset($_SESSION['id_usuario'])) {
            header("Location: ?p=login");
            exit;
        }

        $id_usuario = $_SESSION['id_usuario'];
        $listaDisciplinas = Disciplina::listarTodas($id_usuario);

        require __DIR__ . "/../View/disciplinas.php";
    }

    public static function criar() {
        if (!isset($_SESSION['id_usuario'])) {
            header("Location: ?p=login");
            exit;
        }
       
        require __DIR__ . "/../View/disciplina_criar.php";
    }

    
    public static function salvar() {
       
        if (!isset($_SESSION['id_usuario'])) {
            header("Location: ?p=login");
            exit;
        }

        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
           
            $nome = trim($_POST['nome'] ?? '');
            $carga_horaria = trim($_POST['carga_horaria'] ?? '');
            $id_usuario = $_SESSION['id_usuario']; 
            if (empty($nome) || empty($carga_horaria)) {
                header("Location: ?p=disciplina-criar");
                exit;
            }

            Disciplina::cadastrar($nome, $carga_horaria, $id_usuario);

            header("Location: ?p=disciplinas");
            exit;
        }
    }

    public static function editar() {
        if (!isset($_SESSION['id_usuario'])) {
            header("Location: ?p=login");
            exit;
        }

        $id_disciplina = $_GET['id'] ?? null;
        $id_usuario = $_SESSION['id_usuario'];

        if ($id_disciplina) {
            $disciplinaAtual = Disciplina::buscarPorId($id_disciplina, $id_usuario);
            
            if ($disciplinaAtual) {
                require __DIR__ . "/../View/disciplina_editar.php";
                return;
            }
        }
        
        header("Location: ?p=disciplinas");
        exit;
    }

    public static function atualizar() {
        if (!isset($_SESSION['id_usuario'])) {
            header("Location: ?p=login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_disciplina = $_POST['id'] ?? null;
            $nome = trim($_POST['nome'] ?? '');
            $carga_horaria = trim($_POST['carga_horaria'] ?? '');
            $id_usuario = $_SESSION['id_usuario'];

            if (!empty($id_disciplina) && !empty($nome) && !empty($carga_horaria)) {
                Disciplina::atualizar($id_disciplina, $nome, $carga_horaria, $id_usuario);
            }

            header("Location: ?p=disciplinas");
            exit;
        }
    }

    public static function excluir() {
        if (!isset($_SESSION['id_usuario'])) {
            header("Location: ?p=login");
            exit;
        }

        $id_disciplina = $_GET['id'] ?? null;
        $id_usuario = $_SESSION['id_usuario'];

        if ($id_disciplina) {
            Disciplina::deletar($id_disciplina, $id_usuario);
        }

        header("Location: ?p=disciplinas");
        exit;
    }
}
?>