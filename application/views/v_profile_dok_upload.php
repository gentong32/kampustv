
<?php

defined('BASEPATH')OR exit('No direct script access allowed');

?>

<div class="container" style="margin-top: 60px;">
    <div class="well bp-component">
            <legend>UPLOAD BERKAS PDF PERMOHONAN VERIFIKATOR</legend>

<?php
echo $error;
echo form_open_multipart('login/do_upload_dok');
echo "<input type='file' id='userfile' name='userfile' size='20' accept='.pdf' />";
echo "<input type='submit' id='tbupload' onclick='return cekfile()' name='submit' value='upload' /> ";
echo "</form>";
?>
<br>
    <button class="btn btn-default" onclick = "window.open('<?php echo base_url(); ?>login/profile','_self')">Batal</button>



</div>
</div>

<!--<script src="--><?php //echo base_url()?><!--js/jquery-3.4.1.js"></script>-->
<script src="<?php echo base_url(); ?>js/jquery-3.4.1.js"></script>
<script>
$(document).on('change', '#userfile', function() {
	if($('#userfile').val()!="")
    $('#tbupload').css("color", "#000000");

});

function cekfile()
{
    if($('#userfile').val()!="")
    {
        return true;
    }
    else
    {
        return false;
    }
}

</script>
