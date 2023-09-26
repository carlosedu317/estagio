<?php
defined('BASEPATH') or exit('No direct script access allowed');

include_once("M_documentacao.php");
include_once("M_atendimento.php");
include_once("M_professor.php");
include_once("M_aluno.php");

class M_documentacao extends CI_Model
{
    public function inserirDoc($semestreAno, $ra, $tcer, $tcenr, $desc_atividades, $relAtividades, $rescisao, $ficha_valid, $relEquivalencia, $observacao, $estatus)
    {
        $aluno = new M_aluno();
        $retornoAluno = $aluno->consultarSoAluno($ra);

        if ($retornoAluno['codigo'] == 1) {
            $sql = "INSERT INTO documentacao (semestre_ano, ra_aluno, tcer, tcenr, desc_atividades, ficha_valid_estagio, rel_atividades, rescisao, rel_equivalencia, observacoes, estatus) VALUES
            ('$semestreAno', '$ra', '$tcer', '$tcenr', '$desc_atividades', '$ficha_valid', '$relAtividades', '$rescisao', '$relEquivalencia', '$observacao', '$estatus')";

            $this->db->query($sql);

            if ($this->db->affected_rows() > 0) {
                $dados = array('codigo' => 1, 'msg' => 'Documentação registrada com sucesso.');
            } else {
                $dados = array('codigo' => 2, 'msg' => 'Houve algum problema ao registrar a documentação.');
            }
        } else {
            $dados = array('codigo' => 3, 'msg' => 'Aluno não existente no banco de dados.');
        }

        return $dados;
    }
    public function consultarDoc($semestreAno, $ra, $tcer, $tcenr, $desc_atividades, $ficha_valid, $relAtividades, $rescisao, $relEquivalencia, $observacao, $estatus)
    {
        $sql = "SELECT * FROM documentacao WHERE estatus = '$estatus'";

        if (!empty($semestreAno)) {
            $sql .= " AND semestre_ano = '$semestreAno'";
        }
        if (!empty($ra)) {
            $sql .= " AND ra_aluno = '$ra'";
        }
        if (!empty($tcer)) {
            $sql .= " AND tcer = '$tcer'";
        }
        if (!empty($tcenr)) {
            $sql .= " AND tcenr = '$tcenr'";
        }
        if (!empty($desc_atividades)) {
            $sql .= " AND desc_atividades = '$desc_atividades'";
        }
        if (!empty($ficha_valid)) {
            $sql .= " AND ficha_valid_estagio = '$ficha_valid'";
        }
        if (!empty($relAtividades)) {
            $sql .= " AND rel_atividades = '$relAtividades'";
        }
        if (!empty($rescisao)) {
            $sql .= " AND rescisao = '$rescisao'";
        }
        if (!empty($relEquivalencia)) {
            $sql .= " AND rel_equivalencia = '$relEquivalencia'";
        }
        if (!empty($observacao)) {
            $sql .= " AND observacoes = '$observacao'";
        }

        $retorno = $this->db->query($sql);

        if ($retorno->num_rows() > 0) {
            $dados = array('codigo' => 1, 'msg' => 'Consulta efetuada com sucesso', 'dados' => $retorno->result());
        } else {
            $dados = array('codigo' => 2, 'msg' => 'Dados não encontrados');
        }

        return $dados;
    }
    public function consultaSoDocumentacao($semestre_ano)
    {
        $sql = "SELECT * FROM documentacao WHERE semestre_ano = $semestre_ano";

        $retorno = $this->db->query($sql);

        if ($retorno->num_rows() > 0) {
            $dados = array('codigo' => 1, 'msg' => 'Consulta efetuada com sucesso');
        } else {
            $dados = array('codigo' => 2, 'msg' => 'Dados não encontrados');
        }

        return $dados;
    }
    public function alterarDoc($semestreAno, $ra, $tcer, $tcenr, $desc_atividades, $ficha_valid, $relAtividades, $rescisao, $relEquivalencia, $observacao)
    {
        $retornoDocumento = $this->consultaSoDocumentacao($semestreAno);

        if ($retornoDocumento['codigo'] == 1) {
            $sql = "UPDATE documentacao SET ";

            if (!empty($tcer)) {
                $sql .= "tcer = '$tcer', ";
            }
            if (!empty($tcenr)) {
                $sql .= "tcenr = '$tcenr', ";
            }
            if (!empty($desc_atividades)) {
                $sql .= "desc_atividades = '$desc_atividades', ";
            }
            if (!empty($ficha_valid)) {
                $sql .= "ficha_valid_estagio = '$ficha_valid', ";
            }
            if (!empty($relAtividades)) {
                $sql .= "rel_atividades = '$relAtividades', ";
            }
            if (!empty($rescisao)) {
                $sql .= "rescisao = '$rescisao', ";
            }
            if (!empty($relEquivalencia)) {
                $sql .= "rel_equivalencia = '$relEquivalencia', ";
            }
            if (!empty($observacoes)) {
                $sql .= "observacoes = '$observacao', ";
            }

            $sql = rtrim($sql, ', ');
            $sql .= " WHERE semestre_ano = '$semestreAno' AND ra_aluno = '$ra'";

            $this->db->query($sql);

            if ($this->db->affected_rows() > 0) {
                $dados = array('codigo' => 1, 'msg' => 'Documentação atualizada com sucesso.');
            } else {
                $dados = array('codigo' => 2, 'msg' => 'Problemas ao atualizar a documentação');
            }
        } else {
            $dados = array('codigo' => 3, 'msg' => 'Semestre e ano não existem no banco');
        }

        return $dados;
    }
    public function consultaSoSemestreRa($semestre_ano,$ra){
        $sql = "SELECT * FROM documentacao WHERE semestre_ano = $semestre_ano AND ra_aluno = '$ra'";
        $retorno = $this->db->query($sql);
    
        if ($retorno->num_rows() > 0) {
            $dados = array('codigo' => 1, 'msg' => 'Consulta efetuada com sucesso');
        } else {
            $dados = array('codigo' => 2, 'msg' => 'Dados não encontrados');
        }
    
        return $dados;

    }
    public function apagaDoc($semestre_ano, $ra)
    {
        $retornoDocumento = $this->consultaSoSemestreRa($semestre_ano, $ra);
    
        if ($retornoDocumento['codigo'] == 1) {
            $sql = "SELECT * FROM documentacao WHERE semestre_ano = $semestre_ano AND ra_aluno = '$ra' AND estatus = 'D'";
            $this->db->query($sql);
    
            if ($this->db->affected_rows() > 0) {
                $dados = array('codigo' => 0, 'msg' => 'Documentação já apagada');
            } else {
                $sql = "UPDATE documentacao SET estatus = 'D' WHERE semestre_ano = $semestre_ano AND ra_aluno = '$ra'";
                $this->db->query($sql);
    
                if ($this->db->affected_rows() > 0) {
                    $dados = array('codigo' => 1, 'msg' => 'Documentacao desativada corretamente');
                } else {
                    $dados = array('codigo' => 2, 'msg' => 'Houve algum problema na desativação da documentacao');
                }
            }
        } else {
            $dados = array('codigo' => 3, 'msg' => 'Semestre e RA não estão na base de dados');
        }
    
        return $dados;
    }
    public function ativaDoc($semestre_ano, $ra)
    {
        $retornoDocumento = $this->consultaSoSemestreRa($semestre_ano, $ra);
    
        if ($retornoDocumento['codigo'] == 1) {
            $sql = "SELECT * FROM documentacao WHERE semestre_ano = $semestre_ano AND ra_aluno = '$ra' AND estatus = ''";
            $this->db->query($sql);
    
            if ($this->db->affected_rows() > 0) {
                $dados = array('codigo' => 0, 'msg' => 'Documentação já ativada');
            } else {
                $sql = "UPDATE documentacao SET estatus = '' WHERE semestre_ano = $semestre_ano AND ra_aluno = '$ra'";
                $this->db->query($sql);
    
                if ($this->db->affected_rows() > 0) {
                    $dados = array('codigo' => 1, 'msg' => 'Documentacao ativada corretamente');
                } else {
                    $dados = array('codigo' => 2, 'msg' => 'Houve algum problema na ativação da documentacao');
                }
            }
        } else {
            $dados = array('codigo' => 3, 'msg' => 'Semestre e RA não estão na base de dados');
        }
    
        return $dados;
    }
    
}
