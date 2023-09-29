<?php
defined('BASEPATH') or exit('No direct script access allowed');

include_once("M_aluno.php");
include_once("M_curso.php");
include_once("M_professor.php");

class M_professor extends CI_Model
{
    public function inserirProfessor($nome, $usuario, $senha, $estatus)
    {
        $sql = "insert into professor (nome, usuario, senha, estatus) values ('$nome','$usuario','$senha', '$estatus')";



        $this->db->query($sql);

        if ($this->db->affected_rows() > 0) {


            $dados = array('codigo' => 1, 'msg' => 'Professor cadastrado corretamente.');
        } else {



            $dados = array('codigo' => 2, 'msg' => 'Houve algum problema na inserção dos dados');
        }

        return $dados;
    }

    public function consultarProfessor($idprofesor, $nome, $usuario, $senha, $estatus)
    {
        $sql = "select * from Professor where estatus = '$estatus'";

        if (($idprofesor) != '') {
            $sql = $sql . "and idprofesor = '$idprofesor'";
        }

        if (trim($nome)) {
            $sql = $sql . " and nome = '%$nome%'";
        }
        if (trim($usuario)) {
            $sql = $sql . "and usuario = '%$usuario%'";
        }
        if (trim($senha)) {
            $sql = $sql . "and senha = '$senha'";
        }

        $retorno = $this->db->query($sql);

        if ($retorno->num_rows() > 0) {
            $dados = array('codigo' => 1, 'msg' => 'consulta efetuada com sucesso', 'dados' => $retorno->result());
        } else {
            $dados = array('codigo' => 2, 'msg' => 'dados nao encontrados');
        }
        return $dados;
    }

    public function consultarCursoProf($idcurso, $idprofessor, $estatus)
    {
        $sql = "SELECT * FROM cursoprof WHERE estatus = '$estatus'";

        if (!empty($idprofessor)) {
            $sql .= " AND id_professor = '$idprofessor'";
        }

        if (!empty($idcurso)) {
            $sql .= " AND id_curso = '$idcurso'";
        }

        $retorno = $this->db->query($sql);

        if ($retorno->num_rows() > 0) {
            $dados = array('codigo' => 1, 'msg' => 'Consulta efetuada com sucesso', 'dados' => $retorno->result());
        } else {
            $dados = array('codigo' => 2, 'msg' => 'Dados não encontrados');
        }

        return $dados;
    }

    public function consultarSoProfessor($idprofessor)
    {
        $sql = "select * from professor where id_professor = '$idprofessor'";

        $retorno = $this->db->query($sql);

        if ($retorno->num_rows() > 0) {
            $dados = array('codigo' => 1, 'msg' => 'consulta efetuada com sucesso');
        } else {
            $dados = array('codigo' => 2, 'msg' => 'dados nao encontrados');
        }

        return $dados;
    }
    public function consultarUsuario($usuario, $senha, $estatus)

    {

        $sql = "SELECT *FROM professor WHERE estatus = '$estatus'";
        if (trim($usuario)) {
            $sql .= " AND usuario LIKE '%$usuario%'";
        }

        if (trim($senha)) {
            $sql .= " AND senha LIKE '$senha'";
        }

        $retorno = $this->db->query($sql);

        if ($retorno->num_rows() > 0) {
            $dados = array('codigo' => 1, 'msg' => 'Consulta efetuada com sucesso', 'dados' => $retorno->result());
        } else {
            $dados = array('codigo' => 2, 'msg' => 'Dados não encontrados');
        }
        return $dados;
    }

