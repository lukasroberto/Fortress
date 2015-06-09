<?php

class cliente {

//atributos
private $cli_codigo;
private $cli_nome;
private $cli_rua;
private $cli_numero;
private $cli_bairro;
private $cli_cidade;
private $cli_estado;
private $cli_telefone;
private $cli_cad_por;
private $cli_data_cad;
private $cli_telefone1;
private $cli_empresa;
private $cli_monitorado;

//getters e setters
public function getCodigo() {
return $this->cli_codigo;
}

public function setCodigo($cli_codigo) {
$this->cli_codigo = $cli_codigo;
}

public function getNome() {
return $this->cli_nome;
}

public function setNome($cli_nome) {
$this->cli_nome = $cli_nome;
}

public function getRua() {
return $this->cli_rua;
}

public function setRua($cli_rua) {
$this->cli_rua = $cli_rua;
}

public function getNumero() {
return $this->cli_numero;
}

public function setNumero($cli_numero) {
$this->cli_numero = $cli_numero;
}

public function getBairro() {
return $this->cli_bairro;
}

public function setBairro($cli_bairro) {
$this->cli_bairro = $cli_bairro;
}

public function getCidade() {
return $this->cli_cidade;
}

public function setCidade($cli_cidade) {
$this->cli_cidade = $cli_cidade;
}

public function getEstado() {
return $this->cli_estado;
}

public function setEstado($cli_estado) {
$this->cli_estado = $cli_estado;
}

public function getTelefone() {
return $this->cli_telefone;
}

public function setTelefone($cli_telefone) {
$this->cli_telefone = $cli_telefone;
}

public function getCadastradoPor() {
return $this->cli_cad_por;
}

public function setCadastradoPor($cli_cad_por) {
$this->cli_cad_por = $cli_cad_por;
}

public function getDataCadastro() {
return $this->cli_data_cad;
}

public function setDataCadastro($cli_data_cad) {
$this->cli_data_cad = $cli_data_cad;
}

public function getTelefoneSecundario() {
return $this->cli_telefone1;
}

public function setTelefonSecundario($cli_telefone1) {
$this->cli_telefone1 = $cli_telefone1;
}

public function getEmpresa() {
return $this->cli_empresa;
}

public function setEmpresa($cli_empresa) {
$this->cli_empresa = $cli_empresa;
}

public function getMonitorado() {
return $this->cli_monitorado;
}

public function setMonitorado($cli_monitorado) {
$this->cli_monitorado = $cli_monitorado;
}

}