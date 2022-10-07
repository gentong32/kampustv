<script>document.getElementsByTagName("html")[0].className += " js";</script>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/tab_style.css">

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$jml_jenjang = 0;
foreach ($dafjenjang as $datane) {
    $jml_jenjang++;
    $sel_jenjang[$jml_jenjang] = "";
    $id_jenjang[$jml_jenjang] = $datane->id;
    $nama_jenjang[$jml_jenjang] = $datane->nama_jenjang;
}

$jml_kategori = 0;
foreach ($dafkategori as $datane) {
    $jml_kategori++;
    $sel_kategori[$jml_kategori] = "";
    $id_kategori[$jml_kategori] = $datane->id;
    $nama_kategori[$jml_kategori] = $datane->nama_kategori;
}

if ($addedit == "edit") {
    $judulvideo = substr($datavideo['file_video'], 0, strlen($datavideo['file_video']) - 20);
//echo "Jdl:".($judulvideo);
//die();
    $jml_kd1 = 0;
    foreach ($dafkd1 as $datane) {
        $jml_kd1++;
        $sel_kd1_1[$jml_kd1] = "";
        $sel_kd1_2[$jml_kd1] = "";
        $sel_kd1_3[$jml_kd1] = "";
        $id_kd1[$jml_kd1] = $datane->id;
        $nama_kd1[$jml_kd1] = $datane->nama_kd;
    }

    $jml_kd2 = 0;
    foreach ($dafkd2 as $datane) {
        $jml_kd2++;
        $sel_kd2_1[$jml_kd2] = "";
        $sel_kd2_2[$jml_kd2] = "";
        $sel_kd2_3[$jml_kd2] = "";
        $id_kd2[$jml_kd2] = $datane->id;
        $nama_kd2[$jml_kd2] = $datane->nama_kd;
    }
}


$sel_jenis[1] = "";
$sel_jenis[2] = "";
$disp[1] = "";
$disp[2] = "";
$sel_ki1[1] = "";
$sel_ki1[2] = "";
$sel_ki1[3] = "";
$sel_ki1[4] = "";
$sel_ki2[1] = "";
$sel_ki2[2] = "";
$sel_ki2[3] = "";
$sel_ki2[4] = "";
$judul = "";
$topik = "";
$deskripsi = "";
$keyword = "";
$link_video = "";


if ($addedit == "add") {
    $judule = "Tambahkan Video";
    $sel_jenis[1] = "selected";
    $disp[2] = 'style="display:none;"';
    $thumbs = "blank.jpg";
    $durjam = "00";
    $durmenit = "00";
    $durdetik = "00";
    if (!isset($judulvideo))
        $file_video = "";
} else {
    $judule = "Edit Video";
    $sel_jenis[$datavideo['id_jenis']] = "selected";
    $sel_kategori[$datavideo['id_kategori']] = "selected";
    if ($datavideo['id_jenis'] == 2) {
        $disp[1] = 'style="display:none;"';
        $disp[2] = 'style="display:block;"';
    } else {
        $disp[1] = 'style="display:block;"';
        $disp[2] = 'style="display:none;"';
    }
    $sel_jenjang[$datavideo['id_jenjang']] = "selected";

    $jml_kelas = 0;
    foreach ($dafkelas as $datane) {
        $jml_kelas++;
        $id_kelas[$jml_kelas] = $datane->id;
        $nama_kelas[$jml_kelas] = $datane->nama_kelas;
    }
    for ($a1 = 1; $a1 <= 50; $a1++)
        $sel_kelas[$a1] = "";
    $sel_kelas[$datavideo['id_kelas']] = "selected";

    $jml_mapel = 0;
    foreach ($dafmapel as $datane) {
        $jml_mapel++;
        $sel_mapel[$jml_mapel] = "";
        $id_mapel[$jml_mapel] = $datane->id;
        $nama_mapel[$jml_mapel] = $datane->nama_mapel;
    }
    for ($a1 = 1; $a1 <= 50; $a1++)
        $sel_mapel[$a1] = "";

    for ($a1 = 1; $a1 <= 20; $a1++) {
        $sel_kd1_1[$a1] = "";
        $sel_kd1_2[$a1] = "";
        $sel_kd1_3[$a1] = "";
        $sel_kd2_1[$a1] = "";
        $sel_kd2_2[$a1] = "";
        $sel_kd2_3[$a1] = "";
    }

    $sel_mapel[$datavideo['id_mapel']] = "selected";

    $sel_ki1[$datavideo['id_ki1']] = "selected";
    $sel_ki2[$datavideo['id_ki2']] = "selected";
    $sel_kd1_1[$datavideo['id_kd1_1']] = "selected";
    $sel_kd1_2[$datavideo['id_kd1_2']] = "selected";
    $sel_kd1_3[$datavideo['id_kd1_3']] = "selected";
    $sel_kd2_1[$datavideo['id_kd2_1']] = "selected";
    $sel_kd2_2[$datavideo['id_kd2_2']] = "selected";
    $sel_kd2_3[$datavideo['id_kd2_3']] = "selected";
    $judul = $datavideo['judul'];
    $topik = $datavideo['topik'];
    $deskripsi = $datavideo['deskripsi'];
    $keyword = $datavideo['keyword'];
    $status_video = $datavideo['status_verifikasi'];
    $link_video = $datavideo['link_video'];
    $file_video = $datavideo['file_video'];
    $namafile = substr($file_video, 0, strlen($file_video) - 3) . rand(1, 32000) . '.jpg';
    $durasi = $datavideo['durasi'];
    $thumbs = $datavideo['thumbnail'];
    if (substr($thumbs, 0, 4) != "http" && $thumbs != "")
        $thumbs = "<?php echo base_url(); ?>uploads/thumbs/" . $thumbs;

    // if ($link_video!="")
    // 	$thumbs=substr($link_video,-11).'.';
    // else if ($file_video!="")
    // 	$thumbs=substr($file_video,0,strlen($file_video)-3);
//		if ($durasi=="")
//			$durasi = $infodurasi;
    $durjam = substr($durasi, 0, 2);
    $durmenit = substr($durasi, 3, 2);
    $durdetik = substr($durasi, 6, 2);

    if ($durjam == "")
        $durjam = "00";
    if ($durmenit == "")
        $durmenit = "00";
    if ($durdetik == "")
        $durdetik = "00";

}


