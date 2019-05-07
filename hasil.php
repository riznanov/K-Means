<?php
$stop = false;
$centroid = array();
$groups = array();

$rows = $db->get_results("SELECT id_siswa FROM tb_siswa ORDER BY rand() LIMIT $jumlah");

$no = 1;
foreach($rows as $row){
    $centroid["C$no"] = $row->id_siswa;
    $no++;
}

function get_pusat_centroid($centroid = array(), $data = array()){
    $arr = array();
    foreach($centroid as $key => $val){
        $arr[$key] = $data[$val];
    }
    return $arr;
}

function get_jarak($row_data, $row_pusat_centroid){
    $result = 0;
    foreach($row_data as $key => $val){
        $result += pow($val - $row_pusat_centroid[$key], 2);
    }
    return sqrt($result);
}

function get_jarak_centroid($pusat_centroid = array(), $data = array()){
    $arr = array();

    foreach($data as $key => $val){
        foreach($pusat_centroid as $k => $v){
            $arr[$key][$k] = get_jarak($data[$key], $pusat_centroid[$k]);
        }
    }
    return $arr;
}

function get_keanggotaan($jarak_centroid = array()){
    $arr = array();
    foreach($jarak_centroid as $key => $val){
        $arr_min = array_keys($val, min($val));  
        if(count($arr_min)>1)      
            $arr_min = array_reverse($arr_min);
        $arr[$key] = $arr_min[0];
    }
    return $arr;
}


function get_pusat_centroid_baru($data, $keanggotaan){
    $arr = array();
    foreach($data as $key => $val){
        foreach($val as $k => $v){
            $arr[$keanggotaan[$key]][$k][]= $v;    
        }        
    }
    $pembagi = count($data);
    $result = array();
    foreach($arr as $key => $val){
        foreach($val as $k => $v){
            $result[$key][$k] = array_sum($v) / count($v);    
        }
    }
    return $result;
}
$pusat_centroid = get_pusat_centroid($centroid, $data); 
?>
<style type="text/css">
<!--
.style1 {font-size: 18px}
-->
</style>

<div id="hasil" class="panel panel-default">
    <div class="panel-heading">Hasil Perhitungan</div>
    <div class="panel-body">        
        <p>
            <button class="btn btn-primary" data-toggle="collapse" href="#perhitungan"><span class="glyphicon glyphicon-search"></span> Perhitungan</button>
        </p>
        <div id="perhitungan" class="collapse">                        
            <?php               
            $iterasi = 1;
            while(!$stop && $iterasi <= $maksimum):        
                $jarak_centroid = get_jarak_centroid($pusat_centroid, $data);     
                $keanggotaan = get_keanggotaan($jarak_centroid);                                                                                                             
            ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Iterasi <?=$iterasi?></h3>
                </div>
                <div class="panel-body">Pusat centroid</div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead><tr>
                            <th>Nama</th>
                            <?php                         
                            foreach($KRITERIA as $key => $val):?>
                            <th><?=$val['nama']?></th>
                            <?php endforeach?>
                        </tr></thead>
                        <?php foreach($pusat_centroid as $key => $val):?>
                        <tr>
                            <td><?=$key?></td>                            
                            <?php foreach($val as $k => $v):?>
                            <td><?=round($v, 4)?></td>
                            <?php endforeach?>
                        </tr>
                        <?php endforeach?>
                    </table>
                </div>
                <div class="panel-body">Jarak Terhadap Pusat centroid</div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead><tr>
                            <th>Nama</th>
                            <?php                         
                            foreach($KRITERIA as $key => $val):?>
                            <th><?=$val['nama']?></th>
                            <?php endforeach?>
                            <?php foreach($pusat_centroid as $key => $val):?>
                            <th><?=$key?></th>
                            <?php endforeach?>
                            <th>Group</th>
                        </tr></thead>
                        <?php foreach($jarak_centroid as $key => $val):?>
                        <tr>
                            <td><?=$ALTERNATIF[$key]['kode']?></td>
                            <?php foreach($data[$key] as $k => $v):?>
                            <td><?=$v?></td>
                            <?php endforeach?>
                            <?php foreach($val as $k => $v):?>
                            <td><?=round($v, 4)?></td>
                            <?php endforeach?>
                            <td><?=$keanggotaan[$key]?></td>
                        </tr>                    
                        <?php endforeach?>
                    </table>
                </div>
                
                <div class="panel-body">
                <?php
                if($iterasi==$maksimum && $groups != $keanggotaan){
                    $stop = true;
                    $ket = "Karena iterasi ($iterasi) sudah mencapai maksimum iterasi, maka iterasi dihentikan.";
                } else if($groups == $keanggotaan){
                    $stop = true; 
                    $ket = "Karena group baru (".implode(',', $keanggotaan).") = group sebelumnya (".implode(',', $groups)."), maka iterasi dihentikan.";   
                } else {
                    $iterasi++;
                    $ket = "Karena group baru (".implode(',', $keanggotaan).") <> group sebelumnya (".implode(',', $groups)."), maka iterasi dilanjutkan.";                    
                    $pusat_centroid = get_pusat_centroid_baru($data, $keanggotaan);                    
                    $groups = $keanggotaan;
                }                                    
                ?>
                <?=$ket?>
                </div>
            </div>
            <?php endwhile;
            $arr = array();
            foreach($keanggotaan as $key => $val){
                $arr[$val]++;
            }
            $chart = array();
            foreach($arr as $key => $val){
                $chart[] = array(
                    'name' => $key,
                    'y' => $val,
                );
            }                
            ?>                
        </div>                                       
    </div>
	<div id="hasil" class="panel panel-default">
	  <div class="panel-heading style1"><strong>Hasil Pengelompokan Siswa Berdasarkan Kelas</strong></div>     
        <form class="form-inline">
            <input type="hidden" name="m" value="hasil" />
            <div class="form-group">
                <a class="btn btn-primary" data-toggle="collapse" href="#a">A</a>
            </div>
			<div class="form-group">
                <a class="btn btn-primary" data-toggle="collapse" href="#b">B</a>
            </div>
			<div class="form-group">
                <a class="btn btn-primary" data-toggle="collapse" href="#c">C</a>
            </div>
			<div class="form-group">
                <a class="btn btn-primary" data-toggle="collapse" href="#d">D</a>
            </div>
			<div class="form-group">
                <a class="btn btn-primary" data-toggle="collapse" href="#e">E</a>
            </div>
			<div class="form-group">
                <a class="btn btn-primary" data-toggle="collapse" href="#f">F</a>
            </div>
			<div class="form-group">
                <a class="btn btn-primary" data-toggle="collapse" href="#g">G</a>
            </div>
			<div class="form-group">
                <a class="btn btn-primary" data-toggle="collapse" href="#h">H</a>
            </div>
        </form>
    </div>	
