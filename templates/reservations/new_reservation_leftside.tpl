{$msg}
<table class="table table-striped">
        <tr>
                <td><b>Bunk</b></td>
                <td><b>Status</b></td>
                <td><b>Price</b></td>
                <td>&nbsp;</td>
        </tr>
        {$bunks}
</table>

<script>
$(document).ready (function(){
	$("#success-alert").alert();
        $("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
        	$("#success-alert").slideUp(500);
        });
});
</script>
