<?php

class os {

//atributos
private $os_id;
private $os_cliente;
private $os_data_ini;
private $os_ini_serv;
private $os_fim_serv;
private $os_serv_sol;
private $os_serv_efe;
private $os_status;
private $os_obs;
private $os_expedidor;
private $os_pecas_util;
private $os_pecas_retir;
private $os_solicitada_por;
private $os_tipo;

//getters e setters
public function getId() {
return $this->os_id;
}

public function setId($os_id) {
$this->os_id = $os_id;
}

public function getCodCliente() {
return $this->os_cliente;
}

public function setCodCliente($os_cliente) {
$this->os_cliente = $os_cliente;
}

public function getDataIni() {
return $this->os_data_ini;
}

public function setDataIni($os_data_ini) {
$this->os_data_ini = $os_data_ini;
}

public function getIniServ() {
return $this->os_ini_serv;
}

public function setIniServ($os_ini_serv) {
$this->os_ini_serv = $os_ini_serv;
}

public function getFimServ() {
return $this->os_fim_serv;
}

public function setFimServ($os_fim_serv) {
$this->os_fim_serv = $os_fim_serv;
}

public function getServSol() {
return $this->os_serv_sol;
}

public function setServSol($os_serv_sol) {
$this->os_serv_sol = $os_serv_sol;
}

public function getSevEfe() {
return $this->os_serv_efe;
}

public function setServEfe($os_serv_efe) {
$this->os_serv_efe = $os_serv_efe;
}

public function getStatus() {
return $this->os_status;
}

public function setStatus($os_status) {
$this->os_status = $os_status;
}

public function getObs() {
return $this->os_obs;
}

public function setObs($os_obs) {
$this->os_obs = $os_obs;
}

public function getExpedidor() {
return $this->os_expedidor;
}

public function setExpedidor($os_expedidor) {
$this->os_expedidor = $os_expedidor;
}

public function getPecasUtil() {
return $this->os_pecas_util;
}

public function setPecasUtil($os_pecas_util) {
$this->os_pecas_util = $os_pecas_util;
}

public function getPecasRetir() {
return $this->os_pecas_retir;
}

public function setPecasRetir($os_pecas_retir) {
$this->os_pecas_retir = $os_pecas_retir;
}

public function getSolPor() {
return $this->os_solicitada_por;
}

public function setSolPor($os_solicitada_por) {
$this->os_solicitada_por = $os_solicitada_por;
}

public function getTipo() {
return $this->os_tipo;
}

public function setTipo($os_tipo) {
$this->os_tipo = $os_tipo;
}



}