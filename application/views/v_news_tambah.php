<script>document.getElementsByTagName("html")[0].className += " js";</script>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/tab_style.css">
<style>
    .inputan1 {
        text-align: center
    }
</style>

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$judul = "";
$topik = "";
$deskripsi = "";
$keyword = "";
$link_video = "";

$sel_kategori[0] = "";
$sel_kategori[1] = "";

if ($addedit == "add") {
    $judule = "Tambahkan Video Berita";
    $sel_jenis[1] = "selected";
    $disp[2] = 'style="display:none;"';
    $thumbs = base_url()."assets/images/blank.jpg";
    $durjam = "--";
    $durmenit = "--";
    $durdetik = "--";
    if (!isset($judulvideo))
        $file_video = "";
} else {
    $judule = "Edit Video Berita";
    $sel_kategori[$datavideo['id_kategori']] = "selected";
    if ($datavideo['id_kategori'] == 2) {
        $disp[1] = 'style="display:none;"';
        $disp[2] = 'style="display:block;"';
    } else {
        $disp[1] = 'style="display:block;"';
        $disp[2] = 'style="display:none;"';
    }

    $judul = $datavideo['judul'];
    $deskripsi = $datavideo['deskripsi'];
    $keyword = $datavideo['keyword'];
    $link_video = $datavideo['link_video'];
    $file_video = $datavideo['file_video'];
    $namafile = substr($file_video, 0, strlen($file_video) - 3) . rand(1, 32000) . '.jpg';
    $durasi = $datavideo['durasi'];
    $thumbs = $datavideo['thumbnail'];

//    if (substr($thumbs, 0, 4) != "http" && $thumbs != "")
//        $thumbs = base_url()."uploads/thumbs/" . $thumbs;

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
        $durjam = "--";
    if ($durmenit == "")
        $durmenit = "--";
    if ($durdetik == "")
        $durdetik = "--";

}

?>

