<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$jml_promo = 0;
foreach ($dafpromo as $datane) {
    $jml_promo++;
    $idpromo[$jml_promo] = $datane->id;
    $kodepromo[$jml_promo] = $datane->kd_promo;
    $judul[$jml_promo] = $datane->judul;
    $subjudul[$jml_promo] = $datane->subjudul;
    $gambar[$jml_promo] = $datane->gambar;
	$gambar2[$jml_promo] = $datane->gambar2;
	$link[$jml_promo] = $datane->link;
    if ($datane->nama_file == null || $datane->nama_file == "")
        $adafile[$jml_promo] = "-";
    else
        $adafile[$jml_promo] = "Tersedia";
    $isipromo[$jml_promo] = $datane->isipromo;
    $pilihan[$jml_promo] = $datane->pilihan;
    if($datane->pilihan==0)
        $pilihan[$jml_promo] = '-';
    $dibuat[$jml_promo] = $datane->created;
}

?>



<!--<script src="--><?php //echo base_url() ?><!--js/jquery-3.4.1.js"></script>-->
<script src="<?php echo base_url(); ?>js/jquery-3.4.1.js"></script>

<div style="color:#000000;margin-left:10px;margin-right:10px;background-color:white;margin-top: 60px;">
    <br>
    <center>
        <span style="font-size:16px;font-weight: bold;"><?php echo $title; ?></span></center>
    <br>

        <button type="button" onclick="window.location.href='<?php echo base_url(); ?>promo/tambah'" class=""
                style="float:right;margin-right:10px;margin-top:-20px;">Tambah Promo
        </button>

    <!--	<button style="margin-left:10px" id="btn-show-all-children" type="button">Buka Semua</button>-->
    <!--	<button style="margin-left:10px" id="btn-hide-all-children" type="button">Tutup Semua</button>-->
    <hr>

    <div id="tabel1" style="margin-left:10px;margin-right:10px;">
        <table id="tbl_user" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th style='padding:5px ;width:5px;'>No</th>
                <th>Judul</th>
