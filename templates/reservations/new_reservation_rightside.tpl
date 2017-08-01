{$msg}
<table class="table table-striped">
        <tr>
		<td width="20">&nbsp;</td>
                <td><b>Bunk</b></td>
                <td><b>Status</b></td>
                <td><b>Price</b></td>
                <td><b>Time Left</b></td>
        </tr>
        {$bunks}
	{if $bunks eq ""}
	<tr><td colspan="5"><font color="blue">Please select a stateroom to continue.</font></td></tr>
	<script>
		document.getElementById('gotopax').disabled=true;
	</script>
	{/if}
	{if $bunks ne ""}
	<script>
		document.getElementById('gotopax').disabled=false;
	</script>
	{/if}
</table>
