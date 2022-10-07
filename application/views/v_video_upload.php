<?php
defined('BASEPATH')OR exit('No direct script access allowed');

?>

<div class="container" style="margin-top: 60px;">
    <div class="well bp-component">
            <legend>UPLOAD FILE VIDEO</legend>

<?php
$tum="";

echo form_open_multipart('video/do_upload'.$tum);
echo "<input type='file' id='userfile' name='userfile' size='20' accept='video/mp4' />";
echo "<input type='hidden' id='id_vid_baru' name='id_vid_baru' value='".$id_vid_baru."' />";
echo "<input type='submit' id='tbupload' onclick='return cekfile()' name='submit' value='upload' /> ";
echo "</form>";
?>
<br>
        <button class="btn btn-default" onclick = "window.open('<?php echo base_url();?>video','_self')">Batal</button>
</div>
</div>

<script src="<?php echo base_url()?>js/jquery-3.4.1.js"></script>

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
