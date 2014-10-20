<?php

class chip {

//atributos
private $chip_codigo;
private $chip_imei;
private $chip_operadora;
private $chip_data_envio;
private $cli_codigo;
private $chip_status;


//getters e setters
public function getCodigo() {
return $this->chip_codigo;
}

public function setCodigo($chip_codigo) {
$this->chip_codigo = $chip_codigo;
}

public function getImei() {
return $this->chip_imei;
}

public function setImei($chip_imei) {
$this->chip_imei = $chip_imei;
}

public function getOperadora() {
return $this->chip_operadora;
}

public function setOperadora($chip_operadora) {
$this->chip_operadora = $chip_operadora;
}

public function getDataEnvio() {
return $this->chip_data_envio;
}

public function setDataEnvio($chip_data_envio) {
$this->chip_data_envio = $chip_data_envio;
}

public function getCliCodigo() {
return $this->cli_codigo;
}

public function setCliCodigo($cli_codigo) {
$this->cli_codigo = $cli_codigo;
}

public function getStatus() {
return $this->chip_status;
}

public function setStatus($chip_status) {
$this->chip_status = $chip_status;
}

}