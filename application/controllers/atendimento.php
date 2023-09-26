<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Atendimento extends CI_Controller
{
    private $codigo;
    private $ra;
    private $idprofessor;
    private $dataAt;
    private $horaAt;
    private $descricao;
    private $estatus;

    public function getCodAtendimento()
    {
        return $this->codigo;
    }

    public function setCodAtendimento($codigoFront)
    {
        $this->codigo = $codigoFront;
    }

    public function getRA()
    {
        return $this->ra;
    }

    public function setRa($raFront)
    {
        $this->ra = $raFront;
    }

    public function getIdProfessor()
    {
        return $this->idprofessor;
    }

    public function setIdProfessor($idprofessorFront)
    {
        $this->idprofessor = $idprofessorFront;
    }

    public function getDataAtendimento()
    {
        return $this->dataAt;
    }

    public function setDataAtendimento($dataAtFront)
    {
        $this->dataAt = $dataAtFront;
    }

    public function getHoraAtendimento()
    {
        return $this->horaAt;
    }

    public function setHoraAtendimento($horaAtFront)
    {
        $this->horaAt = $horaAtFront;
    }

    public function getDescricao()
    {
        return $this->descricao;
    }

    public function setDescricao($descricaoFront)
    {
        $this->descricao = $descricaoFront;
    }

    public function getEstatus()
    {
        return $this->estatus;
    }

    public function setEstatus($estatusFront)
    {
        $this->estatus = $estatusFront;
    }

    public function atendimento()
    {
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);

        $lista = array("ra" => '0', "idprofessor" => '0', "dataAt" => '0', "horaAt" => '0', "descricao" => '0', "estatus" => '0');

        if (verificarParam($resultado, $lista) == 1) {
            $this->setRa($resultado->ra);
            $this->setIdProfessor($resultado->idprofessor);
            $this->setDataAtendimento($resultado->dataAt);
            $this->setHoraAtendimento($resultado->horaAt);
            $this->setDescricao($resultado->descricao);
            $this->setEstatus($resultado->estatus);

            if (trim($this->getRA()) == "" || $this->getRA() == 0) {
                $retorno = array('codigo' => 3, 'msg' => 'RA do aluno nao informado ou zerado');

            } elseif (trim($this->getIdProfessor()) == "" || $this->getIdProfessor() == 0) {
                $retorno = array('codigo' => 4, 'msg' => 'id do professor nao informado ou zerado');

            } elseif (trim($this->getDataAtendimento()) == "") {
                $retorno = array('codigo' => 6, 'msg' => 'data nao infromada');

            } elseif (trim($this->getHoraAtendimento()) == "") {
                $retorno = array('codigo' => 7, 'msg' => 'hora nao informada');

            } elseif (trim($this->getDescricao()) == "") {
                $retorno = array('codigo' => 8, 'msg' => 'descricao nao informada');

            } elseif (trim($this->getEstatus()) != "D" && $this->getEstatus() != "") {
                $retorno = array('codigo' => 8, 'msg' => 'status nao condiz com o permitido');
                
            } else {
                $this->load->model('M_atendimento');

                $retorno = $this->M_atendimento->atendimento($this->getRA(), $this->getIdProfessor(), $this->getDataAtendimento(), $this->getHoraAtendimento(), $this->getDescricao(), $this->getEstatus());
            }
        } else {
            $retorno = array('codigo' => 99, 'msg' => 'os campos vindos do front nao representam o metodo de inserçao');
        }
        echo json_encode($retorno);
    }

    public function consultaAtendimento()
    {
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);

        $lista = array("codigo" => '0', "ra" => '0', "idprofessor" => '0', "dataAt" => '0', "horaAt" => '0', "descricao" => '0', "estatus" => '0');

        if (verificarParam($resultado, $lista) == 1) {
            $this->setCodAtendimento($resultado->codigo);
            $this->setRa($resultado->ra);
            $this->setIdProfessor($resultado->idprofessor);
            $this->setDataAtendimento($resultado->dataAt);
            $this->setHoraAtendimento($resultado->horaAt);
            $this->setDescricao($resultado->descricao);
            $this->setEstatus($resultado->estatus);

            if (trim($this->getEstatus()) != "D" && $this->getEstatus() != "") {
                $retorno = array('codigo' => 10, 'msg' => 'status nao condiz com o permitido');
            } else {
                $this->load->model('M_atendimento');

                $retorno = $this->M_atendimento->consultaAtendimento($this->getCodAtendimento(), $this->getRA(), $this->getIdProfessor(), $this->getDataAtendimento(), $this->getHoraAtendimento(), $this->getDescricao(), $this->getEstatus());
            }
        }else{
            $retorno = array('codigo' => 99, 'msg' => 'os campos vindos do front nao representam o metodo de inserçao');
        }
        echo json_encode($retorno);
    }

    public function alteraAtendimento()
    {
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);

        $lista = array("codigo" => '0', "ra" => '0', "idprofessor" => '0', "dataAt" => '0', "horaAt" => '0', "descricao" => '0');

        if (verificarParam($resultado, $lista) == 1) {
            $this->setCodAtendimento($resultado->codigo);
            $this->setRa($resultado->ra);
            $this->setIdProfessor($resultado->idprofessor);
            $this->setDataAtendimento($resultado->dataAt);
            $this->setHoraAtendimento($resultado->horaAt);
            $this->setDescricao($resultado->descricao);


            if (trim($this->getCodAtendimento()) == "" || $this->getCodAtendimento() == 0) {
                $retorno = array('codigo' => 11, 'msg' => 'codigo do atendimento nao informado ou zerado');
            } elseif (trim($this->getRA()) == "" || $this->getRA() == 0) {
                $retorno = array('codigo' => 3, 'msg' => 'RA do aluno nao informado ou zerado');
            } elseif (trim($this->getIdProfessor()) == "" || $this->getIdProfessor() == 0) {
                $retorno = array('codigo' => 4, 'msg' => 'id do professor nao informado ou zerado');
            } else {
                $this->load->model('M_atendimento');

                $retorno = $this->M_atendimento->alteraAtendimento($this->getCodAtendimento(), $this->getRA(), $this->getIdProfessor(), $this->getDataAtendimento(), $this->getHoraAtendimento(), $this->getDescricao());
            }
        } else {
            $retorno = array('codigo' => 99, 'msg' => 'os campos vindos do front nao representam o metodo de consulta');
        }
        echo json_encode($retorno);
    }

    public function apagaAtendimento()
    {
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);

        $lista = array("codigo" => '0');

        if (verificarParam($resultado, $lista) == 1) {
            $this->setCodAtendimento($resultado->codigo);

            if (trim($this->getCodAtendimento()) == "" || $this->getCodAtendimento() == 0) {
                $retorno = array('codigo' => 11, 'msg' => 'codigo do atendimento nao informado ou zerado');
            } else {
                $this->load->model('M_atendimento');

                $retorno = $this->M_atendimento->apagaAtendimento($this->getCodAtendimento());
            }
        } else {
            $retorno = array('codigo' => 88, 'msg' => 'o codigo informado nao esta na base de dados');
        }

        echo json_encode($retorno);
    }

    public function ativaAtendimento()
    {
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);

        $lista = array("codigo" => '0');

        if (verificarParam($resultado, $lista) == 1) {
            $this->setCodAtendimento($resultado->codigo);

            if (trim($this->getCodAtendimento()) == "" || $this->getCodAtendimento() == 0) {
                $retorno = array('codigo' => 11, 'msg' => 'codigo do atendimento nao informado ou zerado');
            } else {
                $this->load->model('M_atendimento');

                $retorno = $this->M_atendimento->ativaAtendimento($this->getCodAtendimento());
            }
        } else {
            $retorno = array('codigo' => 88, 'msg' => 'o codigo informado nao esta na base de dados');
        }

        echo json_encode($retorno);
    }
}
