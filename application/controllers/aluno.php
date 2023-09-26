<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Aluno extends CI_Controller
{

    private $json;
    private $resultado;

    private $ra;
    private $idcurso;
    private $nome;
    private $estatus;

    public function getRA()
    {
        return $this->ra;
    }

    public function getIdCurso()
    {
        return $this->idcurso;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function getEstatus()
    {
        return $this->estatus;
    }

    public function setRA($raFront)
    {
        $this->ra = $raFront;
    }

    public function setIdCurso($idcursoFront)
    {
        $this->idcurso = $idcursoFront;
    }

    public function setNome($nomeFront)
    {
        $this->nome = $nomeFront;
    }

    public function setEstatus($estatusFront)
    {
        $this->estatus = $estatusFront;
    }

    public function inserirAluno()
    {
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);

        $lista = array("ra" => '0', "nome" => '0', "idcurso" => '0', "estatus" => '0');

        if (verificarParam($resultado, $lista) == 1) {
            $this->setRA($resultado->ra);
            $this->setIdCurso($resultado->idcurso);
            $this->setNome($resultado->nome);
            $this->setEstatus($resultado->estatus);


            if (trim($this->getRA()) == "" || $this->getRA() == 0) {
                $retorno = array('codigo' => 3, 'msg' => 'RA do aluno nao informado ou zerado');
            } elseif (trim((string) $this->getIdCurso()) == "" || $this->getIdCurso() == 0) {
                $retorno = array('codigo' => 4, 'msg' => 'id do curso nao informado ou zerado');
            } elseif ($this->getEstatus() != "D" && $this->getEstatus() != "") {
                $retorno = array('codigo' => 4, 'msg' => 'status nao condiz com o permitido');
            } elseif (strlen($this->getNome()) == 0) {
                $retorno = array('codigo' => 5, 'msg' => 'nome do aluno nao informado');
            } else {
                $this->load->model('M_aluno');

                $retorno = $this->M_aluno->inserirAluno($this->getRA(), $this->getIdCurso(), $this->getNome(), $this->getEstatus());
            }
        } else {
            $retorno = array('codigo' => 99, 'msg' => 'os campos vindos do front nao representam o metodo de inserçao');
        }

        echo json_encode($retorno);
    }

    public function consultarAluno()
    {

        $json = file_get_contents('php://input');
        $resultado = json_decode($json);

        $lista = array("ra" => '0', "nome" => '0', "idcurso" => '0', "estatus" => '0');

        if (verificarParam($resultado, $lista) == 1) {
            $this->setRA($resultado->ra);
            $this->setIdCurso($resultado->idcurso);
            $this->setNome($resultado->nome);
            $this->setEstatus($resultado->estatus);

            if ($this->getEstatus() != "D" && $this->getEstatus() != "") {
                $retorno = array('codigo' => 4, 'msg' => 'status nao condiz com o permitido');
            } else {
                $this->load->model('M_aluno');

                $retorno = $this->M_aluno->consultarAluno($this->getRA(), $this->getNome(), $this->getIdCurso(), $this->getEstatus());
            }
        } else {
            $retorno = array('codigo' => 99, 'msg' => 'os campos vindos do front nao representam o metodo de consulta');
        }

        echo json_encode($retorno);
    }

    public function alterarAluno()
    {
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);

        $lista = array("ra" => '0', "nome" => '0', "idcurso" => '0');

        if (verificarParam($resultado, $lista) == 1) {
            $this->setRA($resultado->ra);
            $this->setIdCurso($resultado->idcurso);
            $this->setNome($resultado->nome);

            if (strlen($this->getRA()) == 0) {
                $retorno = array('codigo' => 3, 'msg' => 'ra do aluno nao informado');

               
            }else{
                $this->load->model('M_aluno');

                $retorno = $this->M_aluno->alterarAluno($this->getRA(), $this->getIdCurso(), $this->getNome());

            }
        } else {
            $retorno = array('codigo' => 99, 'msg' => 'os campos vindos do front nao representam o metodo de consulta');
        }
        echo json_encode($retorno);
    }

    public function apagarAluno()
    {
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);

        $lista = array("ra" => '0',"usuario" => '0',"senha" => '0', "estatus" => '0');

        if (verificarParam($resultado, $lista) == 1) {
            $this->setRA($resultado->ra);
            $usuario = $resultado->usuario;
            $senha = $resultado->senha;
            $estatus = $resultado->estatus;

            if (strlen($this->getRA()) == 0) {
                $retorno = array('codigo' => 3, 'msg' => 'ra do aluno nao informado');
            } else {
                $this->load->model('M_aluno');

                $retorno = $this->M_aluno->apagarAluno($this->getRA(), $usuario, $senha, $estatus);
            }
        } else {
            $retorno = array('codigo' => 99, 'msg' => 'os campos vindos do front nao representam o metodo de consulta');
        }

        echo json_encode($retorno);
    }

    public function reativarAluno()
    {

        $json = file_get_contents('php://input');
        $resultado = json_decode($json);

        $lista = array("ra" => '0');

        if (verificarParam($resultado, $lista) == 1) {
            $this->setRA($resultado->ra);

            if (trim($this->getRA()) == 0) {
                $retorno = array('codigo' => 3, 'msg' => 'ra do aluno nao informado');
            } else {
                $this->load->model('M_aluno');

                $retorno = $this->M_aluno->reativarAluno($this->getRA());
            }
        } else {
            $retorno = array('codigo' => 99, 'msg' => 'os campos vindos do front nao representam o metodo de consulta');
        }

        echo json_encode($retorno);
    }

   
}