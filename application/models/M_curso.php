<?php
defined('BASEPATH') or exit('No direct script access allowed');
include_once ("M_professor.php");

class M_curso extends CI_Model
{
    public function inserirCurso($descricao, $estatus)
    {
 
        $sql = "INSERT INTO curso (descricao, estatus) VALUES ('$descricao', '$estatus')";

        $this->db->query($sql);

        if ($this->db->affected_rows() > 0) {
            $dados = array('codigo' => 1, 'msg' => 'Curso cadastrado corretamente');
        } else {
            $dados = array('codigo' => 2, 'msg' => 'Houve algum problema na inserção na tabela curso');
        }
    
        return $dados;
    }

    public function consultarCurso($idcurso, $descricao, $estatus)
    {
        $sql = "SELECT * FROM curso WHERE estatus = '$estatus'";

        if ($idcurso != "" && $idcurso != 0) {
            $sql .= " AND id_curso = '$idcurso'";
        }

        if (trim($descricao) != '') {
            $sql .= " AND descricao LIKE '%$descricao%'";
        }

        $retorno = $this->db->query($sql);

        if ($estatus == 'D') {
            $dados = array('codigo' => 8, 'msg' => 'Esse curso está desativado.', 'dados' => $retorno->result());
        } elseif ($retorno->num_rows() > 0) {
            $dados = array('codigo' => 1, 'msg' => 'Consulta efetuada com sucesso.', 'dados' => $retorno->result());
        } else {
            $dados = array('codigo' => 2, 'msg' => 'Dados não encontrados');
        }

        return $dados;
    }

    public function consultarSoCurso($idcurso)
    {
        $sql = "SELECT * FROM curso WHERE id_curso = '$idcurso'";
        $retorno = $this->db->query($sql);

        if ($retorno->num_rows() > 0) {
            $dados = array('codigo' => 1, 'msg' => 'Consulta efetuada com sucesso.');
        } else {
            $dados = array('codigo' => 2, 'msg' => 'Dados não encontrados');
        }

        return $dados;
    }

    public function alterarCurso($idcurso, $descricao)
    {
        $retornoCurso = $this->consultarSoCurso($idcurso);

        if ($retornoCurso['codigo'] == 1) {
            $sql = "UPDATE curso SET descricao = '$descricao' WHERE id_curso = '$idcurso'";
            $this->db->query($sql);

            if ($this->db->affected_rows() > 0) {
                $dados = array('codigo' => 1, 'msg' => 'Descrição do curso atualizada com sucesso.');
            } else {
                $dados = array('codigo' => 2, 'msg' => 'Houve algum problema na atualização da descrição do curso.');
            }
        } else {
            $dados = array('codigo' => 5, 'msg' => 'O ID do curso não está na base de dados');
        }

        return $dados;
    }

    public function apagarCurso($idcurso,$usuario,$senha)
    {
        $professor = new M_professor();
      
        $retornoProfessor = $professor->loginProf($usuario, $senha);

        if($retornoProfessor['codigo']==1){
            
            $retornoCurso = $this->consultarSoCurso($idcurso);

            if ($retornoCurso['codigo'] == 1){
                $sql = "SELECT * FROM curso WHERE id_curso = '$idcurso' AND estatus = 'D'";                

                $retorno = $this->db->query($sql);

                if ($retorno->num_rows() > 0) {
                    $dados = array('codigo' => 7, 'msg' => 'Curso já foi apagado');
                } else {
                    $sql = "UPDATE curso SET estatus ='D' WHERE id_curso = $idcurso"; 
                    $this->db->query($sql);

                    if($this->db->affected_rows() > 0){
                        $dados = array('codigo' => 1, 'msg' => 'Curso desativado com sucesso');
                    }else{
                        $dados = array('codigo' => 2, 'msg' => 'Houve um problema na desativação do curso');
                    }               
                }
            }else{

                $dados = array('codigo' => 88, 'msg' => 'O curso não existe');                
            }            
        }else{
            $dados = array('codigo' => 5, 'msg' => 'O ID do curso passado não está na base de dados');
        
        }

    return $dados;
    }
    public function ativarCurso($idcurso){
        $retornoCurso = $this->consultarSoCurso($idcurso);

        if($retornoCurso['codigo']==1){

            
            $sql = "update curso set estatus = '' where id_curso = $idcurso";

            $this->db->query($sql);

            if($this->db->affected_rows()>0){
                $dados = array ('codigo' => 1, 'msg' => 'curso reativado corretamente' );
            
            }else{
                $dados = array('codigo' => 2, 'msg' => 'houve um problema na reativacao do curso');
            }
        }else{
            $dados = array('codigo' => 4, 'msg' => 'o id informado nao esta na base de dados');
        }

        return $dados;

    }
    
}

?>