</div>
	<div id="a" class="collapse">   
    <div class="table-responsive">
    <table class="table table-bordered table-hover table-striped">
        <thead><tr>
            <th>No</th>
            <th>Nomor Induk</th>
            <th>Nama Siswa</th>
			<th>Alamat</th>
			<th>Asal Sekolah</th>
            <th>Jumlah Nilai</th>
			<th>Centroid</th>
        </tr></thead>
        <?php
        $q = esc_field($_GET['q']);
        $rows = $db->get_results("SELECT * FROM tb_siswa WHERE centroid = 'C1' order by rata_rata DESC ");
        $no=0;
        
        foreach($rows as $row):?>
        <tr>
            <td><?=++$no ?></td>
            <td><?=$row->kode_siswa?></td>
            <td><?=$row->nama_siswa?></td>
			<td><?=$row->alamat?></td>
			<td><?=$row->asal_sekolah?></td>
            <td><?=$row->rata_rata?></td>
		    <td><?=$row->centroid?></td>
        </tr>
    <?php endforeach; ?>
    </table>
	</div>
	</div>

	<div id="b" class="collapse">   
    <div class="table-responsive">
    <table class="table table-bordered table-hover table-striped">
        <thead><tr>
            <th>No</th>
            <th>Nomor Induk</th>
            <th>Nama Siswa</th>
			<th>Alamat</th>
			<th>Asal Sekolah</th>
            <th>Centroid</th>
        </tr></thead>
        <?php
        $q = esc_field($_GET['q']);
        $rows = $db->get_results("SELECT * FROM tb_siswa WHERE centroid = 'C2'");
        $no=0;
        
        foreach($rows as $row):?>
        <tr>
            <td><?=++$no ?></td>
            <td><?=$row->kode_siswa?></td>
            <td><?=$row->nama_siswa?></td>
			<td><?=$row->alamat?></td>
			<td><?=$row->asal_sekolah?></td>
            <td><?=$row->centroid?></td>
        </tr>
    <?php endforeach; ?>
    </table>
	</div>
	</div>
	
	<div id="c" class="collapse">   
    <div class="table-responsive">
    <table class="table table-bordered table-hover table-striped">
        <thead><tr>
            <th>No</th>
            <th>Nomor Induk</th>
            <th>Nama Siswa</th>
			<th>Alamat</th>
			<th>Asal Sekolah</th>
            <th>Centroid</th>
        </tr></thead>
        <?php
        $q = esc_field($_GET['q']);
        $rows = $db->get_results("SELECT * FROM tb_siswa WHERE centroid = 'C3'");
        $no=0;
        
        foreach($rows as $row):?>
        <tr>
            <td><?=++$no ?></td>
            <td><?=$row->kode_siswa?></td>
            <td><?=$row->nama_siswa?></td>
			<td><?=$row->alamat?></td>
			<td><?=$row->asal_sekolah?></td>
            <td><?=$row->centroid?></td>
        </tr>
    <?php endforeach; ?>
    </table>
	</div>
	</div>
	<div id="d" class="collapse">   
    <div class="table-responsive">
    <table class="table table-bordered table-hover table-striped">
        <thead><tr>
            <th>No</th>
            <th>Nomor Induk</th>
            <th>Nama Siswa</th>
			<th>Alamat</th>
			<th>Asal Sekolah</th>
            <th>Centroid</th>
        </tr></thead>
        <?php
        $q = esc_field($_GET['q']);
        $rows = $db->get_results("SELECT * FROM tb_siswa WHERE centroid = 'C4'");
        $no=0;
        
        foreach($rows as $row):?>
        <tr>
            <td><?=++$no ?></td>
            <td><?=$row->kode_siswa?></td>
            <td><?=$row->nama_siswa?></td>
			<td><?=$row->alamat?></td>
			<td><?=$row->asal_sekolah?></td>
            <td><?=$row->centroid?></td>
        </tr>
    <?php endforeach; ?>
    </table>
	</div>
	</div>
	<div id="e" class="collapse">   
    <div class="table-responsive">
    <table class="table table-bordered table-hover table-striped">
        <thead><tr>
            <th>No</th>
            <th>Nomor Induk</th>
            <th>Nama Siswa</th>
			<th>Alamat</th>
			<th>Asal Sekolah</th>
            <th>Centroid</th>
        </tr></thead>
        <?php
        $q = esc_field($_GET['q']);
        $rows = $db->get_results("SELECT * FROM tb_siswa WHERE centroid = 'C5'");
        $no=0;
        
        foreach($rows as $row):?>
        <tr>
            <td><?=++$no ?></td>
            <td><?=$row->kode_siswa?></td>
            <td><?=$row->nama_siswa?></td>
			<td><?=$row->alamat?></td>
			<td><?=$row->asal_sekolah?></td>
            <td><?=$row->centroid?></td>
        </tr>
    <?php endforeach; ?>
    </table>
	</div>
	</div>
	<div id="f" class="collapse">   
    <div class="table-responsive">
    <table class="table table-bordered table-hover table-striped">
        <thead><tr>
            <th>No</th>
            <th>Nomor Induk</th>
            <th>Nama Siswa</th>
			<th>Alamat</th>
			<th>Asal Sekolah</th>
            <th>Centroid</th>
        </tr></thead>
        <?php
        $q = esc_field($_GET['q']);
        $rows = $db->get_results("SELECT * FROM tb_siswa WHERE centroid = 'C6'");
        $no=0;
        
        foreach($rows as $row):?>
        <tr>
            <td><?=++$no ?></td>
            <td><?=$row->kode_siswa?></td>
            <td><?=$row->nama_siswa?></td>
			<td><?=$row->alamat?></td>
			<td><?=$row->asal_sekolah?></td>
            <td><?=$row->centroid?></td>
        </tr>
    <?php endforeach; ?>
    </table>
	</div>
	</div>
	<div id="g" class="collapse">   
    <div class="table-responsive">
    <table class="table table-bordered table-hover table-striped">
        <thead><tr>
            <th>No</th>
            <th>Nomor Induk</th>
            <th>Nama Siswa</th>
			<th>Alamat</th>
			<th>Asal Sekolah</th>
            <th>Centroid</th>
        </tr></thead>
        <?php
        $q = esc_field($_GET['q']);
        $rows = $db->get_results("SELECT * FROM tb_siswa WHERE centroid = 'C7'");
        $no=0;
        
        foreach($rows as $row):?>
        <tr>
            <td><?=++$no ?></td>
            <td><?=$row->kode_siswa?></td>
            <td><?=$row->nama_siswa?></td>
			<td><?=$row->alamat?></td>
			<td><?=$row->asal_sekolah?></td>
            <td><?=$row->centroid?></td>
        </tr>
    <?php endforeach; ?>
    </table>
	</div>
	</div>
	<div id="h" class="collapse">   
    <div class="table-responsive">
    <table class="table table-bordered table-hover table-striped">
        <thead><tr>
            <th>No</th>
            <th>Nomor Induk</th>
            <th>Nama Siswa</th>
			<th>Alamat</th>
			<th>Asal Sekolah</th>
            <th>Centroid</th>
        </tr></thead>
        <?php
        $q = esc_field($_GET['q']);
        $rows = $db->get_results("SELECT * FROM tb_siswa WHERE centroid = 'C8'");
        $no=0;
        
        foreach($rows as $row):?>
        <tr>
            <td><?=++$no ?></td>
            <td><?=$row->kode_siswa?></td>
            <td><?=$row->nama_siswa?></td>
			<td><?=$row->alamat?></td>
			<td><?=$row->asal_sekolah?></td>
            <td><?=$row->centroid?></td>
        </tr>
    <?php endforeach; ?>
    </table>
	</div>
	</div>
    <div class="panel-body">
        <a class="btn btn-primary" href="cetak.php?m=hasil" target="_blank"><span class="glyphicon glyphicon-print"></span> Cetak</a>
    </div>
</div>
