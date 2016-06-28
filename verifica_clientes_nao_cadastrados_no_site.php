<?php
			//Conexao-----------------------------------------------------------------------------
			$params = array();
			$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );

			global $conninfo;
			$conninfo = array("Database" => "monitoramento", "ReturnDatesAsStrings" => true , "UID" => "sa", "PWD" => "spotGF2008", "CharacterSet" => "UTF-8");
			$connection = sqlsrv_connect("192.168.0.6", $conninfo);
			//Fim Conexao ------------------------------------------------------------------------

			$sql = "SELECT * FROM CLIENTE WHERE CLI_MONITORADO = 'true' AND(CLI_ULTIMA_COMUNICACAO > '18/11/2015')";
			$stmt = sqlsrv_query( $connection, $sql , $params, $options );
			$row_count = sqlsrv_num_rows( $stmt );

			$conta = 0;
			$conta2 = 0;
		if($stmt){
			while($reg = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
			
			$cliente = $reg["cli_codigo"];

			//Verifica se ja existe dados na tabela
			$sql = "SELECT * FROM LEITOR WHERE EVE_CODIGO_CLIENTE = ".$cliente;
			$leitor = sqlsrv_query( $connection, $sql , $params, $options );
			$row_count_leitor = sqlsrv_num_rows( $leitor );

			if($row_count_leitor > 0){
				echo"Cliente OK: ".$cliente."<br>";
				$conta2 = $conta2+1;
			}else{
				echo"Cliente Erro: ".$cliente."<br>";
				$conta = $conta+1;

							}

		}
		echo "<p> Conta: ".$conta;
		echo "<p> Conta: ".$conta2;

		}else{

		echo "<p>Sua pesquisa não retornou nenhum resultado válido.</p>";

			}

		?>


