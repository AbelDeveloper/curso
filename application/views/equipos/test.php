<div>
        <div>
            <input type="checkbox" id="dia1" name="dia1" value="lunes" checked="checked"/>
            <label for="dia1">Lunes</label>
        </div>
        <div>
            <input type="checkbox" id="dia2" name="dia2" value="martes"/>
            <label for="dia2">Martes</label>
        </div>
        <div>
            <input type="checkbox" id="dia3" name="dia3" value="miercoles"/>
            <label for="dia3">Miercoles</label>
        </div>
        <div>
            <input type="checkbox" id="dia4" name="dia4" value="jueves"/>
            <label for="dia4">Jueves</label>
        </div>
        <div>
            <input type="checkbox" id="dia5" name="dia5" value="viernes"/>
            <label for="dia5">Viernes</label>
        </div>
        <div>
            <input type="checkbox" id="dia6" name="dia6" value="sabado"/>
            <label for="dia6">Sabado</label>
        </div>
        <div>
            <input type="checkbox" id="dia7" name="dia7" value="domingo"/>
            <label for="dia7">Domingo</label>
        </div>
        <div>
            <input type="button" id="verDiasSeleccionados" value="Ver dias seleccionados">
        </div>
    </div>

<script type="text/javascript">
    $(document).ready(function() {



        // Comprobar los checkbox seleccionados
        $('#verDiasSeleccionados').on('click', function() {

            var diasSeleccionados = new Array();

            $('input[type=checkbox]:checked').each(function() {
                diasSeleccionados.push($(this).val());
            });

            alert("Dias seleccionados => " + diasSeleccionados);
        });

    });

</script>