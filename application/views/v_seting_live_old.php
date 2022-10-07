<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>

<?php //echo $url_live->url; ?>
<!--<link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap-datetimepicker.css">-->

<div class="center" style="margin-top: 60px;color: black">
    <center>
        <span style="font-size:20px;font-weight:Bold;">ALAMAT URL TVE LIVE YOUTUBE </span>
        <br><br>

        <div style="text-align: center; max-width: 500px; width: 100%">
            <?php
            echo form_open('seting/updateurl_live');
            ?>
            <div>
                <fieldset>
                    <div>
                        <label for="inputDefault" class="col-md-12 control-label">URL</label>
                            <input class="input_teks" size="60" type="text" id="url_baru" name="url_baru" placeholder="URL"
                                   value="<?php echo $url_live->url; ?>">
                            <br>
                    </div>

                </fieldset>
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Update</button>

            <?php
            echo form_close() . '';
            ?>
        </div>

        <div>
            <section class="mycolumns">
                <div class="mycolumn1">
                    <p>1</p>
                </div>
                <div class="mycolumn2">
                    <p>00:00 WIB - 00:30 WIB</p>
                </div>
                <div class="mycolumn3">
                    <p>INSPIRASI INDONESIA/ INSPIRASI EDUKASI</p>
                </div>
            </section>
            <section class="mycolumns">
                <div class="mycolumn1">
                    <p>2</p>
                </div>
                <div class="mycolumn2">
                    <p>00:30 WIB - 01:30 WIB</p>
                </div>
                <div class="mycolumn3">
                    <p>RUMAH RAHASIAKU</p>
                </div>
            </section>


        </div>
    </center>
</div>

<!-- echo form_open('dasboranalisis/update'); -->

<script src="<?php echo base_url() ?>js/jquery-3.4.1.js"></script>

<script>

    function takon() {
        // window.open("/tve/channel/playlistsekolah", "_self");
        return false;
    }

</script>

