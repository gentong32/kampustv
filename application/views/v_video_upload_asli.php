<?php
defined('BASEPATH')OR exit('No direct script access allowed');

?>

<div class="container" style="margin-top: 60px;">
    <div class="well bp-component">
            <legend>UPLOAD <?php if($thumbs) echo "THUMBNAIL"; else echo "FILE";?> VIDEO</legend>

<?php
$tum="";
if($thumbs)
$tum = "/".$idx;
echo $error;
echo form_open_multipart('video/do_upload'.$tum);
echo "<input type='file' id='userfile' name='userfile' size='20' />";
echo "<input type='submit' id='tbupload' onclick='return cekfile()' name='submit' value='upload' /> ";
echo "</form>";
?>
<br>
<?php if($thumbs) {?>
    <button class="btn btn-default" onclick = "window.open('<?php echo base_url(); ?>video/edit/<?php echo $idx;?>','_self')">Batal</button>
<?php } else
{?>
    <button class="btn btn-default" onclick = "window.open('<?php echo base_url(); ?>video','_self')">Batal</button>
<?php } ?>


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
