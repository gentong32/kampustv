<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$nmjenjang = array("", "PAUD", "SD", "SMP", "SMA", "SMK", "PT", "PKBM", "PPS", "Lain", "SD", "SMP", "SMP", "SMP", "SMA", "SMA",
	"SMA", "kursus", "PKBM", "pondok", "PT");

if ($addedit == 'edit') {
    $title = "Edit Sekolah";
    foreach ($dafsekolah as $datane) {
        $id = $datane->id;
        $npsn = $datane->npsn;
        $nama_sekolah = $datane->nama_sekolah;
        $alamat_sekolah = $datane->alamat_sekolah;
        $kecamatan = $datane->kecamatan;
        $desa = $datane->desa;
        $idjenjang = $datane->id_jenjang;
    }

    $terpilih = array();
    for ($a1 = 1; $a1 <= 20; $a1++) {
        $terpilih[$a1] = "";
        if ($a1 == $idjenjang) {
            $terpilih[$a1] = " selected";
        }
    }
}

//echo "<br><br><br><br>IDKOTA:" . $idkota;

?>

<div style="margin-top: 60px">
    <center><span style="font-size:20px;font-weight:Bold;"><?php echo $title; ?></span></center>

    <div class="row">
        <div class="row" style="width: 100%; max-width: 800px;margin-left:auto;margin-right: auto">
            <div class="mycolumns">
                <div class="mycolumn2">
                    <label><?php echo $nama_propinsi; ?></label>
                </div>
                <div class="mycolumn2" id="dkota">
                    <label><?php echo $nama_kota; ?></label>
                </div>
            </div>
        </div>

        <div class="row" style="width: 100%; max-width: 800px;margin-left:auto;margin-right: auto">

            <div class="mycolumns2">
                <div class="mycolumnA">
                    <label>Jenjang Sekolah</label>
                </div>
                <div class="mycolumnB">
                    <select class="form-control" name="ijenjang" id="ijenjang">
                        <option value="0">- Pilih Jenjang -</option>
                        <option <?php if ($addedit == 'edit') echo $terpilih[1]; ?> value="1">PAUD</option>
                        <option <?php if ($addedit == 'edit') echo $terpilih[2]; ?> value="2">SD/MI</option>
                        <option <?php if ($addedit == 'edit') echo $terpilih[3]; ?> value="3">SMP/MTs</option>
                        <option <?php if ($addedit == 'edit') echo $terpilih[4]; ?> value="4">SMA/MA</option>
                        <option <?php if ($addedit == 'edit') echo $terpilih[5]; ?> value="5">SMK/MAK</option>
						<option <?php if ($addedit == 'edit') echo $terpilih[6]; ?> value="6">PT</option>
						<option <?php if ($addedit == 'edit') echo $terpilih[7]; ?> value="7">PKBM/Kursus</option>
                    </select>
                </div>
            </div>

            <div class="mycolumns2">
                <div class="mycolumnA">
                    <label>Nama Sekolah</label>
                </div>
                <div class="mycolumnB">
                    <input type="text" value="<?php
                    if ($addedit == 'edit')
                    {
                        echo $nama_sekolah;
                    }?>" class="form-control" id="inamasekolah" name="inamasekolah" maxlength="100">
                </div>
            </div>

            <div class="mycolumns2">
                <div class="mycolumnA">
                    <label>Alamat Sekolah</label>
                </div>
                <div class="mycolumnB">
                    <input type="text" value="<?php
                    if ($addedit == 'edit')
                    {
                        echo $alamat_sekolah;
                    }?>" class="form-control" id="ialamatsekolah" name="ialamatsekolah" maxlength="100">
                </div>
            </div>

            <div class="mycolumns2">
                <div class="mycolumnA">
                    <label>NPSN</label>
                </div>
                <div class="mycolumnB">
                    <input type="text" value="<?php
                    if ($addedit == 'edit')
                    {
                        echo $npsn;
                    }?>" class="form-control" id="inpsn" name="inpsn" maxlength="100">
                </div>
            </div>

            <div class="mycolumns2">
                <div class="mycolumnA">
                    <label>Kecamatan</label>
                </div>
                <div class="mycolumnB">
                    <input type="text" value="<?php
                    if ($addedit == 'edit')
                    {
                        echo $kecamatan;
                    }?>" class="form-control" id="ikecamatan" name="ikecamatan" maxlength="100">
                </div>
            </div>

            <div class="mycolumns2">
                <div class="mycolumnA">
                    <label>Desa</label>
                </div>
                <div class="mycolumnB">
                    <input type="text" value="<?php
                    if ($addedit == 'edit')
                    {
                        echo $desa;
                    }?>" class="form-control" id="idesa" name="idesa" maxlength="100">
                </div>
            </div>

            <div class="mycolumns2">
                <button style="margin-right: 10px;" class="btn" onclick="return kembaliya()">Batal</button>
                <button class="btn btn-success" onclick="return cekdulu()"><?php
                    if ($addedit == 'edit')
                    {echo "Update";} else {echo "Simpan";}?></button>
            </div>

        </div>
    </div>