?>

<div style="margin-top: 60px">
    <center><span style="font-size:20px;font-weight:Bold;"><?php echo $judule; ?></span></center>
    <?php if ($addedit == "edit" && ($file_video != "")) { ?>
        <div style="text-align: center;margin: auto">
            <button class="btn btn-primary" onclick="window.open('<?php echo base_url();?>video')">Kembali</button>
            <button class="btn btn-primary" onclick="return editmp4(<?php echo $datavideo['id_video'];?>)">Ganti Video</button></div>
    <?php } ?>

    <div class="row">
        <?php
        echo form_open('video/addvideo');
        ?>


        <div class="cd-tabs cd-tabs--vertical container max-width-md margin-top-xs margin-bottom-lg js-cd-tabs">

            <nav class="cd-tabs__navigation">
                <ul class="cd-tabs__list">
                    <li>
                        <a href="#tab-inbox" class="cd-tabs__item cd-tabs__item--selected">
                            <!--                        <svg aria-hidden="true" class="icon icon&#45;&#45;xs"><path d="M15,0H1C0.4,0,0,0.4,0,1v14c0,0.6,0.4,1,1,1h14c0.6,0,1-0.4,1-1V1C16,0.4,15.6,0,15,0z M14,2v7h-3 c-0.6,0-1,0.4-1,1v2H6v-2c0-0.6-0.4-1-1-1H2V2H14z"></path></svg>-->
                            <span>Sasaran</span>
                        </a>
                    </li>

                    <li>
                        <a href="#tab-new" class="cd-tabs__item">
                            <!--                        <svg aria-hidden="true" class="icon icon--xs"><path d="M12.7,0.3c-0.4-0.4-1-0.4-1.4,0l-7,7C4.1,7.5,4,7.7,4,8v3c0,0.6,0.4,1,1,1h3 c0.3,0,0.5-0.1,0.7-0.3l7-7c0.4-0.4,0.4-1,0-1.4L12.7,0.3z M7.6,10H6V8.4l6-6L13.6,4L7.6,10z"></path><path d="M15,10c-0.6,0-1,0.4-1,1v3H2V2h3c0.6,0,1-0.4,1-1S5.6,0,5,0H1C0.4,0,0,0.4,0,1v14c0,0.6,0.4,1,1,1h14 c0.6,0,1-0.4,1-1v-4C16,10.4,15.6,10,15,10z"></path></svg>-->
                            <span>Data</span>
                        </a>
                    </li>

                </ul> <!-- cd-tabs__list -->
            </nav>

            <ul class="cd-tabs__panels">
                <li id="tab-inbox" class="cd-tabs__panel cd-tabs__panel--selected text-component">
                    <legend>Jenis dan Sasaran</legend>

                    <?php if (($file_video != "") && ($this->session->userdata('tukang_kontribusi') == 2 || $this->session->userdata('tukang_verifikasi') == 2)) { ?>
                        <div class="form-group">
                            <label for="inputDefault" class="col-md-12 control-label">Video yang diunggah:</label>
                            <div class="col-md-12" style="padding-bottom:10px">
                                <?php echo $judulvideo; ?>
                                <br>

                                <video id="video_playermp4" width="320" height="240" controls>
                                    <source src="<?php echo base_url(); ?>uploads/tve/<?php echo $file_video; ?>" type="video/mp4">
                                </video>

                                <canvas style="display: none;" id="canvas-element"></canvas>
                                <br>
                                <?php if ($addedit == "add" || $thumbs == "") { ?>
                                    <img id="thumb1" style="margin-left:auto; align:middle;width:200px;" src="">
                                <?php } else { ?>
                                    <img id="thumb1" style="align:middle;width:200px;" src="<?php echo $thumbs; ?>">
                                <?php } ?>
                                <?php if ($addedit == "edit") { ?>
                                    &nbsp;<br>
                                    <button class="btn btn-default" onclick="return sethumb()">Set Thumbnail</button>
                                <?php } ?>

                            </div>
                        </div>
                        <label for="inputDefault" class="col-md-12 control-label">Durasi (Jam:Menit:Detik)</label>

                        <div class="col-md-12">
                            <input style="display:inline;width:20px;height:25px;margin:0;padding:0" type="text"
                                   class="form-control" id="idurjam" name="idurjam" maxlength="2"
                                   value="<?php echo $durjam; ?>" readonly placeholder="00">
                            :
                            <input style="display:inline;width:20px;height:25px;margin:0;padding:0" type="text"
                                   class="form-control" id="idurmenit" name="idurmenit" maxlength="2"
                                   value="<?php echo $durmenit; ?>" readonly placeholder="00">
                            :
                            <input style="display:inline;width:20px;height:25px;margin:0;padding:0" type="text"
                                   class="form-control" id="idurdetik" name="idurdetik" maxlength="2"
                                   value="<?php echo $durdetik; ?>" readonly placeholder="00">
                        </div>
                        <?php
                    }
                    ?>


                    <div class="form-group" id="djenis">
                        <label for="select" class="col-md-12 control-label">Jenis</label>
                        <div class="col-md-12">
                            <select class="form-control" name="ijenis" id="ijenis">
                                <option <?php echo $sel_jenis[1]; ?> value="1">Konten Instruksional</option>
                                <option <?php echo $sel_jenis[2]; ?> value="2">Konten Non Instruksional</option>
                            </select>
                        </div>
                    </div>

                    <div id="grupins" <?php echo $disp[1]; ?>>
                        <div class="form-group" id="djenjang"><br>
                            <label for="select" class="col-md-12 control-label">Jenjang</label>
                            <div class="col-md-12">
                                <select class="form-control" name="ijenjang" id="ijenjang">
                                    <option value="0">-- Pilih --</option>

                                    <?php
                                    for ($b1 = 1; $b1 <= $jml_jenjang; $b1++) {
                                        echo '<option ' . $sel_jenjang[$b1] . ' value="' . $id_jenjang[$b1] . '">' . $nama_jenjang[$b1] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group" id="dkelas"><br>
                            <label for="select" class="col-md-12 control-label">Kelas</label>
                            <div class="col-md-12">
                                <select class="form-control" name="ikelas" id="ikelas">
                                    <option value="0">-- Pilih --</option>

                                    <?php
                                    if ($addedit == "edit")
                                        for ($b11 = 1; $b11 <= $jml_kelas; $b11++) {
                                            echo '<option ' . $sel_kelas[$id_kelas[$b11]] . ' value="' . $id_kelas[$b11] . '">' . $nama_kelas[$b11] . '</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group" id="dmapel"><br>
                            <label for="select" class="col-md-12 control-label">Mata Pelajaran</label>
                            <div class="col-md-12">
                                <select class="form-control" name="imapel" id="imapel">
                                    <option value="0">-- Pilih --</option>

                                    <?php
                                    if ($addedit == "edit")
                                        for ($b12 = 1; $b12 <= $jml_mapel; $b12++) {
                                            echo '<option ' . $sel_mapel[$id_mapel[$b12]] . ' value="' . $id_mapel[$b12] . '">' . $nama_mapel[$b12] . '</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group"><br>
                            <label for="inputDefault" class="col-md-12 control-label">Kompetensi Inti </label>
                            <div class="col-md-12">
                                <table>
                                    <tr>
                                        <td style='width:auto'>
                                            <select class="form-control" name="iki1" id="iki1">
                                                <option value="0">-- Pilih --</option>

                                                <option <?php echo $sel_ki1[1]; ?> value="1">Sikap Religius</option>
                                                <option <?php echo $sel_ki1[2]; ?> value="2">Sikap Sosial</option>
                                                <option <?php echo $sel_ki1[3]; ?> value="3">Pengetahuan</option>
                                                <option <?php echo $sel_ki1[4]; ?> value="4">Ketrampilan</option>

                                            </select>
                                        </td>
                                        <td style='width:50px'>
                                            &nbsp;<button class="btn btn-default" onclick="return tambahki()">+</button>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div id="dkd1_1" class="form-group"><br>
                            <label for="inputDefault" class="col-md-12 control-label">Kompetensi Dasar</label>
                            <div class="col-md-12" style='padding-bottom:5px;left:10px;'>
                                <table>
                                    <tr>
                                        <td style='width:auto'>
                                            <div id="isidkd1_1">
                                                <select class="form-control" name="ikd1_1" id="ikd1_1">
                                                    <option value="0">-- Pilih --</option>

                                                    <?php
                                                    if ($addedit == "edit")
                                                        for ($b13 = 1; $b13 <= $jml_kd1; $b13++) {
                                                            echo '<option ' . $sel_kd1_1[$id_kd1[$b13]] . ' value="' . $id_kd1[$b13] . '">' . $nama_kd1[$b13] . '</option>';
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </td>
                                        <td style='width:50px'>
                                            &nbsp;<button class="btn btn-default" onclick="return tambahkd('1_2')">+
                                            </button>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div id='dkd1_2' class="col-md-12" style='padding-bottom:5px;left:10px;display:<?php
                        if ($addedit == 'edit') {
                            if ($datavideo["id_kd1_2"] > 0) echo 'block'; else echo 'none';
                        } else echo 'none'; ?>'>
                            <table>
                                <tr>
                                    <td style='width:auto'>
                                        <div id="isidkd1_2">
                                            <select class="form-control" name="ikd1_2" id="ikd1_2">
                                                <option value="0">-- Pilih --</option>

                                                <?php
                                                if ($addedit == "edit")
                                                    for ($b14 = 1; $b14 <= $jml_kd1; $b14++) {
                                                        echo '<option ' . $sel_kd1_2[$id_kd1[$b14]] . ' value="' . $id_kd1[$b14] . '">' . $nama_kd1[$b14] . '</option>';
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </td>
                                    <td style='width:auto'>
                                        &nbsp;<button class="btn btn-default" onclick="return tambahkd('1_3')">+
                                        </button>
                                    </td>
                                    <td style='width:50px'>
                                        <button class="btn btn-default" onclick="return hapuskd('1_2')">-</button>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div id='dkd1_3' class="col-md-12" style='padding-bottom:5px;left:10px;display:<?php
                        if ($addedit == 'edit') {
                            if ($datavideo["id_kd1_3"] > 0) echo 'block'; else echo 'none';
                        } else echo 'none'; ?>'>
                            <table>
                                <tr>
                                    <td style='width:auto'>
                                        <div id="isidkd1_3">
                                            <select class="form-control" name="ikd1_3" id="ikd1_3">
                                                <option value="0">-- Pilih --</option>

                                                <?php
                                                if ($addedit == "edit")
                                                    for ($b15 = 1; $b15 <= $jml_kd1; $b15++) {
                                                        echo '<option ' . $sel_kd1_3[$id_kd1[$b15]] . ' value="' . $id_kd1[$b15] . '">' . $nama_kd1[$b15] . '</option>';
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </td>
                                    <td style='width:auto'>
                                        &nbsp;<button class="btn btn-default" onclick="return hapuskd('1_3')">-</button>
                                    </td>
                                    <td style='width:50px'>

                                    </td>
                                </tr>
                            </table>
                        </div>


                        <!-- /////////////////////////////////////////////////// -->
                        <div id="dki2" class="form-group" style='display:<?php
                        if ($addedit == 'edit') {
                            if ($datavideo["id_ki2"] > 0) echo 'block'; else echo 'none';
                        } else echo 'none'; ?>'><br>
                            <label for="inputDefault" class="col-md-12 control-label">Kompetensi Inti 2</label>
                            <div class="col-md-12">
                                <table>
                                    <tr>
                                        <td style='width:auto'>
                                            <select class="form-control" name="iki2" id="iki2">
                                                <option value="0">-- Pilih --</option>

                                                <option <?php echo $sel_ki2[1]; ?> value="1">Sikap Religius</option>
                                                <option <?php echo $sel_ki2[2]; ?> value="2">Sikap Sosial</option>
                                                <option <?php echo $sel_ki2[3]; ?> value="3">Pengetahuan</option>
                                                <option <?php echo $sel_ki2[4]; ?> value="4">Ketrampilan</option>

                                            </select>
                                        </td>
                                        <td style='width:50px'>
                                            &nbsp;<button class="btn btn-default" onclick="return hapuski()">-</button>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div id="dkd2_1" class="form-group" style='display:<?php
                        if ($addedit == 'edit') {
                            if ($datavideo["id_kd2_1"] > 0) echo 'block'; else echo 'none';
                        } else echo 'none'; ?>;left:10px;'><br>
                            <label for="inputDefault" class="col-md-12 control-label">Kompetensi Dasar</label>
                            <div class="col-md-12" style='padding-bottom:5px;left:10px;'>
                                <table>
                                    <tr>
                                        <td style='width:auto'>
                                            <div id="isidkd2_1">
                                                <select class="form-control" name="ikd2_1" id="ikd2_1">
                                                    <option value="0">-- Pilih --</option>

                                                    <?php
                                                    if ($addedit == "edit")
                                                        for ($b16 = 1; $b16 <= $jml_kd2; $b16++) {
                                                            echo '<option ' . $sel_kd2_1[$id_kd2[$b16]] . ' value="' . $id_kd2[$b16] . '">' . $nama_kd2[$b16] . '</option>';
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </td>
                                        <td style='width:50px'>
                                            &nbsp;<button class="btn btn-default" onclick="return tambahkd('2_2')">+
                                            </button>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div id='dkd2_2' class="col-md-12" style='padding-bottom:5px;left:10px;display:<?php
                        if ($addedit == 'edit') {
                            if ($datavideo["id_kd2_2"] > 0) echo 'block'; else echo 'none';
                        } else echo 'none'; ?>'>
                            <table>
                                <tr>
                                    <td style='width:auto'>
                                        <div id="isidkd2_2">
                                            <select class="form-control" name="ikd2_2" id="ikd2_2">
                                                <option value="0">-- Pilih --</option>

                                                <?php
                                                if ($addedit == "edit")
                                                    for ($b17 = 1; $b17 <= $jml_kd2; $b17++) {
                                                        echo '<option ' . $sel_kd2_2[$id_kd2[$b17]] . ' value="' . $id_kd2[$b17] . '">' . $nama_kd2[$b17] . '</option>';
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </td>
                                    <td style='width:auto'>
                                        &nbsp;<button class="btn btn-default" onclick="return tambahkd('2_3')">+
                                        </button>
                                    </td>
                                    <td style='width:50px'>
                                        <button class="btn btn-default" onclick="return hapuskd('2_2')">-</button>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div id='dkd2_3' class="col-md-12" style='padding-bottom:5px;left:10px;display:<?php
                        if ($addedit == 'edit') {
                            if ($datavideo["id_kd2_3"] > 0) echo 'block'; else echo 'none';
                        } else
                            echo 'none'; ?>'>
                            <table>
                                <tr>
                                    <td style='width:auto'>
                                        <div id="isidkd2_3">
                                            <select class="form-control" name="ikd2_3" id="ikd2_3">
                                                <option value="0">-- Pilih --</option>

                                                <?php
                                                if ($addedit == "edit")
                                                    for ($b18 = 1; $b18 <= $jml_kd2; $b18++) {
                                                        echo '<option ' . $sel_kd2_3[$id_kd2[$b18]] . ' value="' . $id_kd2[$b18] . '">' . $nama_kd2[$b18] . '</option>';
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </td>
                                    <td style='width:auto'>
                                        &nbsp;<button class="btn btn-default" onclick="return hapuskd('2_3')">-</button>
                                    </td>
                                    <td style='width:50px'>

                                    </td>
                                </tr>
                            </table>
                        </div>


                    </div>


                    <div id="grupnonins" <?php echo $disp[2]; ?>>
                        <div class="form-group" id="dkategori">
                            <label for="select" class="col-md-12 control-label">Kategori</label>
                            <div class="col-md-12">
                                <select class="form-control" name="ikategori" id="ikategori">
                                    <option value="0">-- Pilih --</option>

                                    <?php
                                    for ($b2 = 1; $b2 <= $jml_kategori; $b2++) {
                                        echo '<option ' . $sel_kategori[$b2] . ' value="' . $id_kategori[$b2] . '">' . $nama_kategori[$b2] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </li>

                <li id="tab-new" class="cd-tabs__panel text-component">
                    <legend>Data Video</legend>

                    <div class="form-group">
                        <label for="inputDefault" class="col-md-12 control-label">Topik</label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" id="itopik" name="itopik" maxlength="100"
                                   value="<?php echo $topik; ?>" placeholder="">
                            <br>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputDefault" class="col-md-12 control-label">Judul</label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" id="ijudul" name="ijudul" maxlength="100"
                                   value="<?php echo $judul; ?>" placeholder="">
                            <br>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputDefault" class="col-md-12 control-label">Deskripsi Konten</label>
                        <div class="col-md-12">
						<textarea rows="4" cols="60" class="form-control" id="ideskripsi" name="ideskripsi"
                                  maxlength="500"><?php echo $deskripsi; ?></textarea><br>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputDefault" class="col-md-12 control-label">Keyword</label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" id="ikeyword" name="ikeyword" maxlength="100"
                                   value="<?php echo $keyword; ?>" placeholder="">
                            <br>
                        </div>
                    </div>

                    <?php if (($link_video == "" && $addedit == 'add') || ($link_video != "" && $addedit == 'edit')) { ?>
                    <div class="form-group">
                        <label for="inputDefault" class="col-md-12 control-label">Alamat URL Video</label>
                        <div class="col-md-12">
							<textarea <?php
                            if ($addedit == "edit") {
                                if ($datavideo['status_verifikasi'] == 2 || $datavideo['status_verifikasi'] == 4 || $datavideo['status_verifikasi'] == 5) {
                                    echo 'readonly';
                                }
                            } ?>

                                    rows="3" cols="60" class="form-control" id="ilink" name="ilink"
                                    maxlength="300"><?php echo $link_video; ?></textarea><br>
                        </div>
                    </div>

                    <div class="form-group">
                        <?php if ($addedit == "edit") { ?>
                            <label for="inputDefault" class="col-md-12 control-label">Thumbnail</label>
                            <div class="col-md-12">
                                <?php if ($thumbs == "") {
                                    if ($link_video == "") {
                                        ?>
                                        <img style="align:middle;width:200px;" src="<?php echo base_url(); ?>assets/images/blank.jpg">
                                    <?php } else {
                                        ?>
                                        <img style="align:middle;width:200px;"
                                             src="https://img.youtube.com/vi/<?php
                                             echo substr($link_video, 32, 11); ?>/0.jpg">
                                    <?php } ?>
                                <?php } else { ?>
                                    <img style="align:middle;width:200px;"
                                         src="<?php echo $thumbs; ?>">
                                <?php } ?>

<!--                                &nbsp;<button class="btn btn-default" onclick="return upload()">Upload Thumbnail-->
<!--                                </button>-->

                                <br><br>
                            </div>

                            <label for="inputDefault" class="col-md-12 control-label">Durasi (Jam:Menit:Detik)</label>
                            <div class="col-md-12">
                                <input style="display:inline;width:20px;height:25px;margin:0;padding:0" type="text"
                                       class="form-control" id="idurjam" name="idurjam" maxlength="2"
                                       value="<?php echo $durjam; ?>" placeholder="00">
                                :
                                <input style="display:inline;width:20px;height:25px;margin:0;padding:0" type="text"
                                       class="form-control" id="idurmenit" name="idurmenit" maxlength="2"
                                       value="<?php echo $durmenit; ?>" placeholder="00">
                                :
                                <input style="display:inline;width:20px;height:25px;margin:0;padding:0" type="text"
                                       class="form-control" id="idurdetik" name="idurdetik" maxlength="2"
                                       value="<?php echo $durdetik; ?>" placeholder="00">
                                <br><br>
                            </div>
                        <?php } else { ?>
                            <label for="inputDefault" class="col-md-12 control-label">Thumbnail</label>
                            <div class="col-md-12">
                                <img id="img_thumb" style="align:middle;width:200px;"
                                     src="<?php echo base_url(); ?>assets/images/blank.jpg">
                                <!--					&nbsp;<button class="btn btn-default" onclick="return upload()">Upload Thumbnail</button>-->

                                <br><br>
                            </div>

                            <label for="inputDefault" class="col-md-12 control-label">Durasi</label>
                            <div class="col-md-12">
                                <div id="get_durasi">00:00:00</div>
                                <br>
                            </div>

                        <?php }
                        }
                        ?>

                        <!-- <?php //echo "ADDEDIT:".$addedit; ?> -->

                        <?php
                        if ($datavideo['status_verifikasi'] == 2 || $datavideo['status_verifikasi'] == 4
                            || $datavideo['status_verifikasi'] == 5) { ?>
                            <input type="hidden" id="ilink" name="ilink"
                                   value="<?php echo $datavideo['link_video']; ?>"/>
                        <?php } ?>

                        <input type="hidden" id="addedit" name="addedit"
                               value="<?php if ($addedit == "edit") echo 'edit'; else echo 'add'; ?>"/>
                        <input type="hidden" id="kondisi" name="kondisi" value="2"/>
                        <input type="hidden" id="id_user" name="id_user" value=""/>
                        <input type="hidden" id="ytube_duration" name="ytube_duration" value=""/>
                        <input type="hidden" id="ytube_thumbnail" name="ytube_thumbnail" value=""/>
                        <input type="hidden" id="status_ver" name="status_ver"
                               value="<?php echo $datavideo['status_verifikasi']; ?>"/>

                        <input type="hidden" id="filevideo" name="filevideo"
                               value="<?php if ($addedit == "edit") echo $judulvideo; else echo ''; ?>"/>
                        <input type="hidden" id="created" name="created"
                               value="<?php if ($addedit == "edit") echo $datavideo['created']; else echo ''; ?>"/>
                        <input type="hidden" id="id_video" name="id_video"
                               value="<?php if ($addedit == "edit") echo $datavideo['id_video']; ?>"/>
                        <input type="hidden" id="idyoutube" name="idyoutube" value=""/>

                        <div class="form-group">
                            <div class="col-md-10 col-md-offset-0">
                                <?php if ((($addedit == "edit") && ($datavideo['topik'] != "")) || $addedit == "add") { ?>
                                    <button class="btn btn-default" onclick="return takon()">Batal</button> <?php } ?>
                                <button type="submit" class="btn btn-primary" onclick="return cekaddvideo()"><?php
                                    if ($addedit == "edit") echo 'Update'; else echo 'Simpan' ?></button>
                            </div>
                        </div>
                    </div>
                </li>

            </ul> <!-- cd-tabs__panels -->
        </div> <!-- cd-tabs -->

        <?php
        echo form_close() . '';
        ?>
    </div>
</div>

<!-- echo form_open('dasboranalisis/update'); -->

<script src="<?php echo base_url() ?>js/jquery-3.4.1.js"></script>

<script src="<?php echo base_url(); ?>js/tab_util.js"></script> <!-- util functions included in the CodyHouse framework -->
<script src="<?php echo base_url(); ?>js/tab_main.js"></script>

<script>
    //alert ("cew");
    <?php if ($addedit == "edit") {
    if ($jenisvideo == "mp4") {?>
    //alert ("cekek");
    var myVideoPlayer = document.getElementById('video_playermp4');
    var _CANVAS = document.querySelector("#canvas-element");
    var _CANVAS_CTX = _CANVAS.getContext("2d");

    myVideoPlayer.addEventListener('loadedmetadata', function () {
        var duration = myVideoPlayer.duration;

        durasidetik = parseInt(duration.toFixed(2));
        hitungjam = parseInt(durasidetik / 3600);
        sisadetik = durasidetik - (hitungjam * 3600);
        hitungmenit = parseInt(sisadetik / 60);
        sisadetik = sisadetik - (hitungmenit * 60);
        hitungdetik = sisadetik;
        if (hitungjam < 10)
            hitungjam = "0" + hitungjam;
        if (hitungmenit < 10)
            hitungmenit = "0" + hitungmenit;
        if (hitungdetik < 10)
            hitungdetik = "0" + hitungdetik;

        $('#idurjam').val(hitungjam);
        $('#idurmenit').val(hitungmenit);
        $('#idurdetik').val(hitungdetik);


    });

    myVideoPlayer.addEventListener('timeupdate', function () {


        /*var link = document.getElementById('link');
        link.setAttribute('download', 'MintyPaper.png');
        link.setAttribute('href', _CANVAS.toDataURL("image/png").replace("image/png", "image/octet-stream"));*/


    });

    function sethumb() {
        _CANVAS.width = 640;
        _CANVAS.height = 420;

        _CANVAS_CTX.drawImage(myVideoPlayer, 0, 0, _CANVAS.width, _CANVAS.height);

        datai = _CANVAS.toDataURL();

        uploadcanvas();
        return false;
    }

    function uploadcanvas() {
        $.ajax({
            url: "<?php echo base_url();?>video/do_uploadcanvas",
            method: "POST",
            data: {canvasimage: datai, idvideo: '<?php echo $idvideo;?>', filevideo: '<?php echo $namafile;?>'},
            success: function (result) {
                document.getElementById("thumb1").src = "<?php echo base_url(); ?>uploads/thumbs/<?php echo $namafile;?>";
                console.log(result);
            },
            error: function () {
                alert('Error occured');
            }
        })
    }

    <?php }} ?>


    $(document).on('change', '#ipropinsi', function () {
        getdaftarkota();
    });

    function getdaftarkota() {

        isihtml0 = '<br><label for="select" class="col-md-12 control-label">Kota/Kabupaten</label><div class="col-md-12">';
        isihtml1 = '<select class="form-control" name="ikota" id="ikota">' +
            '<option value="0">-- Pilih --</option>';
        isihtml3 = '</select></div>';
        $.ajax({
            type: 'GET',
            data: {idpropinsi: $('#ipropinsi').val()},
            dataType: 'json',
            cache: false,
            url: '<?php echo base_url();?>login/daftarkota',
            success: function (result) {
                //alert ($('#itopik').val());
                isihtml2 = "";
                $.each(result, function (i, result) {
                    isihtml2 = isihtml2 + "<option value='" + result.id_kota + "'>" + result.nama_kota + "</option>";
                });
                $('#dkota').html(isihtml0 + isihtml1 + isihtml2 + isihtml3);
            }
        });
    }


    $(document).on('change', '#ijenis', function () {
        pilihanjenis();
    });

    $(document).on('change', '#ijenjang', function () {
        ambilkelas();
        ambilmapel();
    });

    $(document).on('change', '#iki1', function () {
        ambilkd(1);
    });

    $(document).on('change', '#iki2', function () {
        ambilkd(2);
    });

    $(document).on('change', '#ilink2', function () {
        $('#img_thumb').src = "";
    });

    $("#ilink").change(function () {
        //alert ("Jajajl");
        ambilinfoyutub();
    });

    function ambilinfoyutub() {
        idyutub = youtube_parser($("#ilink").val());
        $('#idyutube').val(idyutub);
        var filethumb = "https://img.youtube.com/vi/" + idyutub + "/0.jpg";
        $('#ytube_thumbnail').val(filethumb);

        $("#img_thumb").attr("src", filethumb);
        $.ajax({
            url: '<?php echo base_url();?>video/getVideoInfo/' + idyutub,
            type: 'GET',
            dataType: 'text',
            data: {
                foo: 'Test'
            },
            success: function (text) {
                //alert (text);
                $('#ytube_duration').val(text);
                $('#get_durasi').html(text);

            }
        });
    }

    function youtube_parser(url) {
        var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
        var match = url.match(regExp);
        return (match && match[7].length == 11) ? match[7] : false;
    }

    function pilihanjenis() {

        var jenis = document.getElementById("ijenis");
        var y1 = document.getElementById("grupins");
        var y2 = document.getElementById("grupnonins");
        //var y2 = document.getElementById("grupnonins");

        if (jenis.value == 2) {
            y1.style.display = "none";
            y2.style.display = "block";
        }
        else {
            y2.style.display = "none";
            y1.style.display = "block";
        }
    }

    function ambilkelas() {
        isihtml0 = '<br><label for="select" class="col-md-12 control-label">Kelas</label><div class="col-md-12">';
        isihtml1 = '<select class="form-control" name="ikelas" id="ikelas">' +
            '<option value="0">-- Pilih --</option>';
        isihtml3 = '</select></div>';
        $.ajax({
            type: 'GET',
            data: {idjenjang: $('#ijenjang').val()},
            dataType: 'json',
            cache: false,
            url: '<?php echo base_url();?>video/daftarkelas',
            success: function (result) {
                //alert ($('#itopik').val());
                isihtml2 = "";
                $.each(result, function (i, result) {
                    isihtml2 = isihtml2 + "<option value='" + result.id + "'>" + result.nama_kelas + "</option>";
                });
                $('#dkelas').html(isihtml0 + isihtml1 + isihtml2 + isihtml3);
            }
        });
    }

    function ambilmapel() {

        isihtmlb0 = '<br><label for="select" class="col-md-12 control-label">Mata Pelajaran</label><div class="col-md-12">';
        isihtmlb1 = '<select class="form-control" name="imapel" id="imapel">' +
            '<option value="0">-- Pilih --</option>';
        isihtmlb3 = '</select></div>';
        $.ajax({
            type: 'GET',
            data: {idjenjang: $('#ijenjang').val()},
            dataType: 'json',
            cache: false,
            url: '<?php echo base_url();?>video/daftarmapel',
            success: function (result) {
                //alert ($('#itopik').val());
                isihtmlb2 = "";
                $.each(result, function (i, result) {
                    isihtmlb2 = isihtmlb2 + "<option value='" + result.id + "'>" + result.nama_mapel + "</option>";
                });
                $('#dmapel').html(isihtmlb0 + isihtmlb1 + isihtmlb2 + isihtmlb3);
            }
        });
    }

    function ambilkd(ki) {

        isihtml1_1 = '<select class="form-control" name="ikd' + ki + '_1" id="ikd' + ki + '_1">' +
            '<option value="0">-- Pilih --</option>;';
        isihtml1_2 = '<select class="form-control" name="ikd' + ki + '_2" id="ikd' + ki + '_2">' +
            '<option value="0">-- Pilih --</option>;';
        isihtml1_3 = '<select class="form-control" name="ikd' + ki + '_3" id="ikd' + ki + '_3">' +
            '<option value="0">-- Pilih --</option>;';
        isihtml3 = '</select>';

        $.ajax({
            type: 'GET',
            data: {
                idkelas: $('#ikelas').val(),
                idmapel: $('#imapel').val(),
                idki: $('#iki' + ki).val()
            },
            dataType: 'json',
            cache: false,
            url: '<?php echo base_url();?>video/ambilkd',
            success: function (result) {
                //alert ($('#itopik').val());
                isihtml2 = "";
                $.each(result, function (i, result) {
                    isihtml2 = isihtml2 + "<option value='" + result.id + "'>" + result.nama_kd + "</option>";
                });
                $('#isidkd' + ki + '_1').html(isihtml1_1 + isihtml2 + isihtml3);
                $('#isidkd' + ki + '_2').html(isihtml1_2 + isihtml2 + isihtml3);
                $('#isidkd' + ki + '_3').html(isihtml1_3 + isihtml2 + isihtml3);
            }
        });
    }


    function cekaddvideo() {
        var oke1 = 1;
        var oke2 = 1;

        //ambilinfoyutub();
        //alert ($('#ytube_duration').val());

        var jenis = document.getElementById("ijenis");

        var ki2 = document.getElementById("iki2");


        if (jenis.value == "1") {
            //alert ("s1");
            if ($('#ijenjang').val() == 0 || $('#ikelas').val() == 0 || $('#imapel').val() == 0
                || $('#iki1').val() == 0 || $('#ikd1_1').val() == 0 || $('#ilink').val() == "") {
                oke1 = 0;
            }
            if (document.getElementById("dkd1_2").style.display == 'none')
                $('#ikd1_2').val(0);
            if (document.getElementById("dkd1_3").style.display == 'none')
                $('#ikd1_3').val(0);
            if (document.getElementById("dkd2_1").style.display == 'none') {
                $('#iki21').val(0);
                $('#ikd2_1').val(0);
            }

            if ($('#ikd2_1').val() == 0)
                $('#iki2').val(0);

            if (document.getElementById("dki2").style.display == 'none') {
                $('#iki2').val(0);
                $('#ikd2_1').val(0);
                $('#ikd2_2').val(0);
                $('#ikd2_3').val(0);

            }
            if (document.getElementById("dkd2_2").style.display == 'none')
                $('#ikd2_2').val(0);
            if (document.getElementById("dkd2_3").style.display == 'none')
                $('#ikd2_3').val(0);


        }
        else {
            //alert ("s2");
            if ($('#ikategori').val() == 0) {
                oke1 = 0;
            }
        }

        if ($('#itopik').val() == "" || $('#ijudul').val() == "" || $('#ideskripsi').val() == ""
            || $('#ikeyword').val() == "") {
            oke2 = 0;
        }

        <?php if ($addedit == "add" && $this->session->userdata('sebagai')!=4) { ?>
        if ($('#ytube_duration').val() == "") {
            oke2 = 0;
        }
        <?php } ?>



        if (oke1 == 1 && oke2 == 1) {

            var retVal = confirm("Dengan ini Anda menyatakan bahwa semua data terkait video beserta isi video ini tidak melanggar hukum!");
            if (retVal == true) {
                // document.write ("User wants to continue!");
                return true;
            }
            else {
                //document.write ("User does not want to continue!");
                return false;
            }
        }

        else {
            alert("Semua harus dilengkapi");
            return false;
        }
    }

    function takon() {
        window.open("<?php echo base_url();?>video", "_self");
        return false;
    }

    function editmp4(idvideo) {
        window.open("<?php echo base_url();?>video/upload_mp4/"+idvideo, "_self");
        return false;
    }



    <?php if ($addedit == "edit") {?>
    function upload() {
        window.open("<?php echo base_url();?>video/file_view/<?php echo $datavideo['id_video'];?>", "_self")
        return false;
    }
    <?php } ?>

    function tambahki() {
        document.getElementById("dki2").style.display = "block";
        document.getElementById("dkd2_1").style.display = "block";
        return false;
    }

    function hapuski() {
        document.getElementById("dki2").style.display = "none";
        document.getElementById("dkd2_1").style.display = "none";
        document.getElementById("dkd2_2").style.display = "none";
        document.getElementById("dkd2_3").style.display = "none";
        return false;
    }

    function tambahkd(obj) {
        document.getElementById("dkd" + obj).style.display = "block";
        return false;
    }

    function hapuskd(obj) {
        document.getElementById("dkd" + obj).style.display = "none";
        return false;
    }

    function diklik_uploadvideo()
    {
        post('<?php echo base_url();?>video/upload_mp4', {video: 'mp4'});
    }

    function post(path, params, method='post') {

        // The rest of this code assumes you are not using a library.
        // It can be made less wordy if you use one.
        var form = document.createElement('form');
        form.method = method;
        form.action = path;

        for (var key in params) {
            if (params.hasOwnProperty(key)) {
                var hiddenField = document.createElement('input');
                hiddenField.type = 'hidden';
                hiddenField.name = key;
                hiddenField.value = params[key];

                form.appendChild(hiddenField);
            }
        }

        document.body.appendChild(form);
        form.submit();
    }

</script>
