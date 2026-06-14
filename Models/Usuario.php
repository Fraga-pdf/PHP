<?php

require_once __DIR__ . "/../Config/Banco.php";

class Usuario {

    public static function cadastrar($nome, $usuario, $senha, $cpf, $data_nascimento) {
      
        $hash = password_hash($senha, PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO usuarios (nome, usuario, senha, cpf, data_nascimento) VALUES (?, ?, ?, ?, ?)";
        
        $stmt = Banco::getConn()->prepare($sql);
        
        return $stmt->execute([$nome, $usuario, $hash, $cpf, $data_nascimento]);
    }

}
?>
