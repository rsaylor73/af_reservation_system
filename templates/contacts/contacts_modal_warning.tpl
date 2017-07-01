{if $deceased eq "Y" || $donotbook eq "Y"}
<script type="text/javascript">
    $(window).on('load',function(){
        $('#myModal').modal('show');
    });
</script>
{/if}

{if $deceased eq "Y" || $donotbook eq "Y"}
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
                <div class="modal-content">
                        <div class="modal-header">
                                <h4 class="modal-title"><font color="red">WARNING</font></h4>
                        </div>
                        <div class="modal-body">
				{if $deceased eq "Y"}
                                	<p><strong>DECEASED</strong> The contact is listed as deceased.</p>
				{/if}
				{if $donotbook eq "Y"}
                                        <p><strong>DO NOT BOOK</strong> The contact is listed as do not book.</p>
				{/if}
                        </div>
                        <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                </div>
        </div>
</div>
{/if}
