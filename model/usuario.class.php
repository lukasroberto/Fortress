<?php

class login {

//atributos
private $log_id;
private $log_user;
private $log_pass;
private $log_nome;
private $log_senha_falada;
private $log_acesso_sistema;
private $log_nivel;

//getters e setters
public function getId() {
return $this->log_id;
}

public function setId($log_id) {
$this->log_id = $log_id;
}

public function getUser() {
return $this->log_user;
}

public function setUser($log_user) {
$this->log_user = $log_user;
}

public function getSenha() {
return $this->log_pass;
}

public function setSenha($log_pass) {
$this->log_pass = $log_pass;
}

public function getNome() {
return $this->log_nome;
}

public function setNome($log_nome) {
$this->log_nome = $log_nome;
}

public function getSenhaFalada() {
return $this->log_senha_falada;
}

public function setSenhaFalada($log_senha_falada) {
$this->log_senha_falada = $log_senha_falada;
}

public function getAcessoSistema() {
return $this->log_acesso_sistema;
}

public function setAcessoSistema($log_acesso_sistema) {
$this->log_acesso_sistema = $log_acesso_sistema;
}

public function getNivel() {
return $this->log_nivel;
}

public function setNivel($log_nivel) {
$this->log_nivel = $log_nivel;
}

}