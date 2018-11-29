<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        function validateNumber(event) {
            var key = window.event ? event.keyCode : event.which;

            if (event.keyCode === 8 || event.keyCode === 46) {
                return true;
            } else if (key < 48 || key > 57) {
                return false;
            } else {
                return true;
            }
        }
        ;

        $("#form-masivo").submit(function(e){
              e.preventDefault();
              var formData = new FormData($(this)[0]);
              var url = "<?php echo base_url().'index.php/egresados/validarExcelImei';?>";

              $.ajax({
                 data:formData,
                 url:url,
                 type:'POST',
                 contentType: false,
	               processData: false
              }).done(function(res){
                    var json = JSON.parse(res);

                    if(json[0]==0){
                       alert("Error : Solo se permite archivos excel 97-2003");
                    }else if(json[0]==1){
                      if(json[2]<=0){
                        alert("Los imei no se encuentra en el almacén");
                      }else{
                        if(confirm("¿Devolver "+json[2]+" de "+json[1]+"?")){
                                 var formData = new FormData($("#form-masivo")[0]);
                                 var url = "<?php echo base_url().'index.php/egresados/grabarExcel';?>";
                                 $.ajax({
                                    data:formData,
                                    url:url,
                                    type:'POST',
                                    contentType: false,
                   	               processData: false
                                 }).done(function(res){
                                   console.log(res);
                                    window.location.href = res;
                                 })

                        }
                      }

                    }
              });
          });

        $("#NUMERO_DOCUMENTO").keypress(validateNumber);
        $("#TELEFONO").keypress(validateNumber);
        $("#tipo_documento").change(function(){
            if($("#tipo_documento").val() == '1'){
                $("#label_numero_doc").text('Numero de DNI');
                $("#NUMERO_DOCUMENTO").attr('minlength', '8');
                $("#NUMERO_DOCUMENTO").attr('maxlength', '8');
            }
            if($("#tipo_documento").val() == '2'){
                $("#label_numero_doc").text('Numero de Carnet de Extranjeria');
                $("#NUMERO_DOCUMENTO").attr('minlength', '10');
                $("#NUMERO_DOCUMENTO").attr('maxlength', '10');
            }
            if($("#tipo_documento").val() == '3'){
                $("#label_numero_doc").text('Numero de RUC');
                $("#NUMERO_DOCUMENTO").attr('minlength', '11');
                $("#NUMERO_DOCUMENTO").attr('maxlength', '11');
            }
        })


    });
</script>
<div class="container">
        <h2>Carga Masíva</h2>

        <?php
        if($this->session->flashdata('mensaje') != ''){?>
        <h3 class="bg-info" align="center">
            <?PHP echo $this->session->flashdata('mensaje');?>
        </h3>
        <?php
        }
        ?>

    <form id="form-masivo" method="post" action="<?php echo base_url() ?>index.php/egresados/grabarExcel" enctype="multipart/form-data">
        <table class="table table-condensed">

            <!--
            <tr>
                <td>OPCION 0 :</td>
                <td>
                    <select name="tipo_documento" id="tipo_documento" class="form-control">
                        <?php
                        foreach ($tipo_documentos as $value_documentos){?>
                        <option value="<?php echo $value_documentos['ID'];?>"><?php echo $value_documentos['TIPO_DOCUMENTO'];?></option>
                        <?php
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td><span id="label_numero_doc">OPCION 1 :</span>:</td>
                <td><input maxlength="8" maxlength="8" type="text" class="form-control" name="NUMERO_DOCUMENTO" id="NUMERO_DOCUMENTO"></td>
            </tr> -->
            <tr>
                <td>Devolucion :</td>
                <td colspan="2"><select class="form-control" name="devolucion">
                        <option value="2">DERIVADO A PNP</option>
                        <option value="3">OTROS</option>
                    </select></td>
            </tr>

            <tr>
                <td>Archivo Excel :</td>
                <td>
                    <input type="file" class="form-control" name="archivo" value="Seleccionar Excel">

                </td>
                <td><label><font size="5" color="red">Carga de archivo excel IMEI FÍSICO</font></label></td>
            </tr>
            <tr>
                <td>Observación:</td>

                <td COLSPAN="2"><textarea type="text" class="form-control" name="OBS" id="OBS" required></textarea></td>

            </tr>
            <tr>
                <input type="hidden" name="equipo_id" value=""/>
                <td style="padding-top: 20px" align="center" colspan="2"><input class="btn btn-primary" type="submit" value="Entregar"></td>
            </tr>
        </table>

    </form>
</div>
