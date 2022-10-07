<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$namahari = array("MINGGU", "SENIN", "SELASA", "RABU", "KAMIS", "JUM'AT", "SABTU", "MINGGU");

$jml_acara = 0;

foreach ($dafacara as $datane) {
    $jml_acara++;
    $id[$jml_acara] = $datane->id;
    $jam[$jml_acara] = $datane->jam;
    $acara[$jml_acara] = $datane->acara;
}

?>


<main id="myContainer" class="MainContainer">

</main>


<div id="myModal" class="Modal is-hidden is-visuallyHidden">
    <!-- Modal content -->
    <div class="Modal-content" style="max-width: 500px">
        <span id="closeModal" class="Close">&times;</span>
        <?php if ($this->session->userdata('loggedIn')) { ?>
            <p>Jadwal Acara</p><br>
            <div style="text-align: left">Jam</div>
            <input type="text" class="form-control" id="iteksjam" name="iteksjam" maxlength="100"
                   value="" placeholder="00:00 WIB - 01:00 WIB">
            <div style="text-align: left">Acara</div>
            <input type="text" class="form-control" id="iteksacara" name="iteksacara" maxlength="100"
                   value="" placeholder="HALO INDONESIA">
            <input type="hidden" id="iteksid" name="iteksid">
            <button type="button" onclick="tutupmodal()" class="btn btn-success"
                    style="float:right;margin-right:10px;margin-top:10px;">Batal
            </button>
            <button id="tbtambah" type="button" onclick="ditambahsoal()" class="btn btn-success"
                    style="float:right;margin-right:10px;margin-top:10px;">Tambahkan
            </button>
            <button id="tbupdate" type="button" onclick="dieditsoal()" class="btn btn-success"
                    style="display:none;float:right;margin-right:10px;margin-top:10px;">Update
            </button>
        <?php } else { ?>
            <p>Silakan login terlebih dahulu</p><br>
        <?php } ?>
    </div>
</div>

<script src="<?php echo base_url() ?>js/jquery-3.4.1.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/blur.js"></script>

<div style="color:#000000;margin-left:10px;margin-right:10px;background-color:white;margin-top: 60px;">
    <br>
    <center>

        <span style="font-size:20px;font-weight:Bold;">LIVE YOUTUBE</span>
        <br><br>

        <div style="text-align: center; max-width: 500px; width: 100%">
            <?php
            echo form_open('seting/updateurl_live');
            ?>
            <div>
                <fieldset>
                    <div>
                        <label for="inputDefault" class="col-md-12 control-label">Alamat URL</label>
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

    </center>

    <br>
<!--    <button onclick="window.open('<?php //echo base_url(); ?>//seting/url_live/0','_self');" type="button">Minggu</button>
    <button onclick="window.open('<?php //echo base_url(); ?>//seting/url_live/1','_self');" type="button">Senin</button>
    <button onclick="window.open('<?php //echo base_url(); ?>//seting/url_live/2','_self');" type="button">Selasa</button>
    <button onclick="window.open('<?php //echo base_url(); ?>//seting/url_live/3','_self');" type="button">Rabu</button>
    <button onclick="window.open('<?php //echo base_url(); ?>//seting/url_live/4','_self');" type="button">Kamis</button>
    <button onclick="window.open('<?php //echo base_url(); ?>//seting/url_live/5','_self');" type="button">Jumat</button>
    <button onclick="window.open('<?php //echo base_url(); ?>//seting/url_live/6','_self');" type="button">Sabtu</button>
-->