<div style="margin-top: 60px">
    <center><span style="font-size:20px;font-weight:Bold;"><?php echo $judule; ?></span></center>
    <?php if ($addedit == "edit" && ($file_video != "")) { ?>
        <div style="text-align: center;margin: auto">
            <button class="btn btn-primary" onclick="window.open('<?php echo base_url(); ?>news','_self')">Kembali
            </button>
            <button class="btn btn-primary" onclick="return editmp4(<?php echo $datavideo['id_video']; ?>)">Ganti
                Video
            </button>
        </div>
    <?php } else { ?>
        <div style="text-align: center;margin: auto">
            <button class="btn btn-primary" onclick="window.open('<?php echo base_url(); ?>news','_self')">Kembali
            </button>
        </div>
    <?php } ?>

    <div class="row">
        <?php
        echo form_open('news/addvideo', array('autocomplete' => 'off', 'id' => 'myform'));
        ?>


        <div class="cd-tabs cd-tabs--vertical js-cd-tabs">

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
                                <?php echo $judul; ?>
                                <br>

                                <video id="video_playermp4" width="320" height="240" controls>
                                    <source src="<?php echo base_url(); ?>uploads/tve/<?php echo $file_video; ?>"
                                            type="video/mp4">
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
                            <input style="display:inline;width:25px;height:25px;margin:0;padding:0;" type="text"
                                   class="form-control" id="idurjam" name="idurjam" maxlength="2"
                                   value="<?php echo $durjam; ?>" readonly placeholder="--">
                            :
                            <input style="display:inline;width:25px;height:25px;margin:0;padding:0;" type="text"
                                   class="form-control" id="idurmenit" name="idurmenit" maxlength="2"
                                   value="<?php echo $durmenit; ?>" readonly placeholder="--">
                            :
                            <input style="display:inline;width:25px;height:25px;margin:0;padding:0;" type="text"
                                   class="form-control" id="idurdetik" name="idurdetik" maxlength="2"
                                   value="<?php echo $durdetik; ?>" readonly placeholder="--">
                        </div>
                        <?php
                    }
                    ?>


                    <div class="form-group" id="dkategori">
                        <label for="select" class="col-md-12 control-label">Kategori</label>
                        <div class="col-md-12">
                            <select class="form-control" name="ikategori" id="ikategori">
                                <option <?php echo $sel_kategori[0]; ?> value="1">Default</option>
                                <!--                                <option -->
                                <?php //echo $sel_kategori[1]; ?><!-- value="2">Konten Non Instruksional</option>-->
                            </select>
                        </div>
                    </div>


                </li>

                <li id="tab-new" class="cd-tabs__panel text-component">
                    <legend>Data Video</legend>

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
							<textarea
                                    rows="3" cols="60" class="form-control" id="ilink" name="ilink"
                                    maxlength="300"><?php echo $link_video; ?></textarea>
                            <button disabled="disabled" id="tbgetyutub" class="btn btn-default"
                                    onclick="return ambilinfoyutub()">OK
                            </button>
                            <br><br>

                        </div>

                    </div>

                    <div class="form-group">
                        <?php { ?>
                            <label for="inputDefault" class="col-md-12 control-label">Thumbnail</label>
                            <div class="col-md-12">
                                <?php { ?>
                                    <img id="img_thumb" style="align:middle;width:200px;"
                                         src="<?php echo $thumbs;?>">
                                <?php } ?>

                                <!--                                &nbsp;<button class="btn btn-default" onclick="return upload()">Upload Thumbnail-->
                                <!--                                </button>-->

                                <br><br>
                            </div>

                            <label for="inputDefault" class="col-md-12 control-label">Durasi (Jam:Menit:Detik)</label>
                            <div id="get_durasi" class="col-md-12">
                                <input style="display:inline;width:25px;height:25px;margin:0;padding:0" type="text"
                                       class="form-control inputan1" id="idurjam" name="idurjam" maxlength="2"
                                       value="<?php echo $durjam; ?>" placeholder="--">
                                :
                                <input style="display:inline;width:25px;height:25px;margin:0;padding:0" type="text"
                                       class="form-control inputan1" id="idurmenit" name="idurmenit" maxlength="2"
                                       value="<?php echo $durmenit; ?>" placeholder="--">
                                :
                                <input style="display:inline;width:25px;height:25px;margin:0;padding:0" type="text"
                                       class="form-control inputan1" id="idurdetik" name="idurdetik" maxlength="2"
                                       value="<?php echo $durdetik; ?>" placeholder="--">

                            </div>

                            <!--                            <div id="get_durasi">00:00:00</div>-->
                        <?php }
                        }
                        ?>

                        <!-- <?php //echo "ADDEDIT:".$addedit; ?> -->

                        <!--                        --><?php
                        //                        if ($datavideo['status_verifikasi'] == 2 || $datavideo['status_verifikasi'] == 4
                        //                            || $datavideo['status_verifikasi'] == 5) { ?>
                        <!--                            <input type="hidden" id="ilink" name="ilink"-->
                        <!--                                   value="-->
                        <?php //echo $datavideo['link_video']; ?><!--"/>-->
                        <!--                        --><?php //} ?>

                        <input type="hidden" id="addedit" name="addedit"
                               value="<?php if ($addedit == "edit") echo 'edit'; else echo 'add'; ?>"/>
                        <input type="hidden" id="kondisi" name="kondisi" value="2"/>
                        <input type="hidden" id="id_user" name="id_user" value=""/>
                        <input type="hidden" id="ytube_duration" name="ytube_duration" value=""/>
                        <input type="hidden" id="ytube_thumbnail" name="ytube_thumbnail" value=""/>
                        <!--                        <input type="hidden" id="status_ver" name="status_ver"-->
                        <!--                               value="-->
                        <?php //echo $datavideo['status_verifikasi']; ?><!--"/>-->

                        <input type="hidden" id="filevideo" name="filevideo"
                               value="<?php if ($addedit == "edit") echo $judul; else echo ''; ?>"/>
                        <input type="hidden" id="created" name="created"
                               value="<?php if ($addedit == "edit") echo $datavideo['created']; else echo ''; ?>"/>
                        <input type="hidden" id="id_berita" name="id_berita"
                               value="<?php if ($addedit == "edit") echo $datavideo['id_berita']; ?>"/>
                        <input type="hidden" id="idyoutube" name="idyoutube" value=""/>

                        <div class="form-group">
                            <div class="col-md-10 col-md-offset-0" style="margin-top: 20px">
                                <?php if ((($addedit == "edit") && ($datavideo['judul'] != "")) || $addedit == "add") { ?>
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

<!--<script src="--><?php //echo base_url() ?><!--js/jquery-3.4.1.js"></script>-->
<script src="<?php echo base_url(); ?>js/jquery-3.4.1.js"></script>
<script src="<?php echo base_url(); ?>js/tab_util.js"></script> <!-- util functions included in the CodyHouse framework -->
<script src="<?php echo base_url(); ?>js/tab_main.js"></script>

<script>
    //alert ("cew");
    <?php //if ($addedit == "edit") {
    //    if ($jenisvideo == "mp4")
    //    {?>
    //    //alert ("cekek");
    //    var myVideoPlayer = document.getElementById('video_playermp4');
    //    var _CANVAS = document.querySelector("#canvas-element");
    //    var _CANVAS_CTX = _CANVAS.getContext("2d");
    //
    //    myVideoPlayer.addEventListener('loadedmetadata', function () {
    //        var duration = myVideoPlayer.duration;
    //
    //        durasidetik = parseInt(duration.toFixed(2));
    //        hitungjam = parseInt(durasidetik / 3600);
    //        sisadetik = durasidetik - (hitungjam * 3600);
    //        hitungmenit = parseInt(sisadetik / 60);
    //        sisadetik = sisadetik - (hitungmenit * 60);
    //        hitungdetik = sisadetik;
    //        if (hitungjam < 10)
    //            hitungjam = "0" + hitungjam;
    //        if (hitungmenit < 10)
    //            hitungmenit = "0" + hitungmenit;
    //        if (hitungdetik < 10)
    //            hitungdetik = "0" + hitungdetik;
    //
    //        $('#idurjam').val(hitungjam);
    //        $('#idurmenit').val(hitungmenit);
    //        $('#idurdetik').val(hitungdetik);
    //
    //
    //    });
    //
    //    myVideoPlayer.addEventListener('timeupdate', function () {
    //
    //
    //        /*var link = document.getElementById('link');
    //        link.setAttribute('download', 'MintyPaper.png');
    //        link.setAttribute('href', _CANVAS.toDataURL("image/png").replace("image/png", "image/octet-stream"));*/
    //
    //
    //    });
    //
    //    function sethumb() {
    //        _CANVAS.width = 640;
    //        _CANVAS.height = 420;
    //
    //        _CANVAS_CTX.drawImage(myVideoPlayer, 0, 0, _CANVAS.width, _CANVAS.height);
    //
    //        datai = _CANVAS.toDataURL();
    //
    //        uploadcanvas();
    //        return false;
    //    }
    //
    //    function uploadcanvas() {
    //        $.ajax({
    //            url: "/tve/video/do_uploadcanvas",
    //            method: "POST",
    //            data: {canvasimage: datai, idvideo: '<?php //echo $idvideo;?>//', filevideo: '<?php //echo $namafile;?>//'},
    //            success: function (result) {
    //                document.getElementById("thumb1").src = "<?php echo base_url(); ?>uploads/thumbs/<?php //echo $namafile;?>//";
    //                console.log(result);
    //            },
    //            error: function () {
    //                alert('Error occured');
    //            }
    //        })
    //    }
    //
    //    <?php //}} ?>


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
        ambilki();
        ambiltema();
        ambiljurusan();
    });

    $(document).on('change', '#ikelas', function () {
        //alert ("hallo");
        ambiltema();
        ambilki();
    });

    $(document).on('change', '#imapel', function () {
        //alert ("hallo");
        ambilki();
    });

    $(document).on('change', '#ijurusan', function () {
        //alert ("hallo");
        ambilmapel();
    });

    function myFunction() {
        //alert ("hallo2");
    }

    $(document).on('change', '#iki1', function () {
        //alert ("sijilorotelu");
        ambilkd(1);
    });

    $(document).on('change', '#iki2', function () {
        ambilkd(2);
    });

    $(document).on('change', '#ilink2', function () {
        $('#img_thumb').src = "";
    });

    $("#ilink").change(function () {

    });


    $(document).ready(function () {
        $('#ilink').on('input', (event) => {
            if (document.getElementById("ilink").value != "") {
                document.getElementById("tbgetyutub").disabled = false;
            }
            else {
                document.getElementById("tbgetyutub").disabled = true;
            }
            document.getElementById("idurjam").value = "--";
            document.getElementById("idurmenit").value = "--";
            document.getElementById("idurdetik").value = "--";
            document.getElementById("img_thumb").src = "<?php echo base_url();?>assets/images/blank.jpg";
        });
    });

    $('#myform').on('keyup keypress', function (e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) {
            e.preventDefault();
            return false;
        }
    });

    function ambilinfoyutub() {
        idyutub = youtube_parser($("#ilink").val());
        $('#idyutube').val(idyutub);
        var filethumb = "https://img.youtube.com/vi/" + idyutub + "/0.jpg";
        $('#ytube_thumbnail').val(filethumb);

        $("#img_thumb").attr("src", filethumb);

        $.ajax({
            url: '<?php echo base_url();?>news/getVideoInfo/' + idyutub,
            type: 'GET',
            dataType: 'text',
            data: {
                foo: 'Test'
            },
            success: function (text) {
                //alert (text);
                if (text == "") {
                    alert ("Periksa alamat link YouTube");
                    ambiljam = "--";
                    ambilmenit = "--";
                    ambildetik = "--"
                }
                else {
                    ambiljam = text.substr(0, 2);
                    ambilmenit = text.substr(3, 2);
                    ambildetik = text.substr(6, 2);
                }
                html01 = '<input style="display:inline;width:25px;height:25px;margin:0;padding:0" type="text"' +
                    'class="form-control inputan1" id="idurjam" name="idurjam" maxlength="2" value="' + ambiljam + '" placeholder="00"> : ' +
                    '<input style="display:inline;width:25px;height:25px;margin:0;padding:0" type="text"' +
                    'class="form-control inputan1" id="idurmenit" name="idurmenit" maxlength="2" value="' + ambilmenit + '" placeholder="00"> : ' +
                    '<input style="display:inline;width:25px;height:25px;margin:0;padding:0" type="text"' +
                    'class="form-control inputan1" id="idurdetik" name="idurdetik" maxlength="2" value="' + ambildetik + '" placeholder="00">';

                $('#ytube_duration').val(html01);
                $('#get_durasi').html(html01);

            }
        });
        return false;
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
        var jenjang = $('#ijenjang').val();
        if (jenjang == 1) {
            isihtmlb0 = '<br><label for="select" class="col-md-12 control-label">Kelas</label><div class="col-md-12">';
            isihtmlb1 = '<select class="form-control" name="ikelas" id="ikelas">' +
                '<option value="0">-</option>';
            isihtmlb3 = '</select></div>';
            $('#dkelas').html(isihtmlb0 + isihtmlb1 + isihtmlb3);
        }
        else {
            isihtmlb0 = '<br><label for="select" class="col-md-12 control-label">Kelas</label><div class="col-md-12">';
            isihtmlb1 = '<select class="form-control" name="ikelas" id="ikelas">' +
                '<option value="0">-- Pilih --</option>';
            isihtmlb3 = '</select></div>';
            $.ajax({
                type: 'GET',
                data: {idjenjang: $('#ijenjang').val()},
                dataType: 'json',
                cache: false,
                url: '<?php echo base_url();?>video/daftarkelas',
                success: function (result) {
                    //alert ($('#itopik').val());
                    isihtmlb2 = "";
                    $.each(result, function (i, result) {
                        isihtmlb2 = isihtmlb2 + "<option value='" + result.id + "'>" + result.nama_kelas + "</option>";
                    });
                    hateemel = isihtmlb0 + isihtmlb1 + isihtmlb2 + isihtmlb3;
                    $('#dkelas').html(hateemel);
                    //console.log(hateemel);
                }
            });
        }
    }

    function ambilmapel() {

        var jenjang = $('#ijenjang').val();

        if ($('#ijurusan').val() == null)
            $('#dmapel').html("<input type='hidden' id='ijurusan' value=0 />");

        if (jenjang == 1) {
            var isihtmlmb0 = '<br><label for="select" class="col-md-12 control-label">Mata Pelajaran</label><div class="col-md-12">';
            var isihtmlmb1 = '<select class="form-control" name="imapel" id="imapel">' +
                '<option value="0">-</option>';
            var isihtmlmb3 = '</select></div>';
            $('#dmapel').html(isihtmlmb0 + isihtmlmb1 + isihtmlmb3);
        }
        else {
            var isihtmlb0 = '<br><label for="select" class="col-md-12 control-label">Mata Pelajaran</label><div class="col-md-12">';
            var isihtmlb1 = '<select class="form-control" name="imapel" id="imapel">' +
                '<option value="0">-- Pilih --</option>';
            var isihtmlb3 = '</select></div>';
            $.ajax({
                type: 'GET',
                data: {
                    idjenjang: $('#ijenjang').val(),
                    idjurusan: $('#ijurusan').val()
                },
                dataType: 'json',
                cache: false,
                url: '<?php echo base_url();?>video/daftarmapel',
                success: function (result) {
                    //alert ($('#itopik').val());
                    var isihtmlb2 = "";
                    $.each(result, function (i, result) {
                        isihtmlb2 = isihtmlb2 + "<option value='" + result.id + "'>" + result.nama_mapel + "</option>";
                    });
                    $('#dmapel').html(isihtmlb0 + isihtmlb1 + isihtmlb2 + isihtmlb3);
                }
            });
        }
    }

    function ambiltema() {
        var kelasbener = $('#ikelas').val() - 2;
        var jenjang = $('#ijenjang').val();

        if (jenjang != 2) {
            var isihtmlc = '<input type="hidden" id="itema" name="itema" value=0 />';
            $('#dtema').html(isihtmlc);
        }
        else {
            var isihtmlc0 = '<br><label for="select" class="col-md-12 control-label">Tema</label><div class="col-md-12">';
            var isihtmlc1 = '<select class="form-control" name="itema" id="itema">' +
                '<option value="0">-- Pilih --</option>';
            var isihtmlc3 = '</select></div>';
            $.ajax({
                type: 'GET',
                data: {idkelas: kelasbener},
                dataType: 'json',
                cache: false,
                url: '<?php echo base_url();?>video/daftartema',
                success: function (result) {
                    //alert ($('#itopik').val());
                    var isihtmlc2 = "";
                    $.each(result, function (i, result) {
                        isihtmlc2 = isihtmlc2 + "<option value='" + result.id + "'>" + result.nama_tematik + "</option>";
                    });
                    $('#dtema').html(isihtmlc0 + isihtmlc1 + isihtmlc2 + isihtmlc3);
                }
            });
        }
    }

    function ambiljurusan() {
        var jenjang = $('#ijenjang').val();

        if (jenjang != 5) {
            var isihtmld = '<input type="hidden" id="ijurusan" name="ijurusan" value=0 />';
            $('#djurusan').html(isihtmld);
        }
        else {
            var isihtmld0 = '<br><label for="select" class="col-md-12 control-label">Jurusan</label><div class="col-md-12">';
            var isihtmld1 = '<select class="form-control" name="ijurusan" id="ijurusan">' +
                '<option value="0">-- Semua Jurusan --</option>';
            var isihtmld3 = '</select></div>';
            $.ajax({
                type: 'GET',
                data: {idjenjang: jenjang},
                dataType: 'json',
                cache: false,
                url: '<?php echo base_url();?>video/daftarjurusan',
                success: function (result) {
                    //alert ($('#itopik').val());
                    var isihtmld2 = "";
                    $.each(result, function (i, result) {
                        isihtmld2 = isihtmld2 + "<option value='" + result.id + "'>" + result.nama_jurusan + "</option>";
                    });
                    $('#djurusan').html(isihtmld0 + isihtmld1 + isihtmld2 + isihtmld3);
                }
            });
        }
    }

    function ambilkd(ki) {

        //var pilkelas = document.getElementById("ikelas").value;
        //alert ("KI:"+$('#iki' + ki).val());


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
                // alert ($('#ikelas').val());
                isihtml2 = "";
                $.each(result, function (i, result) {
                    isihtml2 = isihtml2 + "<option value='" + result.id + "'>" + result.nama_kd + "</option>";
                    //alert (result.nama_kd);
                });
                $('#isidkd' + ki + '_1').html(isihtml1_1 + isihtml2 + isihtml3);
                $('#isidkd' + ki + '_2').html(isihtml1_2 + isihtml2 + isihtml3);
                $('#isidkd' + ki + '_3').html(isihtml1_3 + isihtml2 + isihtml3);
            }
        });
    }


    function ambilki() {

        var jenjang = $('#ijenjang').val();

        isihtml1 = '<select class="form-control" name="iki1" id="iki1">\n' +
            '<option value="0">-- Pilih --</option>\n';

        if (jenjang == 1) {
            isihtml2 = '<option value = "1" > Sikap Religius </option>' +
                '<option value = "2" > Sikap Sosial </option>' +
                '<option value = "3" > Pengetahuan </option>' +
                '<option value = "4" > Ketrampilan </option>';
        }
        else {
            isihtml2 = '<option value = "3" > Pengetahuan </option>' +
                '<option value = "4" > Ketrampilan </option>';
        }

        isihtml3 = '</select>';

        $('#isidki').html(isihtml1 + isihtml2 + isihtml3);
        // $('#isidki').html("kokok");
    }


    function cekaddvideo() {
        var oke1 = 1;
        var oke2 = 1;

        //ambilinfoyutub();
        //alert ($('#ytube_duration').val());

        var judul = document.getElementById("ijudul");
        var deskripsi = document.getElementById("ideskripsi");
        var keyword = document.getElementById("ikeyword");
        var link = document.getElementById("ilink");
        var durjam = document.getElementById("idurjam");
        var durmenit = document.getElementById("idurmenit");
        var durdetik = document.getElementById("idurdetik");

        //alert (jenis.value);


        if (judul.value == "" || judul.deskripsi == "" || judul.keyword == "" || link.value == "" || durjam.value == "--") {
            alert("Semua harus diisi");
            return false;
        }
        else {
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
    }

    function takon() {
        window.open("<?php echo base_url();?>news", "_self");
        return false;
    }

    function cekyutub() {
        window.open("<?php echo base_url();?>news", "_self");
        return false;
    }

    function editmp4(idvideo) {
        window.open("<?php echo base_url();?>video/upload_mp4/" + idvideo, "_self");
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

    function diklik_uploadvideo() {
        post('<?php echo base_url();?>video/upload_mp4', {video: 'mp4'});
    }

    function post(path, params, method = 'post') {

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
