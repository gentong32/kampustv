<?php
defined('BASEPATH')OR exit('No direct script access allowed');

$txt_sebagai = Array('','Guru','Siswa','Umum','Staf Pustekkom');

$jml_user = 0;
foreach ($dafuser as $datane)
{
    $jml_user++;
    $nomor[$jml_user]=$jml_user;
    $id_user[$jml_user]=$datane->id;
    $first_name[$jml_user]=$datane->first_name;
    $nomor_nasional[$jml_user]=$datane->nomor_nasional;
    $last_name[$jml_user]=$datane->last_name;
    $email[$jml_user]=$datane->email;
    $sekolah[$jml_user]=$datane->sekolah;
	$sebagai[$jml_user]=$txt_sebagai[$datane->sebagai];
	$verifikator[$jml_user]=$datane->verifikator;
	$kontributor[$jml_user]=$datane->kontributor;
}

?>

<div style="color:#000000;margin-left:10px;margin-right:10px;background-color:white;margin-top: 60px;">
<br><center><span style="font-size:16px;font-weight: bold;"><?php echo $title;?></span></center><br>
<!--<button style="margin-left:10px" id="btn-show-all-children" type="button">Expand All</button>-->
<!--<button style="margin-left:10px" id="btn-hide-all-children" type="button">Collapse All</button>-->
<hr>

<div id="tabel1" style="margin-left:10px;margin-right:10px;">
<table id="tbl_user" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%" >
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Sebagai</th>
            <th>Sekolah</th>
            <th>Status Verifikator</th>
			<th>Status Kontributor</th>
            <th class="none">NUPTK/NISN/NIP</th>
            <th class="none">Nama Belakang</th>
            <th class="none">Email</th>
            
            
        </tr>
    </thead>

    <tbody>
        <?php for ($i=1;$i<=$jml_user;$i++)
        {?>
        <tr>
            <td><?php echo $nomor[$i];?></td>
            <td><?php echo $first_name[$i].' '.$last_name[$i];?></td>
            <td><?php echo $sebagai[$i];?></td>
            <td><?php echo $sekolah[$i];?></td>
            <?php if($verifikator[$i]==1) {?>
            <td>Calon Verifikator (belum update profil)</td>
            <?php } else if($verifikator[$i]==2) {?>
            <td><button onclick="window.location.href='<?php echo base_url(); ?>user/detil/<?php
            echo $id_user[$i];?>'">Menunggu diverifikasi</button></td>
            <?php } else if($verifikator[$i]==0) {?>
				<td><button onclick="window.location.href='<?php echo base_url(); ?>user/detil/<?php
					echo $id_user[$i];?>'">Non Verifikator</button></td>
			<?php } else { ?>
            <td>
            <button onclick="window.location.href='<?php echo base_url(); ?>user/detil/<?php
            echo $id_user[$i];?>'"  id="btn-show-all-children" type="button" style="color:green">Verifikator</button></td>
            <?php } ?>
			<?php if($kontributor[$i]==1) {?>
				<td>Calon Kontributor (belum update profil)</td>
			<?php } else if($kontributor[$i]==2) {?>
				<td><button onclick="window.location.href='<?php echo base_url(); ?>user/detil/<?php
					echo $id_user[$i];?>'">Menunggu diverifikasi</button></td>
			<?php } else if($kontributor[$i]==0) {?>
				<td><button onclick="window.location.href='<?php echo base_url(); ?>user/detil/<?php
					echo $id_user[$i];?>'">Non Kontributor</button></td>
			<?php } else { ?>
				<td>
					<button onclick="window.location.href='<?php echo base_url(); ?>user/detil/<?php
					echo $id_user[$i];?>'"  id="btn-show-all-children" type="button" style="color:green">Kontributor</button></td>
			<?php } ?>
            <td><?php echo $nomor_nasional[$i];?></td>
            <td><?php echo $last_name[$i];?></td>
            <td><?php echo $email[$i];?></td>
            
            
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
    .text-wrap{
        white-space:normal;
    }
    .width-200{
        width:200px;
    }
    </style>
    
<script>

$(document).on('change', '#itahun', function() {
	get_analisis_view();
});

function get_analisis_view()
{
	window.open("/rtf2/home/filter/"+$('#itahun').val()+
	"/"+$('#iformal').val()+"/"+$('#iseri').val()+"/"+$('#ijenjang').val()+"/"+$('#imapel').val(),"_self");
}

$(document).ready(function (){
    var table = $('#tbl_user').DataTable({
        'responsive': true,
        'columnDefs' : [
                {
                    render: function (data, type, full, meta) {
                        return "<div class='text-wrap width-50'>" + data + "</div>";
                    },
                    targets: [1,2,3,4]
                },
                {
                     width: 25, 
                     targets: 0
                }
             ]
        
    });

   
    new $.fn.dataTable.FixedHeader( table );

    // Handle click on "Expand All" button
    $('#btn-show-all-children').on('click', function(){
        // Expand row details
        table.rows(':not(.parent)').nodes().to$().find('td:first-child').trigger('click');
    });

    // Handle click on "Collapse All" button
    $('#btn-hide-all-children').on('click', function(){
        // Collapse row details
        table.rows('.parent').nodes().to$().find('td:first-child').trigger('click');
    });
});


</script>