    public function loginProf($usuario, $senha)
    {
        $retornoUsuario = $this->consultarSoUsuarioDesativado($usuario, $senha);

        if ($retornoUsuario['codigo'] == 2) {
            $sql = "select * from professor where usuario = '$usuario' and senha = '$senha'";

            $retorno = $this->db->query($sql);

            if ($retorno->num_rows() > 0) {
                $dados = array('codigo' => 1, 'msg' => 'login validado com sucesso');
            } else {
                $dados = array('codigo' => 2, 'msg' => 'login nao efetuado');
            }
        } else {
            $dados = array('codigo' => 3, 'msg' => 'Professor desativado da nossa base de dados. Por favor confira.');
        }
        return $dados;
    }
    public function consultarSoUsuarioDesativado($usuario, $senha)
    {
        $sql = "select * from professor where usuario = '$usuario' and senha = '$senha' and estatus = 'D'";

        $retorno = $this->db->query($sql);

        if ($retorno->num_rows() > 0) {
            $dados = array(
                'codigo' => 1,
                'msg' => 'Consulta efetuada com sucesso'
            );
        } else {
            $dados = array(
                'codigo' => 2,
                'msg' => 'Dados não encontrados.'
            );
        }
        return $dados;
    }
    public function alteraProfessor($idprofessor, $nome, $usuario, $senha)
    {
        $retornoProfessor = $this->consultarSoProfessor($idprofessor);

        if ($retornoProfessor['codigo'] == 1) {
            $sql = "UPDATE professor SET ";

            if (!empty($nome)) {
                $sql .= "nome = '$nome', ";
            }

            if (!empty($usuario)) {
                $sql .= "usuario = '$usuario' , ";
            }

            if (!empty($senha)) {
                $sql .= "senha = '$senha' ,";
            }

            $sql = rtrim($sql, ', ');

            $sql .= "where id_professor = $idprofessor";

            $this->db->query($sql);

            if ($this->db->affected_rows() > 0) {

                $dados = array('codigo' => 1, 'msg' => 'Dados do professor atualizados corretamente');
            } else {

                $dados = array('codigo' => 2, 'msg' => 'Houve algum problema na atualização do professor.');
            }
        } else {
            $dados = array('codigo' => 6, 'msg' => 'ID do professor nao esta na base de dados');
        }
        return $dados;
    }
    public function apagaProfessor($idprofessor)
    {
        $retornoProfessor = $this->consultarSoProfessor($idprofessor);

        if ($retornoProfessor['codigo'] == 1) {

            $sql = "update professor set estatus = 'D' where id_professor = $idprofessor";

            $this->db->query($sql);

            if ($this->db->affected_rows() > 0) {
                $dados = array('codigo' => 1, 'msg' => 'professor desativado corretamente');
            } else {
                $dados = array('codigo' => 2, 'msg' => 'houve um problema na desativacao do professor');
            }
        } else {
            $dados = array('codigo' => 4, 'msg' => 'o professor informado nao esta na base de dados');
        }

        return $dados;
    }
    public function ativaProfessor($idprofesor)
    {
        $retornoProfessor = $this->consultarSoProfessor($idprofesor);

        if ($retornoProfessor['codigo'] == 1) {

            $sql = "update professor set estatus = '' where id_professor = $idprofesor";

            $this->db->query($sql);

            if ($this->db->affected_rows() > 0) {
                $dados = array('codigo' => 1, 'msg' => 'professor reativado corretamente');
            } else {
                $dados = array('codigo' => 2, 'msg' => 'houve um problema na reativacao do professor');
            }
        } else {
            $dados = array('codigo' => 4, 'msg' => 'o id informado nao esta na base de dados');
        }
        return $dados;
    }

    public function cursoProfesor($idprofessor, $idcurso)
    {
        $retornoCursoProf = $this->consultaSoCursoProf($idprofessor, $idcurso);

        if ($retornoCursoProf['codigo'] == 2) {
            $sql = "insert into cursoprof (id_professor,id_curso) values ('$idprofessor','$idcurso')";

            $this->db->query($sql);

            if ($this->db->affected_rows() > 0) {
                $dados = array('codigo' => 1, 'msg' => 'Designação do professor ao curso completa com sucesso.');
            } else {
                $dados = array('codigo' => 2, 'msg' => 'Houve algum problema na designação.');
            }
        } else {
            $dados = array('codigo' => 0, 'msg' => 'Professor já designado para esse curso');
        }
        return $dados;
    }

public function consultaSoCursoProf($idprofessor,$idcurso)
    {
        $sql = "select * from cursoprof where id_professor = $idprofessor and id_curso = $idcurso";
        $retorno = $this->db->query($sql);

        if ($retorno->num_rows() > 0) {
            $dados = array('codigo' => 1, 'msg' => 'Consulta efetuada com sucesso.');
        } else {
            $dados = array('codigo' => 2, 'msg' => 'Dados não encontrados.');
        }

        return $dados;
    }

    public function apagaCursoProf($idprofessor, $idcurso)
    {
        $retornoProfCurso = $this->consultaSoCursoProf($idprofessor, $idcurso);

        if ($retornoProfCurso['codigo'] == 1) {
            $sql = "UPDATE cursoprof SET estatus = 'D' WHERE id_professor = '$idprofessor' and id_curso = '$idcurso'";



            $this->db->query($sql);

            if ($this->db->affected_rows() > 0) {
                $dados = array('codigo' => 1, 'msg' => 'cursoprof desativado corretamente');
            } else {
                $dados = array('codigo' => 2, 'msg' => 'Houve um problema na desativação do cursoprof');
            }
        } else {
            $dados = array('codigo' => 4, 'msg' => 'ProfCurso informado não está na base de dados');
        }

        return $dados;
    }

    public function ativaCursoProf($idprofessor, $idcurso)
    {
        $retornoProfCurso = $this->consultaSoCursoProf($idprofessor, $idcurso);

        if ($retornoProfCurso['codigo'] == 1) {
            $sql = "UPDATE cursoprof SET estatus = '' WHERE id_professor = '$idprofessor' and id_curso = '$idcurso'";



            $this->db->query($sql);

            if ($this->db->affected_rows() > 0) {
                $dados = array('codigo' => 1, 'msg' => 'cursoprof ativado corretamente');
            } else {
                $dados = array('codigo' => 2, 'msg' => 'Houve um problema na ativação do cursoprof');
            }
        } else {
            $dados = array('codigo' => 4, 'msg' => 'cursoProf informado não está na base de dados');
        }

        return $dados;
    }
}
