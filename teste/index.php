<script type="text/javascript">
// Start with an initial array
var array = ["1", "2", "3","lukas"];

        for (i=0; i<array.length; i++) {
            document.write(array[i] + "<BR>");}



var arrayCli = [];

function apaga(campo,cod_cliente) {
//        var excluir =document.getElementById(campo);
  //      var objPai = document.getElementById("campoPai");
        var i = array.indexOf(cod_cliente);

        if(i != -1) {
            array.splice(i, 1);
        document.write("i= "+i+ "<BR>"+"Cliente= "+cod_cliente+ "<BR> Campo= "+campo);
        }
        for (i=0; i<array.length; i++) {
            document.write(array[i] + "<BR>");}

       // objPai.removeChild(excluir);
    }

</script>
        <input type="button" value="imprime Array" onclick="apaga('campo','2')">

