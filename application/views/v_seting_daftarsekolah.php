<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$jml_jurusan = 0;

$jml_propinsi = 0;
foreach ($dafpropinsi as $datane) {
    $jml_propinsi++;
    $id_propinsi[$jml_propinsi] = $datane->id_propinsi;
    $nama_propinsi[$jml_propinsi] = $datane->nama_propinsi;
}

if($idpropinsi>0)
{
    $jml_kota = 0;
    foreach ($dafkota as $datane) {
        $jml_kota++;
        $id_kota[$jml_kota] = $datane->id_kota;
        $nama_kota[$jml_kota] = $datane->nama_kota;
    }

    $jml_sekolah = 0;
    foreach ($dafsekolah as $datane) {
        $jml_sekolah++;
        $id[$jml_sekolah] = $datane->id;
        $npsn[$jml_sekolah] = $datane->npsn;
        $nama_sekolah[$jml_sekolah] = $datane->nama_sekolah;
        $alamat_sekolah[$jml_sekolah] = $datane->alamat_sekolah;
    }
    //echo "IDKOTA".$idkota;
}



?>


<main id="myContainer" class="MainContainer">

</main>


<input type="hidden" class="form-control" id="iteksid" name="iteksid">

<script src="<?php echo base_url() ?>js/jquery-3.4.1.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/blur.js"></script>

<div style="color:#000000;margin-left:10px;margin-right:10px;background-color:white;margin-top: 60px;">
    <br>
    <center><span style="text-align:center;font-size:16px;font-weight: bold;"><?php echo $title; ?></span></center>
    <br>

    <div class="row" id="dpropinsi" style="width: 100%; max-width: 800px;margin-left:auto;margin-right: auto">
        <div class="mycolumns">
            <div class="mycolumn2" >
                <label>Propinsi <?php //echo $userData['kd_provinsi'];?></label>
                <select class="form-control" style="min-width: 200px" name="ipropinsi" id="ipropinsi">
                    <option value="0">-- Pilih --</option>
                    <?php
                    for ($b2 = 1; $b2 <= $jml_propinsi; $b2++) {
                        $terpilihb2 = '';
                        if ($id_propinsi[$b2] == $idpropinsi) {
                            $terpilihb2 = 'selected';
                        }
                        echo '<option ' . $terpilihb2 . ' value="' . $id_propinsi[$b2] . '">' . $nama_propinsi[$b2] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="mycolumn2" id="dkota">
                <label>Kota <?php //echo $userData['kd_provinsi'];?></label>
                <select class="form-control" style="min-width: 200px" name="ikota" id="ikota">
                    <option value="0">-- Pilih --</option>
                    <?php if ($idpropinsi>0)
                    {
                        for ($b3 = 1; $b3 <= $jml_kota; $b3++) {
                            $terpilihb3 = '';
                            if ($id_kota[$b3] == $idkota) {
                                $terpilihb3 = 'selected';
                            }
                            echo '<option ' . $terpilihb3 . ' value="' . $id_kota[$b3] . '">' . $nama_kota[$b3] . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
    </div>
    <br><br>

    <?php if ($jml_jurusan <= 20) { ?>
        <button type="button" onclick="return tambahsekolah()"
                style="float:right;margin-right:40px;margin-bottom:10px;">Tambah
        </button>
    <?php } ?>
    <div id="tabel1" style="margin-left:10px;margin-right:10px;">
        <table style="color: black" id="tbl_user" class="table table-striped table-bordered nowrap" cellspacing="0"
               width="100%">
            <thead>
            <tr>
                <th style=''>No</th>
                <th style=''>Nama Sekolah</th>
                <th style=''>NPSN</th>
                <th style=''>Alamat</th>
                <th style=''>Edit</th>
            </tr>
            </thead>

            <tbody>
            <?php
            if($idpropinsi>0)
            {
            for ($i = 1; $i <= $jml_sekolah; $i++) {
                ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $nama_sekolah[$i]; ?></td>
                    <td><?php echo $npsn[$i]; ?></td>
                    <td><?php echo $alamat_sekolah[$i]; ?></td>
                    <td>
                        <button onclick="diedit(<?php echo $id[$i]; ?>)" type="button">Edit</button> /
                        <button onclick="dihapus(<?php echo $id[$i]; ?>)" type="button">Hapus</button>
                    </td>
                </tr>
                <?php
            }
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

    $(document).on('change', '#ipropinsi', function () {
        getdaftarkota();
    });

    $(document).on('change', '#ikota', function () {
        window.open('<?php echo base_url();?>seting/daftarsekolah/'+$('#ikota').val(), '_self');

    });


    function getdaftarkota() {

        isihtml0 = '<label>Kota <?php //echo $userData['kd_provinsi'];?></label>';
        isihtml1 = '<select class="form-control" style="min-width: 200px" name="ikota" id="ikota">' +
            '<option value="0">-- Pilih --</option>';
        isihtml3 = '</select>';
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

    function tambahsekolah() {
        <?php if ($idkota!=null){echo "window.open('".base_url()."seting/tambahsekolah/".$idkota."', '_self');";} else
            echo "alert('Pilih Propinsi dan Kota/Kabupaten dulu');";?>

    }

    function diedit(idx) {
        window.open('<?php echo base_url();?>seting/editsekolah/'+idx, '_self');
    }

    function dihapus(idx) {
        var r = confirm("Yakin mau hapus sekolah ini?");

        if (r == true) {

            $.ajax({
                url: "<?php echo base_url();?>seting/delsekolah",
                method: "POST",
                data: {id: idx},
                success: function (result) {
                    window.open('<?php echo base_url();?>seting/daftarsekolah/<?php echo $idkota;?>', '_self');
                }
            });
        } else {
            return false;
        }
        return false;
    }

</script>
