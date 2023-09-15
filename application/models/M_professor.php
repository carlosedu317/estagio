<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once ("M_aluno.php");
include_once ("M_curso.php");
include_once ("M_professor.php");

class M_professor extends CI_Model{
    public function inserirProfessor($nome,$usuario,$senha,$estatus){
        
        $sql= "insert into professor (nome, usuario, senha, estatus) values('$nome','$usuario','$senha','$estatus')";
        $this->db->query($sql);

        if($this->db->affected_rows()>0){
            $dados = array('codigo' => 1, 'msg' => 'professor cadastrado corretamente');
        }else{
            $dados = array('codigo' => 2, 'msg' => 'Houve algum problema na inserção na tabela professor');
        }

        return $dados;
    }
    
    public function consuntarSoProfessor($idprofessor){
        $sql = "select * from professor where id_professor = '$idprofessor'";

        $retorno = $this->db->query($sql);

        if($retorno->num_rows()>0){
            $dados = array('codigo'=> 1, 'msg' => 'consulta efetuada com sucesso');

        }else{
            $dados = array('codigo' => 2, 'msg' => 'dados nao encontrados');
        }
        return $dados;
    }

    public function consultarUsuario($usuario, $senha){
        $sql = "select * from professor where usuario = '$usuario' and senha = '$senha'";

        $retorno = $this->db->query($sql);
    
        if($retorno->num_rows()>0){
        $dados = array('codigo'=> 1, 'msg' => 'consulta efetuada com sucesso');

        }else{
        $dados = array('codigo' => 2, 'msg' => 'dados nao encontrados');

        }

         return $dados;

    }
}
   