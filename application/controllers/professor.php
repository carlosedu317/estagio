<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Professor extends CI_Controller{

    private $json;
    private $resultado;
    private $idprofessor;
    private $nome;
    private $usuario;
    private $senha;
    private $estatus;

    public function getIdProfessor(){
        return $this->idprofessor;
    }

    public function getNome(){
        return $this->nome;
    }

    public function getUsuario(){
        return $this->usuario;
    }

    public function getSenha(){
        return $this->senha;
    }

    public function getEstatus(){
        return $this->estatus;
    }

    public function setIdProfessor($idprofessorFront){
        $this->idprofessor = $idprofessorFront;
    }

    public function setNome($nomeFront){
        $this->nome = $nomeFront;
    }

    public function setUsuario($usuarioFront){
        $this->usuario = $usuarioFront;
    }

    public function setSenha($senhaFront){
        $this->senha = $senhaFront;
    }

    public function setEstatus($estatusFront){
        $this->estatus = $estatusFront;
    }

    public function inserirProfessor(){
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);

        $lista = array("nome"=> '0', "usuario"=>'0', "senha"=>'0', "estatus"=>'0');

        if(verificarParam($resultado, $lista)==1){
            $this->setNome($resultado->nome);
            $this->setUsuario($resultado->usuario);
            $this->setSenha($resultado->senha);
            $this->setEstatus($resultado->estatus);

            if(trim($this->getNome())==0){
                $retorno = array('codigo' => 5, 'msg' => 'nome do professor nao informado');

            }elseif($this->getUsuario()== 0){
                $retorno = array('codigo' => 8, 'msg' => 'usuario do  professor nao informado');

            }elseif($this->getSenha()=="" || $this->getSenha()==0){
                $retorno = array('codigo' => 10, 'msg' => 'senha nao informada ou zerada');

            }elseif($this->getEstatus() != "D" && $this->getEstatus() != ""){
                $retorno = array('codigo' => 4, 'msg' => 'status nao condiz com o permitido');
            }else{
                $this->load->model('M_professor');

                $retorno = $this->M_professor->inserirProfessor($this->getNome(),$this->getUsuario(),$this->getSenha(),$this->getEstatus());
            }
        }else{
            $retorno = array('codigo' => 99, 'msg' => 'os campos vindos do front nao representam o metodo de inserçao');
        }

        echo json_encode($retorno);
    }

    public function consultarProfessor(){
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);

        $lista = array("idprofessor"=> '0', "nome"=> '0', "usuario"=>'0', "senha"=>'0', "estatus"=>'0');

        if(verificarParam($resultado, $lista)==1){
            $this->setIdProfessor($resultado->idprofessor);
            $this->setNome($resultado->nome);
            $this->setUsuario($resultado->usuario);
            $this->setSenha($resultado->senha);
            $this->setEstatus($resultado->estatus);

            if ($this->getEstatus() != "D" && $this->getEstatus() != "") {
                $retorno = array('codigo' => 4, 'msg' => 'status nao condiz com o permitido');
            } else {
                $this->load->model('M_professor');

                $retorno = $this->M_professor->consultarProfessor($this->getNome(),$this->getUsuario(),$this->getSenha(),$this->getEstatus());
            }
        }else{
            $retorno = array('codigo' => 99, 'msg' => 'os campos vindos do front nao representam o metodo de consulta');
        }

        echo json_encode($retorno);
    }

    public function consultarUsuario(){
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);

        $lista = array("usuario"=>'0', "senha"=>'0');

        if(verificarParam($resultado, $lista)==1){
            $this->setUsuario($resultado->usuario);
            $this->setSenha($resultado->senha);


            if ($this->getEstatus() != "D" && $this->getEstatus() != "") {
                $retorno = array('codigo' => 4, 'msg' => 'status nao condiz com o permitido');
            } else {
                $this->load->model('M_aluno');

                $retorno = $this->M_aluno->consultarUsuario($this->getUsuario(),$this->getSenha(),$this->getEstatus());
            }
        } else {
            $retorno = array('codigo' => 99, 'msg' => 'os campos vindos do front nao representam o metodo de consulta');
        }

        echo json_encode($retorno);
    }
}