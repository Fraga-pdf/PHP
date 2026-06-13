<?php

require_once __DIR__ . "/../Model/Usuario.php";
require_once __DIR__ . "/../Model/Atividade.php"; 
require_once __DIR__ . "/../Model/Humor.php";     

class HomeController {

    public static function autenticar() {
        require_once __DIR__ . "/../Config/Banco.php";

        $usuario = trim($_POST['usuario'] ?? '');
        $senha = $_POST['senha'] ?? '';
        $lembrar = isset($_POST['lembrar']);

        try {
            $sql = "SELECT * FROM usuarios WHERE usuario = ? LIMIT 1";
            $stmt = Banco::getConn()->prepare($sql);
            $stmt->execute([$usuario]);
            $user = $stmt->fetch();

            if ($user && password_verify($senha, $user->senha)) {
                $_SESSION['id_usuario'] = $user->id;
                $_SESSION['nome'] = $user->nome;
                $_SESSION['usuario'] = $user->usuario;
                
                if ($lembrar) {
                    setcookie('lembrar_usuario', $usuario, time() + (86400 * 30), "/");
                } else {
                    setcookie('lembrar_usuario', '', time() - 3600, "/");
                }
                
                header("Location: ?p=feed");
                exit;
            } else {
                echo "<script>alert('Usuário ou senha incorretos!'); window.location.href='?p=login';</script>";
                exit;
            }
        } catch (\PDOException $e) {
            echo "<script>alert('Erro no banco de dados: " . addslashes($e->getMessage()) . "'); window.location.href='?p=login';</script>";
            exit;
        }
    }

    public static function fazerCadastro() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome            = trim($_POST['nome'] ?? '');
            $usuario         = trim($_POST['usuario'] ?? '');
            $senha           = $_POST['senha'] ?? '';
            $cpf             = trim($_POST['cpf'] ?? '');
            $data_nascimento = trim($_POST['data_nascimento'] ?? '');
            
            if (!empty($nome) && !empty($usuario) && !empty($senha) && !empty($cpf) && !empty($data_nascimento)) {
                require_once __DIR__ . "/../Model/Usuario.php";
                try {
                    Usuario::cadastrar($nome, $usuario, $senha, $cpf, $data_nascimento);
                    echo "<script>alert('Conta criada com sucesso!'); window.location.href='?p=login';</script>";
                    exit;
                } catch (\PDOException $e) {
                    if ($e->getCode() == 23000) {
                        echo "<script>alert('Usuário ou CPF já cadastrado.'); window.location.href='?p=cadastro';</script>";
                    } else {
                        echo "<script>alert('Erro ao cadastrar: " . addslashes($e->getMessage()) . "'); window.location.href='?p=cadastro';</script>";
                    }
                    exit;
                }
            }
        }
    }
   
    public static function cadastro() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome            = trim($_POST['nome'] ?? '');
            $usuario         = trim($_POST['usuario'] ?? '');
            $senha           = $_POST['senha'] ?? '';
            $cpf             = trim($_POST['cpf'] ?? '');
            $data_nascimento = trim($_POST['data_nascimento'] ?? '');
            
            if (!empty($nome) && !empty($usuario) && !empty($senha) && !empty($cpf) && !empty($data_nascimento)) {
                
                require_once __DIR__ . "/../Model/Usuario.php";
                
                try {
                 
                    Usuario::cadastrar($nome, $usuario, $senha, $cpf, $data_nascimento);
                    
                    echo "<script>alert('Conta criada com sucesso! Você já pode fazer o login.'); window.location.href='?p=login';</script>";
                    exit;
                    
                } catch (\PDOException $e) {
                   
                    if ($e->getCode() == 23000) {
                        echo "<script>alert('Atenção: Este usuário (nickname) ou CPF já está em uso. Por favor, escolha outro!');</script>";
                    } else {

                    echo "<script>alert('Erro no banco de dados: " . $e->getMessage() . "');</script>";
                    }
                }
            }
        }
        
        require __DIR__ . "/../View/cadastro.php";
    }
   
    public static function feed() {

    if (!isset($_SESSION['id_usuario'])) {
            header("Location: ?p=login");
            exit;
        }

        $id_usuario = $_SESSION['id_usuario'];
        
        $listaAtividades = Atividade::listarTodas($id_usuario);
        $listaHumor      = Humor::listarTodos($id_usuario);
        
        $humorAtual      = !empty($listaHumor) ? $listaHumor[0] : null;

        require __DIR__ . "/../View/feed.php";
    }

    public static function index() {
       
        if (isset($_SESSION['id_usuario'])) {
            header("Location: ?p=feed");
            exit;
        }
        header("Location: ?p=login");
        exit;
    }

    public static function login() {
      
        if (isset($_SESSION['id_usuario'])) {
            header("Location: ?p=feed");
            exit;
        }
        
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        require __DIR__ . "/../View/login.php";
    }

    public static function simularLogin() {
      
        $user = Usuario::buscarPorId(1);
        if ($user) {
            $_SESSION['id_usuario'] = $user->id;
            $_SESSION['nome']       = $user->nome;
            $_SESSION['usuario']    = $user->usuario;
           
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        header("Location: ?p=feed");
        exit;
    }

    public static function logout() {
        
        session_destroy();
        header("Location: ?p=login");
        exit;
    }

  public static function recuperar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cpf = trim($_POST['cpf'] ?? '');
            $data_nascimento = trim($_POST['data_nascimento'] ?? '');
            $nova_senha = $_POST['nova_senha'] ?? '';

            if (!empty($cpf) && !empty($data_nascimento) && !empty($nova_senha)) {
                
                $sql = "SELECT id FROM usuarios WHERE cpf = ? AND data_nascimento = ?";
                $stmt = Banco::getConn()->prepare($sql);
              
                $stmt->execute([$cpf, $data_nascimento]);
                $user = $stmt->fetch();

                if ($user) {
                    $hash = password_hash($nova_senha, PASSWORD_DEFAULT);
                    
                    $sqlUpdate = "UPDATE usuarios SET senha = ? WHERE id = ?";
                    $stmtUpdate = Banco::getConn()->prepare($sqlUpdate);
                    $stmtUpdate->execute([$hash, $user->id]);

                    echo "<script>alert('Senha alterada com sucesso!'); window.location.href='?p=login';</script>";
                    exit;
                } else {
                    echo "<script>alert('Erro de validação: CPF ou Data de Nascimento não encontrados ou incorretos.');</script>";
                }
            }
        }
        
        require __DIR__ . "/../View/recuperar.php";
    }
   
    public static function home()    { require __DIR__ . "/../View/home.php"; }
    public static function sobre()   { require __DIR__ . "/../View/sobre.php"; }
    public static function dicas()   { require __DIR__ . "/../View/dicas.php"; }
    public static function contato() { require __DIR__ . "/../View/contato.php"; }
}
?>