<?php

class empresa {

//atributos
private $emp_id;
private $emp_razao_social;
private $emp_endereco;
private $emp_bairro;
private $emp_cidade;
private $emp_telefone;
private $emp_email;
private $emp_cnpj;
private $emp_cep;
private $emp_uf;
private $emp_status;
//getters e setters
public function getId() {
return $this->emp_id;
}

public function setId($emp_id) {
$this->emp_id = $emp_id;
}

public function getRazaoSocial() {
return $this->emp_razao_social;
}

public function setRazaoSocial($emp_razao_social) {
$this->emp_razao_social = $emp_razao_social;
}

public function getEndereco() {
return $this->emp_endereco;
}

public function setEndereco($emp_endereco) {
$this->emp_endereco = $emp_endereco;
}

public function getBairro() {
return $this->emp_bairro;
}

public function setBairro($emp_bairro) {
$this->emp_bairro = $emp_bairro;
}

public function getCidade() {
return $this->emp_cidade;
}

public function setCidade($emp_cidade) {
$this->emp_cidade = $emp_cidade;
}

public function getTelefone() {
return $this->emp_telefone;
}

public function setTelefone($emp_telefone) {
$this->emp_telefone = $emp_telefone;
}

public function getEmail() {
return $this->emp_email;
}

public function setEmail($emp_email) {
$this->emp_email = $emp_email;
}

public function getCnpj() {
return $this->emp_cnpj;
}

public function setCnpj($emp_cnpj) {
$this->emp_cnpj = $emp_cnpj;
}

public function getCep() {
return $this->emp_cep;
}

public function setCep($emp_cep) {
$this->emp_cep = $emp_cep;
}

public function getUf() {
return $this->emp_uf;
}

public function setUf($emp_uf) {
$this->emp_uf = $emp_uf;
}

public function getStatus() {
return $this->emp_status;
}

public function setStatus($emp_status) {
$this->emp_status = $emp_status;
}

}