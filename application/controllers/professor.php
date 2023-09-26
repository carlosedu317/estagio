<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Professor extends CI_Controller
{
    private $json;
    private $resultado;
    private $idprofessor;
    private $nome;
    private $usuario;
    private $senha;
    private $estatus;

    public function getIdProfessor()
    {
        return $this->idprofessor;
    }

    public function setIdProfessor($idprofessorFront)
    {
        $this->idprofessor = $idprofessorFront;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nomeFront)
    {
        $this->nome = $nomeFront;
    }

    public function getUsuario()
    {
        return $this->usuario;
    }

    public function setUsuario($usuarioFront)
    {
        $this->usuario = $usuarioFront;
    }

    public function getSenha()
    {
        return $this->senha;
    }

    public function setSenha($senhaFront)
    {
        $this->senha = $senhaFront;
    }

    public function getEstatus()
    {
        return $this->estatus;
    }

    public function setEstatus($estatusFront)
    {
        $this->estatus = $estatusFront;
    }

    public function inserirProfessor()
    {
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);

        $lista = array("nome" => '0', "usuario" => '0', "senha" => '0', "estatus" => '0');
        if (verificarParam($resultado, $lista) == 1) {

            $this->setNome($resultado->nome);
            $this->setUsuario($resultado->usuario);
            $this->setSenha($resultado->senha);
            $this->setEstatus($resultado->estatus);

            if ($this->getNome() == 0) {
                $retorno = array('codigo' => 0, 'msg' => 'Nome não informado.');
            } elseif ($this->getUsuario() == 0) {
                $retorno = array('codigo' => 5, 'msg' => 'Usuario não informado');
            } elseif ($this->getSenha() == 0) {
                $retorno = array('codigo' => 6, 'msg' => 'Senha não informada');
            } elseif ($this->getEstatus() != "D" && $this->getEstatus() != "") {
                $retorno = array('codigo' => 7, 'msg' => 'Status não condiz com o permitido');
            } else {
                $this->load->model('M_Professor');
                $retorno = $this->M_Professor->inserirProfessor($this->getNome(), $this->getUsuario(), $this->getSenha(), $this->getEstatus());
            }
        } else {
            $retorno = array('codigo' => 99, 'msg' => 'Os campos vindos do frontend não representam o método de inserção, verifique.');
        }

        echo json_encode($retorno);
    }

    public function consultarProfessor()
    {
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);

        $lista = array(
            "idprofessor" => '0',
            "nome" => '0',
            "usuario" => '0',
            "senha" => '0',
            "estatus" => '0'
        );

        if (verificarParam($resultado, $lista) == 1) {
            $this->setIdProfessor($resultado->idprofessor);
            $this->setNome($resultado->nome);
            $this->setUsuario($resultado->usuario);
            $this->setSenha($resultado->senha);
            $this->setEstatus($resultado->estatus);

            if ($this->getEstatus() != "D" && $this->getEstatus() != "") {
                $retorno = array('codigo' => 4, 'msg' => 'Status não condiz com o permitido');
            } else {
                $this->load->model('M_professor');
                $retorno = $this->M_professor->consultarProfessor(
                    $this->getIdProfessor(),
                    $this->getNome(),
                    $this->getUsuario(),
                    $this->getSenha(),
                    $this->getEstatus()
                );
            }
        } else {
            $retorno = array('codigo' => 99, 'msg' => 'Os campos vindos do frontend não representam o método de consulta');
        }

        echo json_encode($retorno);
    }

    public function consultarUsuario()
    {
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);

        $lista = array(
            "usuario" => '0',
            "senha" => '0',
            "estatus" => '0'
        );

        if (verificarParam($resultado, $lista) == 1) {
            $this->setUsuario($resultado->usuario);
            $this->setSenha($resultado->senha);
            $this->setEstatus($resultado->estatus);

            if ($this->getEstatus() == "" && $this->getEstatus() == 0) {
                $retorno = array('codigo' => 4, 'msg' => 'Status não condiz com o permitido');
            } else {
                $this->load->model('M_professor');
                $retorno = $this->M_professor->consultarUsuario(
                    $this->getUsuario(),
                    $this->getSenha(),
                    $this->getEstatus()
                );
            }
        } else {
            $retorno = array('codigo' => 99, 'msg' => 'Os campos vindos do frontend não representam o método de consulta');
        }

        echo json_encode($retorno);
    }

    public function loginProf()
    {
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);

        $lista = array(
            "usuario" => '0',
            "senha" => '0'
        );

        if (verificarParam($resultado, $lista) == 1) {
            $this->setUsuario($resultado->usuario);
            $this->setSenha($resultado->senha);

            if (strlen($this->getUsuario()) == 0) {
                $retorno = array('codigo' => 3, 'msg' => 'Usuario não informado');
            } elseif (strlen($this->getSenha()) == 0) {
                $retorno = array('codigo' => 4, 'msg' => 'Senha não informada');
            } else {
                $this->load->model('M_professor');
                $retorno = $this->M_professor->loginProf($this->getUsuario(), $this->getSenha());
            }
        } else {
            $retorno = array('codigo' => 99, 'msg' => 'Os campos vindos do frontend não representam o método de consulta');
        }

        echo json_encode($retorno);
    }



    public function alteraProfessor()
    {
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);

        $lista = array(
            "idprofessor" => '0',
            "nome" => '0',
            "usuario" => '0',
            "senha" => '0'
        );

        if (verificarParam($resultado, $lista) == 1) {
            $this->setIdProfessor($resultado->idprofessor);
            $this->setNome($resultado->nome);
            $this->setUsuario($resultado->usuario);
            $this->setSenha($resultado->senha);

            if ($this->getIdProfessor() == "" || $this->getIdProfessor() == 0) {
                $retorno = array('codigo' => 3, 'msg' => 'idprofessor não informado ou zerado');
            } else {
                $this->load->model('M_professor');
                $retorno = $this->M_professor->alteraProfessor(
                    $this->getIdProfessor(),
                    $this->getNome(),
                    $this->getUsuario(),
                    $this->getSenha()
                );
            }
        } else {
            $retorno = array('codigo' => 99, 'msg' => 'Os campos vindos do frontend não representam o método de consulta');
        }

        echo json_encode($retorno);
    }

    public function apagaProfessor()
    {
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);

        $lista = array(
            "idprofessor" => '0'
        );

        if (verificarParam($resultado, $lista) == 1) {
            $this->setIdProfessor($resultado->idprofessor);

            if (strlen($this->getIdProfessor()) == 0) {
                $retorno = array('codigo' => 3, 'msg' => 'ID do professor não informado');
            } else {
                $this->load->model('M_professor');
                $retorno = $this->M_professor->apagaProfessor($this->getIdProfessor());
            }
        } else {
            $retorno = array('codigo' => 4, 'msg' => 'O ID informado não está na base de dados');
        }

        echo json_encode($retorno);
    }

    public function ativaProfessor()
    {
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);

        $lista = array(
            "idprofessor" => '0'
        );

        if (verificarParam($resultado, $lista) == 1) {
            $this->setIdProfessor($resultado->idprofessor);

            if (trim($this->getIdProfessor()) == 0) {
                $retorno = array('codigo' => 3, 'msg' => 'ID do professor não informado');
            } else {
                $this->load->model('M_professor');
                $retorno = $this->M_professor->ativaProfessor($this->getIdProfessor());
            }
        } else {
            $retorno = array('codigo' => 99, 'msg' => 'Os campos vindos do frontend não representam o método de consulta');
        }

        echo json_encode($retorno);
    }

    public function cursoProfessor()
    {
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);

        $lista = array("idprofessor" => '0', "idcurso" => '0');

        if (verificarParam($resultado, $lista) == 1) {
            $this->setIdProfessor($resultado->idprofessor);
            $idcurso = $resultado->idcurso;

            if ($this->getIdProfessor() == "" && $this->getIdProfessor() == 0) {
                $retorno = array('codigo' => 0, 'msg' => 'ID do Professor não informado.');
            } elseif ($idcurso == "" && $idcurso == 0) {
                $retorno = array('codigo' => 3, 'msg' => 'ID do curso não informado');
            } else {
                $this->load->model('M_Professor');
                $retorno = $this->M_Professor->cursoProfesor($this->getIdProfessor(), $idcurso);
            }
        } else {
            $retorno = array('codigo' => 99, 'msg' => 'Os campos vindos do frontend não representam o método de inserção, verifique.');
        }

        echo json_encode($retorno);
    }

    public function consultarCursoProf()
    {
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);

        $lista = array("idprofessor" => '0', "idcurso" => '0', "estatus" => '0');

        if (verificarParam($resultado, $lista) == 1) {
            $this->setIdProfessor($resultado->idprofessor);
            $idcurso = $resultado->idcurso;
            $this->setEstatus($resultado->estatus);

            if ($this->getEstatus() != "D" && $this->getEstatus() != "") {
                $retorno = array('codigo' => 4, 'msg' => 'Status não condiz com o permitido');
            } else {
                $this->load->model('M_professor');
                $retorno = $this->M_professor->consultarCursoProf($this->getIdProfessor(), $idcurso, $this->estatus);
            }
        } else {
            $retorno = array('codigo' => 99, 'msg' => 'Os campos vindos do frontend não representam o método de consulta');
        }

        echo json_encode($retorno);
    }

    public function consultaSoCursoProf()
    {
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);

        $lista = array("idprofessor" => '0', "idcurso" => '0');

        if (verificarParam($resultado, $lista) == 1) {
            $this->setIdProfessor($resultado->idprofessor);
            $idcurso = $resultado->idcurso;

            if ($this->getIdProfessor() == "" && $this->getIdProfessor() == 0) {
                $retorno = array('codigo' => 0, 'msg' => 'ID do Professor não informado.');
            } elseif ($idcurso == "" && $idcurso == 0) {
                $retorno = array('codigo' => 4, 'msg' => 'ID do curso não informado');
            } else {
                $this->load->model('M_Professor');
                $retorno = $this->M_Professor->consultaSoProfCurso($this->getIdProfessor(), $idcurso);
            }
        } else {
            $retorno = array('codigo' => 99, 'msg' => 'Os campos vindos do frontend não representam o método de inserção, verifique.');
        }

        echo json_encode($retorno);
    }


    public function apagaCursoProf()

    {
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);
        $lista = array(
            "idprofessor" => '0',
            "idcurso" => '0'
        );

        if (verificarParam($resultado, $lista) == 1) {
            $this->setIdProfessor($resultado->idprofessor);
            $idcurso = $resultado->idcurso;

            if ($this->getIdProfessor() == "" && $this->getIdProfessor() == 0) {
                $retorno = array('codigo' => 3, 'msg' => 'ID do professor não informado');
            } elseif ($idcurso == "" && $idcurso == 0) {
                $retorno = array('codigo' => 3, 'msg' => 'ID do curso não informado');
            } else {
                $this->load->model('M_professor');
                $retorno = $this->M_professor->apagaProfCurso($this->getIdProfessor(), $idcurso);
            }
        } else {

            $retorno = array('codigo' => 4, 'msg' => 'O ID informado não está na base de dados');
        }
        echo json_encode($retorno);
    }
}
