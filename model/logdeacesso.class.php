<?php 

/*
 * 	Descrição do Arquivo
 * 	@autor - Ivan Simionato
 * 	@data de criação - 22/09/2013
 * 	@arquivo - historia.class.php
 */

class logdeacesso{

	//Atributos

	private $id;
	private $usuario_id;
	private $dataAcesso;

	//Getters

	public function getId(){
	    return $this->id;
	}
	 
	public function getUsuario_id(){
		return $this->usuario_id;
	}

	public function getDataAcesso(){
	    return $this->dataAcesso;
	}

	//Setters

	public function setId($id){
		$this->id = $id;
	}

	public function setUsuario_id($usuario_id){
		$this->usuario_id = $usuario_id;
	}

	public function setDataAcesso($dataAcesso){
		$this->dataAcesso = $dataAcesso;
	}

}