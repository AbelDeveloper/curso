<div class="container">
    <h3 class="bg-info" align="center">
        <?PHP echo $this->session->flashdata('mensaje');?>
    </h3>
    <h2>Ingresar Nueva Observación</h2>
    <form class="form-signin" role="form" method="post" action="<?PHP echo base_url(); ?>index.php/estado_conservacion/grabar">


        <table class="table table-condensed" >
            <tr>
                <td>Estado de Conservación :</td>
                <td>
                    <select class="form-control" name="estado" id="estado" required="">
                        <option VALUE="0"></option>
                        <?php
                        foreach ($conservacion_estado as $value){?>
                        <option value="<?php echo $value['ID']?>"><?php echo $value['CONSERVACION_ESTADO']?></option>
                        <?php
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Observaciones :</td>
                <td><div style="height: 300px;overflow-y: auto;border:1px solid #D8D8D8;border-radius: 5px;padding-left: 10px;"><table id="tbl-obs" style="width: 100%;">

                        </table></div></td>

                <!--<td><div id="obs" style="border:1px solid #D8D8D8;height: 200px;overflow-y: auto;padding-left: 10px;border-radius: 5px;"></div></td>-->

            </tr>
            <tr>
                <td>Nuevo :</td>
                <td><input type="text" class="form-control" name="new" required=""></td>
            </tr>
            <tr>
                <td colspan="2"><input class="btn btn-primary" type="submit" value="Guardar"/></td>
            </tr>
        </table>
    </form>
</div>

<div style="width: 100%;text-align: center;font-size: 16px;">
<?php echo $this->session->userdata('mensaje');?>
</div>

<script>


 $("#estado").change(function(){

      var estado_id = $(this).val();
     $("#tbl-obs").html('');
     $.getJSON('<?php echo base_url() ?>index.php/estado_conservacion/listar',{id:estado_id})
      .done(function(json){
          var label = '';

          $.each(json,function(index,value){
              console.log(value);
              label+= '<tr style="border-bottom:1px solid #D8D8D8;"><td>' +  value.OBSERVACION_INOPERATIVIDAD  + '</td>';
              var nivel = "<?php echo $this->session->userdata('nivel');?>";
              if( nivel==1){
                  label+= '<td><a class="btn btn-primary" href="<?php echo base_url()?>index.php/estado_conservacion/editar/'+value.ID+'">Editar</a></td>';
                  label+= '<td><a class="btn btn-primary" onclick="eliminar('+value.ID+')">Eliminar</a></td></tr>';
              }else{
                  label+= '<td></td>';
                  label+= '<td></tr>';
              }

          });

          $("#tbl-obs").html(label);



      });


 });

 function eliminar($id){

          if(confirm("¿Esta seguro de eliminar observación?")){
            window.location.href= "<?php echo base_url()?>index.php/estado_conservacion/eliminar/"+$id;
          }

   }


</script>
