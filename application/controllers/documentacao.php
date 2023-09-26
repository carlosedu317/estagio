<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Documentacao extends CI_Controller
{
    private $json;
    private $resultado;
    private $semestre_ano;
    private $ra;
    private $tcer;
    private $tcenr;
    private $desc_atividades;
    private $rel_atividades;
    private $rescisao;
    private $ficha_valid;
    private $rel_equivalencia;
    private $observacoes;
    private $estatus;

    public function getSemestreAno()
    {
        return $this->semestre_ano;
    }

    public function getRA()
    {
        return $this->ra;
    }

    public function getTcer()
    {
        return $this->tcer;
    }

    public function getTcenr()
    {
        return $this->tcenr;
    }

    public function getDescAtividades()
    {
        return $this->desc_atividades;
    }

    public function getRelAtividades()
    {
        return $this->rel_atividades;
    }

    public function getRescisao()
    {
        return $this->rescisao;
    }
    public function getFichaValid()
    {
        return $this->ficha_valid;
    }

    public function getRelEquivalencia()
    {
        return $this->rel_equivalencia;
    }

    public function getObservacoes()
    {
        return $this->observacoes;
    }

    public function getEstatus()
    {
        return $this->estatus;
    }
    public function setSemestreAno($semestre_ano)
    {
        $this->semestre_ano = $semestre_ano;
    }

    public function setRA($ra)
    {
        $this->ra = $ra;
    }

    public function setTcer($tcer)
    {
        $this->tcer = $tcer;
    }

    public function setTcenr($tcenr)
    {
        $this->tcenr = $tcenr;
    }
    public function setDescAtividades($desc_atividades)
    {
        $this->desc_atividades = $desc_atividades;
    }

    public function setRelAtividades($rel_atividades)
    {
        $this->rel_atividades = $rel_atividades;
    }

    public function setRescisao($rescisao)
    {
        $this->rescisao = $rescisao;
    }

    public function setFichaValid($ficha_valid)
    {
        $this->ficha_valid = $ficha_valid;
    }

    public function setRelEquivalencia($rel_equivalencia)
    {
        $this->rel_equivalencia = $rel_equivalencia;
    }

    public function setObservacoes($observacoes)
    {
        $this->observacoes = $observacoes;
    }

    public function setEstatus($estatus)
    {
        $this->estatus = $estatus;
    }

    public function inserirDoc()
    {
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);

        $lista = array(
            "semestre_ano" => '0', "ra" => '0', "tcer" => '0',
            "tcenr" => '0', "desc_atividades" => '0', "rel_atividades" => '0', "rescisao" => '0', "ficha_valid" => '0',
            "rel_equivalencia" => '0', "observacoes" => '0', "estatus" => '0'
        );

        if (verificarParam($resultado, $lista) == 1) {
            $this->setSemestreAno($resultado->semestre_ano);
            $this->setRA($resultado->ra);
            $this->setTcer($resultado->tcer);
            $this->setTcenr($resultado->tcenr);
            $this->setDescAtividades($resultado->desc_atividades);
            $this->setRelAtividades($resultado->rel_atividades);
            $this->setRescisao($resultado->rescisao);
            $this->setFichaValid($resultado->ficha_valid);
            $this->setRelEquivalencia($resultado->rel_equivalencia);
            $this->setObservacoes($resultado->observacoes);
            $this->setEstatus($resultado->estatus);

            if (trim($this->getSemestreAno()) == "" || $this->getSemestreAno() == 0) {
                $retorno = array('codigo' => 3, 'msg' => 'Semestre ano não passado corretamente.');
            } else if (trim($this->getRA()) == "" || $this->getRA() == 0) {
                $retorno = array('codigo' => 4, 'msg' => 'RA do aluno nao informado ou zerado.');
            } elseif ($this->getEstatus() != "D" && $this->getEstatus() != "") {
                $retorno = array('codigo' => 5, 'msg' => 'status nao condiz com o permitido');
            } else if (
                empty($resultado->tcer) && empty($resultado->tcenr) && empty($resultado->desc_atividades) &&
                empty($resultado->ficha_valid) && empty($resultado->rel_atividades) &&
                empty($resultado->rescisao) && empty($resultado->rel_equivalencia) &&
                empty($resultado->observacoes)
            ) {
                $retorno = array('codigo' => 6, 'msg' => 'Preencha ao menos um campo.');
            } else {
                $this->load->model('M_documentacao');
                $retorno =  $this->M_documentacao->inserirDoc(
                    $this->getSemestreAno(),
                    $this->getRA(),
                    $this->getTcer(),
                    $this->getTcenr(),
                    $this->getDescAtividades(),
                    $this->getRelAtividades(),
                    $this->getRescisao(),
                    $this->getFichaValid(),
                    $this->getRelEquivalencia(),
                    $this->getObservacoes(),
                    $this->getEstatus()
                );
            }
        } else {
            $retorno = array('codigo' => 99, 'msg' => 'os campos vindos do front nao representam o metodo de inserçao');
        }

        echo json_encode($retorno);
    }

    public function consultarDoc()
    {
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);

        $lista = array(
            "semestre_ano" => '0', "ra" => '0', "tcer" => '0',
            "tcenr" => '0', "desc_atividades" => '0', "rel_atividades" => '0', "rescisao" => '0', "ficha_valid" => '0',
            "rel_equivalencia" => '0', "observacoes" => '0', "estatus" => '0'
        );

        if (verificarParam($resultado, $lista) == 1) {
            $this->setSemestreAno($resultado->semestre_ano);
            $this->setRA($resultado->ra);
            $this->setTcer($resultado->tcer);
            $this->setTcenr($resultado->tcenr);
            $this->setDescAtividades($resultado->desc_atividades);
            $this->setRelAtividades($resultado->rel_atividades);
            $this->setRescisao($resultado->rescisao);
            $this->setFichaValid($resultado->ficha_valid);
            $this->setRelEquivalencia($resultado->rel_equivalencia);
            $this->setObservacoes($resultado->observacoes);
            $this->setEstatus($resultado->estatus);

            if ($this->getEstatus() != "D" && $this->getEstatus() != "") {
                $retorno = array('codigo' => 4, 'msg' => 'status nao condiz com o permitido');
            } else {
                $this->load->model('M_documentacao');
                $retorno =  $this->M_documentacao->consultarDoc(
                    $this->getSemestreAno(),
                    $this->getRA(),
                    $this->getTcer(),
                    $this->getTcenr(),
                    $this->getDescAtividades(),
                    $this->getRelAtividades(),
                    $this->getRescisao(),
                    $this->getFichaValid(),
                    $this->getRelEquivalencia(),
                    $this->getObservacoes(),
                    $this->getEstatus()
                );
            }
        } else {
            $retorno = array('codigo' => 99, 'msg' => 'os campos vindos do front nao representam o metodo de inserçao');
        }

        echo json_encode($retorno);
    }
    public function alterarDoc()
    {
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);

        $lista = array(
            "semestre_ano" => '0', "ra" => '0', "tcer" => '0', "tcenr" => '0',
            "desc_atividades" => '0', "rel_atividades" => '0', "rescisao" => '0',
            "ficha_valid" => '0', "rel_equivalencia" => '0', "observacoes" => '0', "estatus" => '0'
        );

        if (verificarParam($resultado, $lista) == 1) {
            $this->setSemestreAno($resultado->semestre_ano);
            $this->setRA($resultado->ra);
            $this->setTcer($resultado->tcer);
            $this->setTcenr($resultado->tcenr);
            $this->setDescAtividades($resultado->desc_atividades);
            $this->setRelAtividades($resultado->rel_atividades);
            $this->setRescisao($resultado->rescisao);
            $this->setFichaValid($resultado->ficha_valid);
            $this->setRelEquivalencia($resultado->rel_equivalencia);
            $this->setObservacoes($resultado->observacoes);
            $this->setEstatus($resultado->estatus);

            if (trim($this->getSemestreAno()) == "" || $this->getSemestreAno() == 0) {
                $retorno = array('codigo' => 3, 'msg' => 'Semestre ano não passado corretamente.');
            } elseif (trim($this->getRA()) == "" || $this->getRA() == 0) {
                $retorno = array('codigo' => 4, 'msg' => 'RA do aluno nao informado ou zerado.');
            } elseif ($this->getEstatus() != "D" && $this->getEstatus() != "") {
                $retorno = array('codigo' => 5, 'msg' => 'status nao condiz com o permitido');
            } else {
                $this->load->model('M_documentacao');
                $retorno =  $this->M_documentacao->alterarDoc(
                    $this->getSemestreAno(),
                    $this->getRA(),
                    $this->getTcer(),
                    $this->getTcenr(),
                    $this->getDescAtividades(),
                    $this->getRelAtividades(),
                    $this->getRescisao(),
                    $this->getFichaValid(),
                    $this->getRelEquivalencia(),
                    $this->getObservacoes(),
                    $this->getEstatus()
                );
            }
        } else {
            $retorno = array('codigo' => 99, 'msg' => 'os campos vindos do front nao representam o metodo de inserçao');
        }

        echo json_encode($retorno);
    }
    public function apagaDoc()
    {
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);

        $lista = array("semestre_ano" => '0', "ra" => '0');

        if (verificarParam($resultado, $lista) == 1) {
            $this->setSemestreAno($resultado->semestre_ano);
            $this->setRa($resultado->ra);

            if (empty($this->getSemestreAno())) {
                $retorno = array('codigo' => 13, 'msg' => 'Semestre não informado');
            } elseif (empty($this->getRa())) {
                $retorno = array('codigo' => 14, 'msg' => 'RA não informado');
            } else {
                $this->load->model('M_documentacao');
                $retorno = $this->M_documentacao->apagaDoc($this->getSemestreAno(), $this->getRA());
            }
        } else {
            $retorno = array('codigo' => 99, 'msg' => 'Os campos vindos do front não representam o método de consulta');
        }

        echo json_encode($retorno);
    }
    public function ativaDoc()
    {
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);

        $lista = array("semestre_ano" => '0', "ra" => '0');

        if (verificarParam($resultado, $lista) == 1) {
            $this->setSemestreAno($resultado->semestre_ano);
            $this->setRa($resultado->ra);

            if (empty($this->getSemestreAno())) {
                $retorno = array('codigo' => 13, 'msg' => 'Semestre não informado');
            } elseif (empty($this->getRa())) {
                $retorno = array('codigo' => 14, 'msg' => 'RA não informado');
            } else {
                $this->load->model('M_documentacao');
                $retorno = $this->M_documentacao->ativaDoc($this->getSemestreAno(), $this->getRA());
            }
        } else {
            $retorno = array('codigo' => 99, 'msg' => 'Os campos vindos do front não representam o método de consulta');
        }

        echo json_encode($retorno);
    }
}
