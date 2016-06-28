/* ========================================================================
Script para criar uma tela de seleção de varios objetos

Script usado por:
relat_eventos_alarme.php
 * ======================================================================== */

    var nomeObjetoSelecionado;
    var campoPai;
    var divSelecionados;
    var btSelecionar;
    var codigo;
    var resultados;
    var pesquisa;
    var filho;
    var array = [];



function selecionaObjetos(cod) {

        //adiciona campo apenas para visualizar o clinte selecionado no modal 
        var objPai = document.getElementById(campoPai);
        //Criando o elemento DIV;
        var objFilho = document.createElement("div");
        //Definindo atributos ao objFilho:
        objFilho.setAttribute("id",filho+cod);
        objFilho.setAttribute("class", "btn-group");
        objFilho.setAttribute("role", "group");
        objFilho.setAttribute("aria-label", "First group");

        //Inserindo o elemento no pai:
        objPai.appendChild(objFilho);
        //Escrevendo algo no filho recém-criado:
        document.getElementById(filho+cod).innerHTML =  "<button type='button' class='btn btn-default'>"+cod+"</button>    <button style='padding:0px' type='button' class='btn btn-danger dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' onclick=apaga('"+filho+cod+"','"+cod+"')>      <span style='font-size: 12px' class='glyphicon glyphicon-remove'></span>  </button>";
        document.getElementById(divSelecionados).style.display = 'block';
        document.getElementById(btSelecionar).setAttribute("class", "btn btn-success");
        document.getElementById(btSelecionar).value = nomeObjetoSelecionado;
}
    
//adiciona id no array conforme click no cliente
    function addArray(cod) {
        var i = array.indexOf(cod);

        if(i == -1) {
            array.push(cod);
            document.getElementById(codigo).value=array;
            selecionaObjetos(cod);
        }

    }
    //
        function limparArray() {
            array.length = 0;
            document.getElementById(codigo).value="";
            document.getElementById(campoPai).innerHTML="<button type='button' style='float: right' class='btn btn-danger' data-dismiss='modal' onclick='limparArray()''>Limpar</button><button type='button' style='float: right' class='btn btn-success' data-dismiss='modal'>OK</button>"
        }

    function imprimeArray() {
      for (i=0; i<array.length; i++) {
        document.write(array[i] + "<BR>");}
  }

//Recebe o id do campo e id do cliente para apagar da tela e do array.
    function apaga(campo,cod) {
        var excluir =document.getElementById(campo);
        var objPai = document.getElementById(campoPai);
        var i = array.indexOf(cod);

        if(i != -1) {
            array.splice(i, 1);
            document.getElementById(codigo).value=array;
        }

        objPai.removeChild(excluir);
    }

function listaBancoDeDados(paginaDeRetornoSql){

        //LISTA TODOS ANTES DE FILTRAR
        $.post(paginaDeRetornoSql, function(retorna){     
        $("."+resultados).html(retorna);
        });
        
        //PESQUISA INSTANTANEA PELO INPUT
        $(pesquisa).keyup(function(){
            //Recupera oque está sendo digitado no input de pesquisa
            var pesquisa    = $(this).val();

            //Recupera oque foi selecionado
            var campo               = $(campo).val();

            //Verifica se foi digitado algo
            if(pesquisa != ''){
                //Cria um objeto chamado de 'dados' e guarda na propriedade 'palavra' a pesquisa e na propriedade campo o campo a ser pesquisado
                var dados = {
                        palavra : pesquisa,
                        campo   : campo
                }
                        
                //Envia por AJAX pelo metodo post, a pequisa para o arquivo 'busca.php'
                //O paremetro 'retorna' é responsável por recuperar oque vem do arquivo 'busca.php'
                $.post(paginaDeRetornoSql, dados, function(retorna){
                        //Mostra dentro da ul com a class 'resultados' oque foi retornado
                        $("."+resultados).html(retorna);
                });
            }else{
                  $("."+resultados).html('');
                }
        });
        };