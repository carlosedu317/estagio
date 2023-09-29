<?php

defined('BASEPATH') or exit('No direct script access allowed');

include_once("M_curso.php");
include_once("M_professor.php");

class M_aluno extends CI_Model
{
    public function inserirAluno($ra, $idcurso, $nome, $estatus)
    {
        $curso = new M_curso();

        $retornoCurso = $curso->consultarSoCurso($idcurso);

        if ($retornoCurso['codigo'] == 1) {

            $retornoAluno = $this->consultarSoAluno($ra);

            if ($retornoAluno['codigo'] == 2) {

                $sql = "insert into aluno (ra, id_curso, nome, estatus) values ('$ra', '$idcurso','$nome','$estatus')";

                $this->db->query($sql);

                if ($this->db->affected_rows() > 0) {
                    $dados = array('codigo' => 1, 'msg' => 'aluno cadastrado corretamente');
                } else {
                    $dados = array('codigo' => 2, 'msg' => 'houve umm problema na inserçao na tabela de aluno');
                }
            } else {
                $dados = array('codigo' => 8, 'msg' => 'aluno ja se encontra na base de dados');
            }
        } else {
            $dados = array('codigo' => 7, 'msg' => 'curso informado nao cadastrado na base de dados');
        }

        return $dados;
    }

    public function consultarAluno($ra, $idcurso, $nome, $estatus)
    {

        $sql = "select * from aluno where estatus = '$estatus' ";

        if (($ra) != '') {
            $sql = $sql . "and ra = '$ra'";
        }

        if (trim($idcurso) != '' && trim($idcurso) != 0) {
            $sql = $sql . "and id_curso = '$idcurso'";
        }

        if (trim((string)$nome) > 0) {
            $sql = $sql . "and nome like '%$nome%'";
        }

        $retorno = $this->db->query($sql);

        if ($retorno->num_rows() > 0) {
            $dados = array('codigo' => 1, 'msg' => 'consulta efetuada com sucesso', 'dados' => $retorno->result());
        } else {
            $dados = array('codigo' => 2, 'msg' => 'dados nao encontrados');
        }

        return $dados;
    }

    public function consultarSoAluno($ra)
    {

        $sql = "select * from aluno where ra = '$ra'";

        $retorno = $this->db->query($sql);

        if ($retorno->num_rows() > 0) {
            $dados = array('codigo' => 1, 'msg' => 'consulta efetuada com sucesso');
        } else {
            $dados = array('codigo' => 2, 'msg' => 'dados nao encontrados');
        }

        return $dados;
    }

    public function alterarAluno($ra, $idcurso, $nome)
    {

        if (!empty($idcurso)) {

            $sql = "SELECT id_curso FROM curso WHERE id_curso = '$idcurso'";

            $resultCurso = $this->db->query($sql);

            if ($resultCurso->num_rows() === 0) {

                $dados = array('codigo' => 5, 'msg' => 'O ID do curso passado não está cadastrado na base de dados');
            }
        }

        $retornoAluno = $this->consultarSoAluno($ra);

        if ($retornoAluno['codigo'] == 1) {

            $sql = "UPDATE aluno SET ";


            if (!empty($nome)) {

                $sql .= "nome = '$nome', ";
            }

            if (!empty($idcurso)) {

                $sql .= "id_curso = $idcurso, ";
            }

            $sql = rtrim($sql, ', ');

            $sql .= " WHERE ra = '$ra'";

            $this->db->query($sql);


            if ($this->db->affected_rows() > 0) {

                $dados = array('codigo' => 1, 'msg' => 'Dados do aluno atualizados corretamente');
            } else {

                $dados = array('codigo' => 2, 'msg' => 'Houve algum problema na atualização do aluno.');
            }
        } else {

            $dados = array('codigo' => 6, 'msg' => 'O RA informado não está cadastrado na base de dados');
        }

        return $dados;
    }
    public function apagarAluno($ra, $usuario, $senha)
    {

        $professor = new M_professor();

        $retornoProfessor = $professor->loginProf($usuario, $senha);

        if ($retornoProfessor['codigo'] == 1) {

            $retornoAluno = $this->consultarSoAluno($ra);

            if ($retornoAluno['codigo'] == 1) {

                $sql = "update aluno set estatus = 'D' where ra = $ra";

                $this->db->query($sql);

                if ($this->db->affected_rows() > 0) {
                    $dados = array('codigo' => 1, 'msg' => 'aluno desativado corretamente');
                } else {
                    $dados = array('codigo' => 2, 'msg' => 'houve um problema na desativacao do aluno');
                }
            } else {
                $dados = array('codigo' => 4, 'msg' => 'o ra informado nao esta na base de dados');
            }
        } else {

            $dados = array('codigo' => 0, 'msg' => 'login nao esta no sistema');
        }

        return $dados;
    }

    public function reativarAluno($ra)
    {

        $retornoAluno = $this->consultarSoAluno($ra);

        if ($retornoAluno['codigo'] == 1) {

            $sql = "update aluno set estatus = '' where ra = $ra";

            $this->db->query($sql);

            if ($this->db->affected_rows() > 0) {
                $dados = array('codigo' => 1, 'msg' => 'aluno reativado corretamente');
            } else {
                $dados = array('codigo' => 2, 'msg' => 'houve um problema na reativacao do aluno');
            }
        } else {
            $dados = array('codigo' => 4, 'msg' => 'o ra informado nao esta na base de dados');
        }

        return $dados;
    }
}
