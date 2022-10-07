<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$txt_sebagai = Array('', 'Guru', 'Siswa', 'Umum', 'Staf Fordorum');
$nama_verifikator = Array('-', 'Calon', 'Verifikator', 'Verifikator','','','','','','-');

$jml_user = 0;
foreach ($dafuser as $datane) {
    $jml_user++;
    $nomor[$jml_user] = $jml_user;
    $id_user[$jml_user] = $datane->id;
    $first_name[$jml_user] = $datane->first_name;
    $nomor_nasional[$jml_user] = $datane->nomor_nasional;
    $sekolah[$jml_user] = $datane->sekolah;
    $last_name[$jml_user] = $datane->last_name;
    $email[$jml_user] = $datane->email;
    if ($datane->activate == 0)
        $activate[$jml_user] = "<span style='font-weight:bold;color:red'> [belum aktif]</span>";
    else
        $activate[$jml_user] = "";
    $iscalon = "";
    if ($datane->alamat == "")
        $iscalon = "Calon ";
    $sebagai[$jml_user] = $iscalon . $txt_sebagai[$datane->sebagai];
    $idsebagai[$jml_user] = $datane->sebagai;

    $ket = '';
    if ($datane->verifikator > 1) {
        $ket = ' Staf';
        if ($datane->sebagai == 1) {
            $ket = ' Sekolah';
        }
    }

    $cekver[$jml_user] = '';
    if ($datane->verifikator == 3)
        $cekver[$jml_user] = 'checked';
    $cekkon[$jml_user] = '';
    if ($datane->kontributor == 3)
        $cekkon[$jml_user] = 'checked';

    $txt_verifikator[$jml_user] = $nama_verifikator[$datane->verifikator] . $ket;

}

?>

<div style="color:#000000;margin-left:10px;margin-right:10px;background-color:white;margin-top: 60px">
    <br>
    <center><span style="font-size:16px;font-weight: bold;"><?php echo $title; ?>
            <?php if ($this->session->userdata('a02') && $this->session->userdata('sebagai') == 1) {
                echo "<br>" . $sekolahku;
            }
            ?>
        </span></center>
    <br>
    <!--<button style="margin-left:10px" id="btn-show-all-children" type="button">Expand All</button>-->
    <!--<button style="margin-left:10px" id="btn-hide-all-children" type="button">Collapse All</button>-->
    <hr>

    <div id="tabel1" style="margin-left:10px;margin-right:10px;">
        <table id="tbl_user" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th style='width:5px;text-align:center'>No</th>
                <th style='width:20%;text-align:center'>Nama</th>
                <th style='width:15%;text-align:center'>Sebagai</th>
                <?php if ($this->session->userdata('a02') && $this->session->userdata('sebagai') != 1) { ?>
                <th style='width:20px;text-align:center'>Verifikator</th>
                <?php } ?>
                <th style='width:20px;text-align:center'>Kontributor</th>
                <?php if ($this->session->userdata('a02') && $this->session->userdata('sebagai') != 1) { ?>
                    <th style='text-align:center'>Nama Sekolah</th>
                <?php } ?>
                <!-- <th>Verifikator</th> -->
                <!-- <th class="none">Email</th> -->
                <th>Email</th>
                <th style='text-align:center'>Detail</th>


            </tr>
            </thead>

            <tbody>
            <?php for ($i = 1; $i <= $jml_user; $i++) {
                // if ($idsebagai[$i]!="4") continue;
                ?>

                <tr>
                    <td style='text-align:right'><?php echo $nomor[$i]; ?></td>
                    <td><?php echo $first_name[$i] . ' ' . $last_name[$i]; ?></td>
                    <td><?php echo $sebagai[$i] . $activate[$i]; ?></td>
                    <?php if ($this->session->userdata('a02') && $this->session->userdata('sebagai') != 1) { ?>
                    <td style='text-align:center'>
                        <input disabled type="checkbox" id="cver" name="cver" <?php echo $cekver[$i]; ?>>
                    </td>
                    <?php } ?>
                    <td style='text-align:center'>
                        <input disabled type="checkbox" id="ckont" name="ckont" <?php echo $cekkon[$i]; ?>>
                    </td>
                    <?php if ($this->session->userdata('a02') && $this->session->userdata('sebagai') != 1) { ?>
                        <td><?php echo $sekolah[$i]; ?></td>
                    <?php } ?>
                    <!-- <td><?php echo $txt_verifikator[$i]; ?></td> -->
                    <td><?php echo $email[$i]; ?></td>
                    <td style='text-align:center'>
                        <button onclick="window.location.href='<?php echo base_url(); ?>user/detil/<?php
                        echo $id_user[$i].'/'.$asal; ?>'">Detail
                        </button>
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


<script type="text/javascript" src="<?php echo base_url(); ?>/js/jquery-3.4.1.js"></script>
<script>

    //$('#d3').hide();

    $(document).ready(function () {
        var divx = document.getElementById('d1');
//divx.style.visibility = "hidden";
//divx.style.display = "none";

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


</script>
