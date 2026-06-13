<?php

require_once __DIR__ . "/../Model/Atividade.php";
require_once __DIR__ . "/../Model/Disciplina.php";

class AtividadeController {

    public static function index() {
      
        if (!isset($_SESSION['id_usuario'])) {
            header("Location: ?p=login");
            exit; 
        }

        $id_usuario = $_SESSION['id_usuario'];
        
        $listaAtividades = Atividade::listarTodas($id_usuario);

        require __DIR__ . "/../View/atividades.php";
    }

    public static function criar() {
        
        if (!isset($_SESSION['id_usuario'])) {
            header("Location: ?p=login");
            exit;
        }

        $id_usuario = $_SESSION['id_usuario'];
        
        $listaDisciplinas = Disciplina::listarTodas($id_usuario);

        require __DIR__ . "/../View/atividade_criar.php";
    }

    public static function salvar() {
        
        if (!isset($_SESSION['id_usuario'])) {
            header("Location: ?p=login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $titulo = trim($_POST['titulo'] ?? '');
            $descricao = trim($_POST['descricao'] ?? '');
            $data_entrega = $_POST['data_entrega'] ?? '';
            $id_disciplina = $_POST['id_disciplina'] ?? '';
            $id_usuario = $_SESSION['id_usuario'];

            
            if (empty($titulo) || empty($data_entrega) || empty($id_disciplina)) {
               
                header("Location: ?p=atividade-criar");
                exit;
            }

            Atividade::cadastrar($titulo, $descricao, $data_entrega, $id_disciplina, $id_usuario);

            header("Location: ?p=atividades");
            exit;
        }
    }


    public static function editar() {
        
        if (!isset($_SESSION['id_usuario'])) {
            header("Location: ?p=login");
            exit;
        }

        $id_atividade = $_GET['id'] ?? null;
        $id_usuario = $_SESSION['id_usuario'];

        if ($id_atividade) {
            
            $atividadeAtual = Atividade::buscarPorId($id_atividade, $id_usuario);
            
            $listaDisciplinas = Disciplina::listarTodas($id_usuario);

            if ($atividadeAtual) {
                
                require __DIR__ . "/../View/atividade_editar.php";
                return;
            }
        }

        header("Location: ?p=atividades");
        exit;
    }

   
    public static function atualizar() {
       
        if (!isset($_SESSION['id_usuario'])) {
            header("Location: ?p=login");
            exit;
        }

       
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
           
            $id_atividade = $_POST['id'] ?? null;
            $titulo = trim($_POST['titulo'] ?? '');
            $descricao = trim($_POST['descricao'] ?? '');
            $data_entrega = $_POST['data_entrega'] ?? '';
            $id_disciplina = $_POST['id_disciplina'] ?? '';
            $id_usuario = $_SESSION['id_usuario'];

           
            if (!empty($id_atividade) && !empty($titulo) && !empty($data_entrega) && !empty($id_disciplina)) {
               
                Atividade::atualizar($id_atividade, $titulo, $descricao, $data_entrega, $id_disciplina, $id_usuario);
            }

            header("Location: ?p=atividades");
            exit;
        }
    }

    public static function excluir() {
       
        if (!isset($_SESSION['id_usuario'])) {
            header("Location: ?p=login");
            exit;
        }

        $id_atividade = $_GET['id'] ?? null;
        $id_usuario = $_SESSION['id_usuario'];

        if ($id_atividade) {
            Atividade::deletar($id_atividade, $id_usuario);
        }

        header("Location: ?p=atividades");
        exit;
    }
}
?>