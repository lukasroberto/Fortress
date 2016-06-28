<?php 

/**
<<<<<<< HEAD
 *
 * Projeto : Gerenciador Fortress
 * Baseado em um projeto Interdisciplinar da : UNIFeob - Fundação de Ensino Octávio Bastos
 * Turma III - Análise e Desenvolvimento de Sistema
 * 
 * Objetivo
 *
 * Prover os métodos de salvar, atualizar e remover de forma genérica para ser usada
 * pelos controllers.
 *
 *
 * Versões
 *
 * 0.0.1 - Criação da classe - Osvaldo Gusmão
 * 0.0.2 - Alteração do método execute_query() - Osvaldo Gusmão
 * 0.0.3 - Inclusão do método loadObject() - Osvaldo Gusmão
 * 0.0.4 - Inclusão do método listObjects() - Osvaldo Gusmão
 */

require_once("../../functions/reflection.class.php");
require_once("../../functions/connection.class.php");


abstract class Crud {


    /**
     *
     * Atributos
     * 
     * */
    private $tabela;

    /**
     *
     * @method __contructor()
     *
     * @param $tabela (Nome da tabela que será presistida no banco de dados)
     *
     * */
    public function __construct($tabela) {
        $this->tabela = $tabela;
    }

    /**
     *
     * Métodos Getter
     *
     * */
    public function getTabela() {
        return $this->tabela;
    }

    /**
     *
     * @method save
     * @param $object (Objeto que será persitido no banco de dados)
     * @return true || false
     *
     * */
    public function save($object, $campoEncrypt = NULL) {

        $ref = new Reflections();
        $values = $ref->convert($object);

        $sql = "insert into " . $this->tabela;
        $sql .= " (" . implode(",", $values['fields']) . ") VALUES ( ";

        $size = count($values['fields']);
        $loop = 1;

        for ($j = 0; $j < $size; $j++) {

            if($values['fields'][$j] == $campoEncrypt){
                    $sql .= ' Convert(varbinary(100), pwdEncrypt(' . $ref->get_value_by_type($values['values'][$j])."))";
            }else{
                    $sql .= $ref->get_value_by_type($values['values'][$j]);
            }

            $sql .= ($loop < $size) ? "," : "";
            $loop++;
        }

        $sql .= " ) ;";

        return $this->execute_query($sql);
    }

    /**
     *
     * @method update
     * @param $object (Objeto que será persitido no banco de dados)
     * @param $attr (Atributo usado na condição where)
     * @return true || false
     *
     * */
    public function update($object, $attr, $attribute, $campoEncrypt) {

        if (empty($attr))
            return false;

        $ref = new Reflections();
        $values = $ref->convert($object);

        $sql = "update " . $this->tabela . " set ";

        $size = count($values['fields']);
        $loop = 1;

        for ($j = 0; $j < $size; $j++) {

            if ($values['fields'][$j] != $attr) {
                if($values['fields'][$j] == 'log_senha'){
                    $sql .= $values['fields'][$j] . ' = Convert(varbinary(100), pwdEncrypt(' . $ref->get_value_by_type($values['values'][$j])."))";
                }else{
                    $sql .= $values['fields'][$j] . ' = ' . $ref->get_value_by_type($values['values'][$j]);
                }
                $sql .= ($loop < $size) ? ", " : " ";
            }
            $loop++;
        }

        //$attribute = $ref->get_value_by_type($values['values'][array_search($attr, $values['fields'])]);

        $sql .= "where " . $attr . " = " . $attribute . " ;";

        return $this->execute_query($sql);
    }

    /**
     *
     * @method remove
     * @param $value (valor que será usado na condição where)
     * @param $attr (Atributo usado na condição where)
     * @return true || false
     *
     * */
    public function remove($value, $attr) {

        if (empty($attr))
            return false;

        $sql = "delete from " . $this->tabela . " where " . $attr . " = " . $value . " ;";

        return $this->execute_query($sql);
    }

    /**
     *
     * @method load
     * @param $value (valor que será usado na condição where)
     * @param $attr (Atributo usado na condição where)
     * @return false || Array
     *
     * */
    public function load($value, $attr) {

        if (empty($attr))
            return false;

        $sql = "select * from " . $this->tabela . " where " . $attr . " = " . $value . " ;";

        return sqlsrv_fetch_array($this->execute_query($sql));
    }

    /**
     *
     * @method loadObject
     * @param $value (valor que será usado na condição where)
     * @param $attr (Atributo usado na condição where)
     * @return false || Object
     *
     * */
    public function loadObject($value, $attr) {

        if (empty($attr))
            return false;

        $sql = "select * from " . $this->tabela . " where " . $attr . " = " . $value . " ;";

        return sqlsrv_fetch_object($this->execute_query($sql), $this->tabela);
    }

    /**
     *
     * @method listObject()
     * @return Objects (Tipados)
     *
     * */
    public function listObjects($where=NULL) {
		
		if($where){
			$resultado = $this->execute_query("SELECT * FROM " . $this->getTabela() . " WHERE ".$where." ;");
		}else{
			$resultado = $this->execute_query("SELECT * FROM " . $this->getTabela());
		}

        $regs = sqlsrv_num_rows($resultado);
        if ($regs == false) {
            return $resultado;
        }
    }

    /**
     *
     * @method execute_query
     * @param $sql (SQL Script que será executado no banco)
     * @return true || false
     *
     * */
    public function execute_query($sql) {
		
       	global $conn;
	    $params = array();
		$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
		
		$conn = new Connection;
        $conn->openConnection();
        $executed = sqlsrv_query($conn->getConnection(),$sql,$params,$options) or die("Error: ". sqlsrv_errors(). " with query ". $sql);

    	return $executed;
		$conn->closeConnection();
	}
}
?>

