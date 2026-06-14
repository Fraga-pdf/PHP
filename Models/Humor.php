<?php

require_once __DIR__ . "/../Config/Banco.php";

class Humor {

    public static function cadastrar($nivel_estresse, $data_registro, $id_usuario) {
        $sql = "INSERT INTO humor (nivel_estresse, data_registro, id_usuario) VALUES (?, ?, ?)";
        $stmt = Banco::getConn()->prepare($sql);
        
        return $stmt->execute([$nivel_estresse, $data_registro, $id_usuario]);
    }

    public static function listarTodos($id_usuario) {

        $sql = "SELECT * FROM humor WHERE id_usuario = ? ORDER BY id DESC";
        $stmt = Banco::getConn()->prepare($sql);
        
        $stmt->execute([$id_usuario]);
        
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public static function buscarPorId($id_humor, $id_usuario) {
        $sql = "SELECT * FROM humor WHERE id = ? AND id_usuario = ? LIMIT 1";
        $stmt = Banco::getConn()->prepare($sql);
        
        $stmt->execute([$id_humor, $id_usuario]);
        
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public static function atualizar($id_humor, $nivel_estresse, $data_registro, $id_usuario) {
        $sql = "UPDATE humor SET nivel_estresse = ?, data_registro = ? WHERE id = ? AND id_usuario = ?";
        $stmt = Banco::getConn()->prepare($sql);
        
        return $stmt->execute([$nivel_estresse, $data_registro, $id_humor, $id_usuario]);
    }

    public static function deletar($id_humor, $id_usuario) {
        $sql = "DELETE FROM humor WHERE id = ? AND id_usuario = ?";
        $stmt = Banco::getConn()->prepare($sql);
        
        return $stmt->execute([$id_humor, $id_usuario]);
    }
}
?>
