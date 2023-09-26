<?php
defined('BASEPATH') or exit('No direct script access allowed');
include_once("M_aluno.php");
include_once("M_professor.php");
include_once("M_atendimento.php");

class M_atendimento extends CI_Model
{
    public function atendimento($ra, $idprofessor, $dataAt, $horaAt, $descricao, $estatus)
    {
        $aluno = new M_aluno();

        $retornoAluno = $aluno->consultarSoAluno($ra);

        if ($retornoAluno['codigo'] == 1) {

            $professor = new M_professor();

            $retornoProfessor = $professor->consultarSoProfessor($idprofessor);

            if ($retornoProfessor['codigo'] == 1) {

                $sql = "INSERT INTO atendimento (ra, id_professor, data_atendimento, hora_atendimento, descricao, estatus) VALUES ('$ra', $idprofessor, '$dataAt', '$horaAt', '$descricao', '$estatus' ) ";

                $this->db->query($sql);

                if ($this->db->affected_rows() > 0) {
                    $dados = array('codigo' => 1, 'msg' => 'Atendimento registrado com sucesso.');
                } else {

                    $dados = array('codigo' => 2, 'msg' => 'Houve algum problema no atendimento');
                }
            } else {
                $dados = array('codigo' => 3, 'msg' => 'Professor não existente no banco de dados.');
            }
        } else {
            $dados = array('codigo' => 4, 'msg' => 'Aluno não existente na banco de dados.');
        }
        return $dados;
    }

    public function consultaAtendimento($codigo, $ra, $idprofessor, $dataAt, $horaAt, $descricao, $estatus)
    {
        $sql = "SELECT * FROM atendimento WHERE estatus = '$estatus'";
        if (trim($codigo) != '') {
            $sql = $sql . " AND codigo_atendimento = '$codigo'";
        }
        if (trim($ra) != '') {
            $sql = $sql . " AND ra = '$ra'";
        }
        if (!empty($idProfessor)) {
            $sql = $sql . " AND id_professor = '$idprofessor'";
        }
        if ($dataAt != '') {
            $sql = $sql . " AND data_atendimento = '$dataAt'";
        }
        if ($horaAt != '') {
            $sql = $sql . " AND hora_atendimento = '$horaAt'";
        }
        if (trim($descricao) != '') {
            $sql = $sql . " AND descricao = '$descricao'";
        }
        $retorno = $this->db->query($sql);
        if ($retorno->num_rows() > 0) {
            $dados = array('codigo' => 1, 'msg' => 'Consulta efetuada com sucesso', 'dados' => $retorno->result());
        } else {
            $dados = array('codigo' => 2, 'msg' => 'Dados não encontrados');
        }
        return $dados;
    }

    public function consultaSoAtendimento($codigo)
    {
        $sql = "SELECT * FROM atendimento WHERE cod_atendimento = $codigo";
        $retorno = $this->db->query($sql);
        if ($retorno->num_rows() > 0) {
            $dados = array('codigo' => 1, 'msg' => 'Consulta efetuada com sucesso');
        } else {
            $dados = array('codigo' => 2, 'msg' => 'Dados não encontrados');
        }
        return $dados;
    }

    public function alteraAtendimento($codigo, $ra, $idprofessor, $dataAt, $horaAt, $descricao)
    {
        $retornoAT = $this->consultaSoAtendimento($codigo);

        if ($retornoAT['codigo'] == 1) {

            $aluno = new M_aluno();

            $retornoAluno = $aluno->consultarSoAluno($ra);

            if ($retornoAluno['codigo'] == 1) {

                $professor = new M_professor();

                $retornoProfessor =
                    $professor->consultarSoProfessor($idprofessor);

                if ($retornoProfessor['codigo'] == 1) {
                    $sql = "UPDATE atendimento SET ";

                    if (!empty($ra)) {
                        $sql .= "ra = '$ra', ";
                    }
                    if (!empty($idprofessor)) {
                        $sql .= "id_professor = '$idprofessor', ";
                    }
                    if (!empty($dataAt)) {
                        $sql .= "data_atendimento = '$dataAt', ";
                    }
                    if (!empty($horaAt)) {
                        $sql .= "hora_atendimento = '$horaAt', ";
                    }
                    if (!empty($descricao)) {
                        $sql .= "descricao = '$descricao', ";
                    }

                    $sql = rtrim($sql, ', ');

                    $sql .= " WHERE cod_atendimento = $codigo";
                    $this->db->query($sql);

                    if ($this->db->affected_rows() > 0) {
                        $dados = array('codigo' => 1, 'msg' => 'Dados da tabela atendimento atualizados corretamente');
                    } else {
                        $dados = array('codigo' => 2, 'msg' => 'Houve algum problema na atualização do atendimento');
                    }
                } else {
                    $dados = array('codigo' => 4, 'msg' => 'Professor não está na base de dados.');
                }
            } else {
                $dados = array('codigo' => 5, 'msg' => 'Aluno não está na base de dados.');
            }
        } else {
            $dados = array('codigo' => 6, 'msg' => 'Código de atendimento não está na base de dados');
        }
        return $dados;
    }


    public function apagaAtendimento($codigo)
    {
        $retornoAtendimento = $this->consultaSoAtendimento($codigo);

        if ($retornoAtendimento['codigo'] == 1) {
            $sql = "UPDATE atendimento SET estatus = 'D' WHERE cod_atendimento = $codigo";

            $this->db->query($sql);

            if ($this->db->affected_rows() > 0) {
                $dados = array('codigo' => 1, 'msg' => 'Atendimento apagado com sucesso');
            } else {
                $dados = array('codigo' => 2, 'msg' => 'Houve algum problema ao concluir o atendimento, tente novamente.');
            }
        } else {
            $dados = array('codigo' => 4, 'msg' => 'Atendimento não registrado no nosso banco de dados');
        }
        return $dados;
    }

    public function ativaAtendimento($codigo)
    {
        $retornoAtendimento = $this->consultaSoAtendimento($codigo);
        if ($retornoAtendimento['codigo'] == 1) {
            $sql = "UPDATE atendimento SET estatus = '' WHERE cod_atendimento = $codigo";

            $this->db->query($sql);
            if ($this->db->affected_rows() > 0) {
                $dados = array('codigo' => 1, 'msg' => 'Atendimento reativado com sucesso');
            } else {
                $dados = array('codigo' => 2, 'msg' => 'Houve algum problema ao reativar o atendimento');
            }
        } else {
            $dados = array('codigo' => 4, 'msg' => 'O código de atendimento informado não está na base de dados.');
        }
        return $dados;
    }
}