</div>


<script>

    function cekdulu() {

        var cekjenjang = $('#ijenjang').val();
        var ceknama = $('#inamasekolah').val();
        var cekalamat = $('#ialamatsekolah').val();
        var ceknpsn = $('#inpsn').val();
        var cekkecamatan = $('#ikecamatan').val();
        var cekdesa = $('#idesa').val();

        if (cekjenjang > 0 && ceknama.length > 3 && cekalamat.length > 3 && ceknpsn.length > 3 &&
            cekkecamatan.length > 3 && cekdesa.length > 3) {
            $.ajax({
                url: "<?php echo base_url();?>seting/updatesekolah",
                method: "POST",
                data: {
                    idjenjang: cekjenjang, idkota: <?php if ($idkota != null) {
                        echo $idkota;}?>, nama_sekolah: ceknama,<?php
                    if ($addedit=='edit')
                    {
                        echo ' idsekolah:'.$id.',';
                    };?>
                    alamat_sekolah: cekalamat, npsn: ceknpsn, kecamatan: cekkecamatan, desa: cekdesa, addedit: '<?php
                        echo $addedit;?>'},
                success: function (result) {
                    window.open('<?php echo base_url();?>seting/daftarsekolah/<?php if ($idkota != null) {
                        echo $idkota;
                    }?>', '_self');
                },
                error: function(result) {
                    alert("Data gagal tersimpan, kemungkinan nomor NPSN sudah ada");
                }
            })
        }
        else {
            alert("Lengkapi data sekolah!")
        }
    }

    //function ceklagi(idx) {
    //
    //    var cekjenjang = $('#ijenjang').val();
    //    var ceknama = $('#inamasekolah').val();
    //    var cekalamat = $('#ialamatsekolah').val();
    //    var ceknpsn = $('#inpsn').val();
    //    var cekkecamatan = $('#ikecamatan').val();
    //    var cekdesa = $('#idesa').val();
    //
    //    if (cekjenjang > 0 && ceknama.length > 3 && cekalamat.length > 3 && ceknpsn.length > 3 &&
    //        cekkecamatan.length > 3 && cekdesa.length > 3) {
    //        $.ajax({
    //            url: "/tve/seting/updatesekolah",
    //            method: "POST",
    //            data: {
    //                idjenjang: cekjenjang, idkota: <?php //if ($idkota != null) {
    //                    echo $idkota;
    //                }?>//, nama_sekolah: ceknama,
    //                alamat_sekolah: cekalamat, npsn: ceknpsn, kecamatan: cekkecamatan, desa: cekdesa, idsekolah: cekid,
    //                addedit: 'edit'
    //            },
    //            success: function (result) {
    //                window.open('<?php echo base_url();?>seting/daftarsekolah/<?php //if ($idkota != null) {
    //                    echo $idkota;
    //                }?>//', '_self');
    //            }
    //        })
    //    }
    //    else {
    //        alert("Lengkapi data sekolah!")
    //    }
    //}

    function kembaliya() {
        //alert("YI");
        window.history.back();
        return false;

    }

</script>