<!--    --><?php //if ($jml_acara <= 20) { ?>
<!--        <button type="button" onclick="return ditambah()"-->
<!--                style="float:right;margin-right:40px;margin-bottom:10px;">Tambah-->
<!--        </button>-->
<!--        <button type="button" onclick="kurangisoal()"-->
<!--                style="float:right;margin-right:5px;margin-bottom:10px;">Kurangi-->
<!--        </button>-->
<!--    --><?php //} ?>
    <div id="tabel1" style="margin-left:10px;margin-right:10px;">
        <table style="color: black" id="tbl_user" class="table table-striped table-bordered nowrap" cellspacing="0"
               width="100%">
            <thead>
            <tr>
                <th style='width:250px;'>Nomor</th>
                <th style=''>Jam</th>
                <th style=''>Acara</th>
                <th style=''>Edit</th>
            </tr>
            </thead>

            <tbody>
            <?php for ($i = 1; $i <= $jml_acara; $i++) {
                ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $jam[$i]; ?></td>
                    <td><?php echo $acara[$i]; ?></td>
                    <td>
                        <button onclick="diedit('<?php echo $i; ?>')" type="button">Edit</button>
						<button onclick="diseting('<?php echo $i; ?>')" type="button">Seting</button>
                    </td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>

    </div>
</div>


<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/dataTables.bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/fixedHeader.bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/responsive.bootstrap.min.css">


<style type="text/css" class="init">
    .text-wrap {
        white-space: normal;
    }

    .width-200 {
        width: 200px;
    }
</style>

<script>
    var indeks;
    $(document).ready(function () {
        var table = $('#tbl_user').DataTable({
            'responsive': true,
            'columnDefs': [
                {
                    render: function (data, type, full, meta) {
                        return "<div class='text-wrap width-50'>" + data + "</div>";
                    },
                    targets: [1, 2]
                },
                {
                    width: 25,
                    targets: 0
                }
            ]

        });


        new $.fn.dataTable.FixedHeader(table);

        // Handle click on "Expand All" button
        $('#btn-show-all-children').on('click', function () {
            // Expand row details
            table.rows(':not(.parent)').nodes().to$().find('td:first-child').trigger('click');
        });

        // Handle click on "Collapse All" button
        $('#btn-hide-all-children').on('click', function () {
            // Collapse row details
            table.rows('.parent').nodes().to$().find('td:first-child').trigger('click');
        });
    });

    function ditambahsoal() {
        var jame = $('#iteksjam').val();
        var acarae = $('#iteksacara').val();

        if (jame.length > 3 && acarae.length > 3) {
            $.ajax({
                url: "<?php echo base_url(); ?>seting/addacara",
                method: "POST",
                data: {jame: jame, acarae: acarae, harike:<?php echo $harike;?>, urutan:<?php echo ($jml_acara+1);?>},
                success: function (result) {
                    window.open('<?php echo base_url(); ?>seting/url_live/<?php echo $harike;?>', '_self');
                }
            })
        }
        else {
            alert("Tulis soalnya dahulu dengan benar!")
        }
    }

    function ditambah() {
        $('#tbupdate').hide();
        $('#tbtambah').show();

        bukamodal();
        $('#iteksjam').val('');
        $('#iteksacara').val('');
    }

    function diedit(idx) {
        indeks = idx;
        var isi0 = new Array();
        var isi1 = new Array();
        var isi2 = new Array();
        <?php
        for ($a = 1; $a <= $jml_acara; $a++) {
            echo "isi0[" . $a . "]='" . $id[$a] . "';";
            echo "isi1[" . $a . "]='" . $jam[$a] . "';";
            echo "isi2[" . $a . "]='" . $acara[$a] . "';";
        }
        ?>

        $('#tbupdate').show();
        $('#tbtambah').hide();

        bukamodal();
        $('#iteksid').val(isi0[idx]);
        $('#iteksjam').val(isi1[idx]);
        $('#iteksacara').val(isi2[idx]);
    }

    function dieditsoal() {
        var idee = $('#iteksid').val();
        var jame = $('#iteksjam').val();
        var acarae = $('#iteksacara').val();

        //alert (idee);

        $.ajax({
            url: "<?php echo base_url(); ?>seting/editAcara",
            method: "POST",
            data: {ide: idee, jame: jame, acarae: acarae},
            success: function (result) {
                window.open('<?php echo base_url(); ?>seting/url_live/<?php echo $harike;?>', '_self');
            }
        })
    }

    function kurangisoal() {
        var r = confirm("Yakin mau mengurangi 1 acara?");
        if (r == true) {
            $.ajax({
                url: "<?php echo base_url(); ?>seting/kurangAcara",
                method: "POST",
                data: {urutan: <?php echo $jml_acara;?>,harike:<?php echo $harike;?>},
                success: function (result) {
                    window.open('<?php echo base_url(); ?>seting/url_live/<?php echo $harike;?>', '_self');
                }
            });
        } else {
            return false;
        }
        return false;
    }

    function diseting()
	{
		window.open('<?php echo base_url(); ?>seting/seting_live','_self');
	}

</script>