<!--                <th>Sub Judul</th>-->
                <th>Gambar Desktop</th>
				<th>Gambar Mobile</th>
                <th>Lampiran</th>
				<th>Link Event</th>
				<th>Tayang</th>
                <th>Edit</th>
                <th class="none">Isi Promo</th>
                <th class="none">Dibuat tanggal</th>
            </tr>
            </thead>

            <tbody>
            <?php
            for ($i = 1; $i <= $jml_promo; $i++) {
                ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $judul[$i]; ?></td>
<!--                    <td>--><?php //echo $subjudul[$i]; ?><!--</td>-->
                    <td><?php echo '<img src="'.base_url().'uploads/promo/'.$gambar[$i].'" width="100px">'?></td>
					<td><?php echo '<img src="'.base_url().'uploads/promo/'.$gambar2[$i].'" width="20px">'?></td>
                    <td style="text-align: center"><?php echo $adafile[$i];?></td>
					<td style="text-align: center"><?php echo $link[$i];?></td>
                    <td style="text-align: center"><button onclick="ubah(<?php echo $idpromo[$i];?>)" id="tb_ubah<?php echo $idpromo[$i];?>"><?php echo $pilihan[$i]; ?></button>
                        <div id="dtayang<?php echo $idpromo[$i];?>" style="display: none">
                            <span>Urutan</span>
                            <input id="itayang<?php echo $idpromo[$i];?>" type="text" style="width:20px;" maxlength="1" value="<?php echo $pilihan[$i]; ?>"/>
                            <button style="display: block" onclick="update(<?php echo $idpromo[$i];?>)" >Update</button>
                            <button style="display: block" onclick="jangan(<?php echo $idpromo[$i];?>)" >Tidak</button>
                            <button style="display: block" onclick="batal(<?php echo $idpromo[$i];?>)" >Batal</button>

                        </div>
                    </td>
                    <td><button onclick="window.location.href='<?php echo base_url(); ?>promo/edit/<?php echo $kodepromo[$i]; ?>'">Edit</button>
                        <button onclick="mauhapus('<?php echo $kodepromo[$i];?>')">Hapus</button></td>
                    <td><?php echo $isipromo[$i]; ?></td>
                    <td><?php echo $dibuat[$i]; ?></td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</div>

<!-- <div id="controls">
<h2>Play</h2>
<i id="play" class="material-icons">play_arrow</i>

<h2>Pause</h2>
<i id="pause" class="material-icons">pause</i>



<h2>Dynamically Queue Video</h2>
<img class="thumbnail" src="images/cat_video_1.jpg" data-video-id="Aas9SPY_k2M">
<img class="thumbnail" src="images/cat_video_2.jpg" data-video-id="KkFnm-7jzOA">
<img class="thumbnail" src="images/cat_video_3.jpg" data-video-id="Ph77yOQFihc">
</div> -->


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

<script src="https://www.youtube.com/iframe_api"></script>
<script src="<?php echo base_url(); ?>js/videoscript.js"></script>
<script>

    var oldurl = "";
    var oldurl2 = "";

    $(document).on('change', '#itahun', function () {
        get_analisis_view();
    });

    function get_analisis_view() {
        window.open("/rtf2/home/filter/" + $('#itahun').val() +
            "/" + $('#iformal').val() + "/" + $('#iseri').val() + "/" + $('#ijenjang').val() + "/" + $('#imapel').val(), "_self");
    }

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
				},
				{
					render: function (data, type, full, meta) {
						return "<div class='text-wrap width-50'>" + data + "</div>";
					},
					targets: [8]
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

    function ubah(idx) {
        // if (document.getElementById("dtayang"+idx).style.display == 'none')
        //     document.getElementById("dtayang"+idx).style.display = 'block';
        // else
        document.getElementById("tb_ubah"+idx).style.display = 'none';
        document.getElementById("dtayang"+idx).style.display = 'inline';
    }

    function batal(idx) {
        document.getElementById("tb_ubah"+idx).style.cssText = "display: inline";
        document.getElementById("dtayang"+idx).style.display = 'none';
    }

    function update(idx) {
        var itayange = $("#itayang"+idx).val();
        $.ajax({
            url: "<?php echo base_url(); ?>promo/updateuruttayang",
            method: "POST",
            data: {idpromo: idx, urutan: itayange},
            success: function (result) {
                document.querySelector('#tb_ubah'+idx).innerHTML = itayange;
                document.getElementById("tb_ubah"+idx).style.cssText = "display: inline";
                document.getElementById("dtayang"+idx).style.display = 'none';
            }
        })
    }

    function jangan(idx) {
        var itayange = $("#itayang"+idx).val();
        $.ajax({
            url: "<?php echo base_url(); ?>promo/updateuruttayang",
            method: "POST",
            data: {idpromo: idx, urutan: 0},
            success: function (result) {
                document.querySelector('#tb_ubah'+idx).innerHTML = '-';
                document.getElementById("tb_ubah"+idx).style.cssText = "display: inline";
                document.getElementById("dtayang"+idx).style.display = 'none';
            }
        })
    }


    function lihatvideo(url) {
        document.getElementById("videolokal").style.display = 'none';
        $('#videolokal').html('');

        if (oldurl == "") {
            document.getElementById("video-placeholder").style.display = 'block';
            player.cueVideoById(url);
            player.playVideo();
        } else {
            if ((oldurl == url) && (document.getElementById("video-placeholder").style.display == 'block')) {
                document.getElementById("video-placeholder").style.display = 'none';
                player.pauseVideo();
            } else {
                document.getElementById("video-placeholder").style.display = 'block';
                player.cueVideoById(url);
                player.playVideo();
            }
        }
        oldurl = url;
    }

    function lihatvideo2(url2) {
        player.pauseVideo();
        $('#videolokal').html('<video width="600" height="400" autoplay controls>' +
            '<source src="<?php echo base_url();?>uploads/tve/' + url2 + '" type="video/mp4">' +
            'Your browser does not support the video tag.</video>');
        //alert ("VIDEO");
        document.getElementById("video-placeholder").style.display = 'none';
        if (oldurl2 == "") {
            document.getElementById("videolokal").style.display = 'block';
            //document.getElementById("videolokal").value = "NGENGOS";
        } else {
            if ((oldurl2 == url2) && (document.getElementById("videolokal").style.display == 'block')) {
                document.getElementById("videolokal").style.display = 'none';
                $('#videolokal').html('');
                //document.getElementById("videolokal").value = "NGENGOS";
            } else {
                document.getElementById("videolokal").style.display = 'block';
                //document.getElementById("videolokal").value = "NGENGOS";
            }
        }
        oldurl2 = url2;
    }

    function lihatvideo3(url2) {
        player.pauseVideo();
        $('#videolokal').html('<video width="600" height="400" autoplay controls>' +
            '<source src="' + url2 + '" type="video/mp4">' +
            'Your browser does not support the video tag.</video>');
        //alert ("VIDEO");
        document.getElementById("video-placeholder").style.display = 'none';
        if (oldurl2 == "") {
            document.getElementById("videolokal").style.display = 'block';
            //document.getElementById("videolokal").value = "NGENGOS";
        } else {
            if ((oldurl2 == url2) && (document.getElementById("videolokal").style.display == 'block')) {
                document.getElementById("videolokal").style.display = 'none';
                $('#videolokal').html('');
                //document.getElementById("videolokal").value = "NGENGOS";
            } else {
                document.getElementById("videolokal").style.display = 'block';
                //document.getElementById("videolokal").value = "NGENGOS";
            }
        }
        oldurl2 = url2;
    }

    function mauhapus(idx) {

        var r = confirm("Yakin mau hapus?");
        if (r == true) {
            window.open('<?php echo base_url(); ?>promo/hapus/' + idx, '_self');
        } else {
            return false;
        }
        return false;
    }

    function gantisifat(idx) {
        statusnya = 0;
        if ($('#bt1_' + idx).html() == "Publik") {
            statusnya = 1;
        }

        $.ajax({
            url: "<?php echo base_url(); ?>channel/gantisifat",
            method: "POST",
            data: {id: idx, status: statusnya},
            success: function (result) {
                if ($('#bt1_' + idx).html() == "Publik") {
                    $('#bt1_' + idx).html("Pribadi");
                    $('#bt1_' + idx).css({"background-color": "#ffd0b4"});
                } else {
                    $('#bt1_' + idx).html("Publik");
                    $('#bt1_' + idx).css({"background-color": "#b4e7df"});
                }
            }
        })

    }

    function gantilist(idx) {
        statusnya = 0;
        if ($('#bt2_' + idx).html() == "---") {
            statusnya = 1;
        }

        $.ajax({
            url: "<?php echo base_url(); ?>channel/gantilist",
            method: "POST",
            data: {id: idx, status: statusnya},
            success: function (result) {
                if ($('#bt2_' + idx).html() == "---") {
                    $('#bt2_' + idx).html("Masuk");
                    $('#bt2_' + idx).css({"background-color": "#e6e6e6"});
                } else {
                    $('#bt2_' + idx).html("---");
                    $('#bt2_' + idx).css({"background-color": "#cddbe7"});
                }
            }
        })


    }

</script>
