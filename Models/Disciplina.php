<?php

require_once __DIR__ . "/../Config/Banco.php";

class Disciplina {

    public static function cadastrar($nome, $carga_horaria, $id_usuario) {
        $sql = "INSERT INTO disciplinas (nome, carga_horaria, id_usuario) VALUES (?, ?, ?)";
        $stmt = Banco::getConn()->prepare($sql);
        
        return $stmt->execute([$nome, $carga_horaria, $id_usuario]);
    }

    public static function listarTodas($id_usuario) {
        $sql = "SELECT * FROM disciplinas WHERE id_usuario = ?";
        $stmt = Banco::getConn()->prepare($sql);
        
        $stmt->execute([$id_usuario]);
        
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public static function buscarPorId($id_disciplina, $id_usuario) {
        $sql = "SELECT * FROM disciplinas WHERE id = ? AND id_usuario = ? LIMIT 1";
        $stmt = Banco::getConn()->prepare($sql);
        
        $stmt->execute([$id_disciplina, $id_usuario]);
        
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public static function atualizar($id_disciplina, $nome, $carga_horaria, $id_usuario) {
        $sql = "UPDATE disciplinas SET nome = ?, carga_horaria = ? WHERE id = ? AND id_usuario = ?";
        $stmt = Banco::getConn()->prepare($sql);
        
        return $stmt->execute([$nome, $carga_horaria, $id_disciplina, $id_usuario]);
    }

    public static function deletar($id_disciplina, $id_usuario) {
        $sql = "DELETE FROM disciplinas WHERE id = ? AND id_usuario = ?";
        $stmt = Banco::getConn()->prepare($sql);
        
        return $stmt->execute([$id_disciplina, $id_usuario]);
    }
}
?>
