<?php

session_start();

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

require_once __DIR__ . "/config/Banco.php";
require_once __DIR__ . "/Controllers/HomeController.php";
require_once __DIR__ . "/Controllers/DisciplinaController.php";
require_once __DIR__ . "/Controllers/AtividadeController.php";
require_once __DIR__ . "/Controllers/HumorController.php";

$url = $_GET['p'] ?? 'home';

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$p = $_GET['p'] ?? 'home';

$rotasLivres = ['login', 'cadastro', 'recuperar', 'autenticar', 'home', 'sobre', 'dicas', 'contato'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !in_array($p, $rotasLivres)) {
    $tokenEnviado = $_POST['csrf_token'] ?? '';
    if (empty($tokenEnviado) || $tokenEnviado !== $_SESSION['csrf_token']) {
        die("Erro de segurança grave: Token CSRF inválido ou ausente.");
    }
}

switch ($url) {
    
    case 'login':
        HomeController::login();
        break;
        
    case 'fazer-login':
        HomeController::autenticar();
        break;
        
    case 'sair':
        HomeController::logout();
        break;

    case 'cadastro':
        HomeController::cadastro();
        break;

    case 'fazer-cadastro':
        HomeController::fazerCadastro();
        break;

    case 'feed':

        require_once __DIR__ . "/View/feed.php";
        break;
        
    case 'disciplinas':
        DisciplinaController::index();
        break;
        
    case 'disciplina-criar':
        DisciplinaController::criar();
        break;
        
    case 'disciplina-salvar':
        DisciplinaController::salvar();
        break;
        
    case 'disciplina-editar':
        DisciplinaController::editar();
        break;
        
    case 'disciplina-atualizar':
        DisciplinaController::atualizar();
        break;
        
    case 'disciplina-excluir':
        DisciplinaController::excluir();
        break; 
    
    case 'atividades':

        AtividadeController::index();
        break;
        
    case 'atividade-criar':
        
        AtividadeController::criar();
        break;
        
    case 'atividade-salvar':
    
        AtividadeController::salvar();
        break;
        
    case 'atividade-editar':
        
        AtividadeController::editar();
        break;
        
    case 'atividade-atualizar':

        AtividadeController::atualizar();
        break;
        
    case 'atividade-excluir':
    
        AtividadeController::excluir();
        break;
    
    case 'humor':
      
        HumorController::index();
        break;
        
    case 'humor-criar':
       
        HumorController::criar();
        break;
        
    case 'humor-salvar':
   
        HumorController::salvar();
        break;
        
    case 'humor-editar':
       
        HumorController::editar();
        break;
        
    case 'humor-atualizar':
      
        HumorController::atualizar();
        break;
        
    case 'humor-excluir':
      
        HumorController::excluir();
        break;

    case 'logout':
        HomeController::logout();
        break;
    
    case 'home':
        HomeController::home();
        break;
    case 'sobre':
        HomeController::sobre();
        break;
    case 'dicas':
        HomeController::dicas();
        break;
    case 'contato':
        HomeController::contato();
        break;

    case 'recuperar':
        HomeController::recuperar();
        break;

    default:
       
        HomeController::index();
        break;

}
?>