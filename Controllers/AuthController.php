<?php

class AuthController {

    public static function login() {
        require "./Views/auth/login.php";
    }

    public static function fazerLogin() {
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $emailForms = $_POST['email'] ?? null;
            $senhaForms = $_POST['senha'] ?? null;

            if (is_null($emailForms) || is_null($senhaForms)) {
               
                echo "<h3>Erro: Preencha todos os campos!</h3>";
                require "./Views/auth/login.php";
            } 
            
            else {
                
                require_once "./config/banco.php";
                global $banco; 
                
                $resp = $banco->prepare("SELECT * FROM usuarios WHERE email = ?");
                $resp->execute([$emailForms]);
                
                $objUsuario = $resp->fetch(PDO::FETCH_OBJ);
                
                
                if (!$objUsuario) {
                     
                     echo "<h3>Erro: Usuário não encontrado!</h3>";
                     require "./Views/auth/login.php";
                } 

                else {
                   
                    if (password_verify($senhaForms, $objUsuario->senha)) {
                        
                        $_SESSION['usuario_id'] = $objUsuario->id;
                        $_SESSION['usuario_nome'] = $objUsuario->nome;
                       
                        header("Location: index.php?p=dashboard");
                    } 
                  
                    else {
                        
                        echo "<h3>Erro: Senha incorreta!</h3>";
                        require "./Views/auth/login.php";
                    }
                }
            }
        }
    }

    public static function cadastro() {
        require "./Views/auth/cadastro.php";
    }
    
    public static function sair() {
        session_start();
     
        session_destroy();
     
        header("Location: index.php?p=home");
    }
}
?>