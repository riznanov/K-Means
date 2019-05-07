<?php
$rasio_sebelum = 0;

$stop = false;

$cluster = array();

$rows = $db->get_results("SELECT id_siswa FROM tb_siswa ORDER BY rand() LIMIT $jumlah");

foreach($rows as $row){
    $cluster[] = $row->id_siswa;
}

//$cluster = array('C1' => 2, 'C2' => 5, 'C3' => 6);

function get_pusat_cluster($cluster = array(), $data = array()){
    $arr = array();
    foreach($cluster as $key => $val){
        $arr[$key] = $data[$val];
    }
    return $arr;
}

function get_jarak($row_data, $row_pusat_cluster){
    $result = 0;
    foreach($row_data as $key => $val){
        $result += pow($val - $row_pusat_cluster[$key], 2);
        //echo "pow($val - $row_pusat_cluster[$key], 2)<br />";
    }
    //echo "sqrt($result) <br />";
    return sqrt($result);
}

function get_jarak_cluster($pusat_cluster = array(), $data = array()){
    $arr = array();

    foreach($data as $key => $val){
        foreach($pusat_cluster as $k => $v){
            $arr[$key][$k] = get_jarak($data[$key], $pusat_cluster[$k]);
        }
    }
    return $arr;
    //echo '<pre>'.print_r($arr, 1).'</pre>';
}

function get_keanggotaan($jarak_cluster = array()){
    $arr = array();
    foreach($jarak_cluster as $key => $val){
        $arr_min = array_keys($val, min($val));  
        if(count($arr_min)>1)      
            $arr_min = array_reverse($arr_min);
        $arr[$key] = $arr_min[0];
    }
    //echo '<pre>'.print_r($arr, 1).'</pre>';
    return $arr;
}

function get_minimum($keanggotaan, $jarak_cluster){
    $arr = array();
    foreach($keanggotaan as $key => $val){
        $arr[$key] = $jarak_cluster[$key][$val];
    }
    return $arr;
}

function get_kuadrat($minimum){
    $arr = array();
    foreach($minimum as $key => $val){
        $arr[$key] = pow($val, 2);
    }
    return $arr;
}

function get_wcv($kuadrat){
    return array_sum($kuadrat);
}

function get_cluster_baru($keanggotaan, $cluster, $data){
    $arr = array();
    foreach($data as $key => $val){
        foreach($cluster as $k => $v){
            foreach($val as $a => $b){                
                if($keanggotaan[$key]==$k){
                    $arr[$key][$k][$a] = $b;
                } else {
                    $arr[$key][$k][$a] = null;
                }
            }
        }
    }
    return $arr;
    //echo '<pre>'.print_r($arr, 1).'</pre>';
}

function get_avg($cluster_baru){
    $arr = array();
    foreach($cluster_baru as $key => $val){
        foreach($val as $k => $v){
            foreach($v as $a => $b){
                if($b!=null){
                    $arr[$k][$a][] = $b;
                }
            }
        }
    }
    $avgs = array();
    foreach($arr as $key => $val){
        foreach($val as $k => $v){
            if(count($val)>0)
                $avgs[$key][$k] = array_sum($v)/count($v);
            else
                $avgs[$key][$k] = 0;
        }            
    }
    //echo '<pre>'.print_r($avgs, 1).'</pre>';
    return $avgs;
}

function get_cluster_combination($cluster){
    $arr = array();
    foreach($cluster as $key => $val){
        foreach($cluster as $k => $v){
        
            if(!isset($arr[$k][$key]) && $key!=$k)
                $arr[$key][$k] = 0;
                    
        }
    }    
    $result = array();
    foreach($arr as $key => $val){
        foreach($val as $k => $v){
            $result[] = array($key, $k);
        }
    }    
    return $result;    
}

function get_jarak_pusat_cluster($combination, $pusat_cluster){
    $arr = array();
    foreach($combination as $key => $val){
        $arr[$key] = get_jarak($pusat_cluster[$val[0]], $pusat_cluster[$val[1]]);      
    }
    
    //echo '<pre>'.print_r($arr, 1).'</pre>';
    return $arr;
}
$pusat_cluster = get_pusat_cluster($cluster, $data); 
?>
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
                $jarak_cluster = get_jarak_cluster($pusat_cluster, $data);     
                $keanggotaan = get_keanggotaan($jarak_cluster);
                $minimum = get_minimum($keanggotaan, $jarak_cluster);
                $kuadrat = get_kuadrat($minimum);
                $wcv = get_wcv($kuadrat);
                $cluster_baru = get_cluster_baru($keanggotaan, $cluster, $data);
                $avg = get_avg($cluster_baru);
                                
                $combination = get_cluster_combination($cluster);
                $jarak_pusat_cluster = get_jarak_pusat_cluster($combination, $pusat_cluster);
                $rasio = array_sum($jarak_pusat_cluster) / $wcv;
                    
            ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Iterasi <?=$iterasi?></h3>
                </div>
                <div class="panel-body">Pusat Cluster</div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead><tr>
                            <th>Nama</th>
                            <?php                         
                            foreach($KRITERIA as $key => $val):?>
                            <th><?=$val['nama']?></th>
                            <?php endforeach?>
                        </tr></thead>
                        <?php foreach($pusat_cluster as $key => $val):?>
                        <tr>
                            <td><?=$key?></td>
                            <?php foreach($val as $k => $v):?>
                            <td><?=$v?></td>
                            <?php endforeach?>
                        </tr>
                        <?php endforeach?>
                    </table>
                </div>
                <div class="panel-body">Jarak Terhadap Pusat Cluster</div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead><tr>
                            <th>Nama</th>
                            <?php foreach($pusat_cluster as $key => $val):?>
                            <th><?=$key?></th>
                            <?php endforeach?>
                        </tr></thead>
                        <?php foreach($jarak_cluster as $key => $val):?>
                        <tr>
                            <td><?=$ALTERNATIF[$key]['kode']?></td>
                            <?php foreach($val as $k => $v):?>
                            <td><?=round($v, 4)?></td>
                            <?php endforeach?>
                        </tr>                    
                        <?php endforeach?>
                        <tr>
                            <td class="text-right" colspan="<?=count($cluster)?>">WCV</td>
                            <td><?=round($wcv, 4)?></td>
                        </tr>
                    </table>
                </div>
                <div class="panel-body">Keanggotaan Cluster dan Jarak Minimum</div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead><tr>
                            <th>Nama</th>
                            <th>Keanggotaan</th>
                            <th>Minimum</th>
                            <th>Kuadrat</th>
                        </tr></thead>
                        <?php foreach($keanggotaan as $key => $val):?>
                        <tr>
                            <td><?=$ALTERNATIF[$key]['kode']?></td>
                            <td><?=$val?></td>
                            <td><?=round($minimum[$key], 4)?></td>
                            <td><?=round($kuadrat[$key], 4)?></td>
                        </tr>
                        <?php endforeach?>
                    </table>
                </div>
                <div class="panel-body">Pusat Cluster Baru</div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead><tr>
                            <th rowspan="2">Nama</th>
                            <?php foreach($cluster as $key => $val):?>
                            <th class="text-center" colspan="<?=count($KRITERIA)?>"><?=$key?></th>
                            <?php endforeach?>
                        </tr>
                        <tr>
                            <?php foreach($cluster as $key => $val):?>
                                <?php foreach($KRITERIA as $key => $val):?>
                                <th><?=$val[nama]?></th>
                                <?php endforeach?>
                            <?php endforeach?>
                        </tr></thead>
                        <?php foreach($cluster_baru as $key => $val):?>
                        <tr>
                            <td><?=$ALTERNATIF[$key]['kode']?></td>
                            <?php foreach($val as $k => $v):?>
                                <?php foreach($v as $a => $b):?>                          
                                <td><?=$b?></td>
                                <?php endforeach?>
                            <?php endforeach?>
                        </tr>                    
                        <?php endforeach?>
                        <tr>
                            <td>Pusat Cluster</td>
                            <?php foreach($cluster as $key => $val):?>
                                <?php foreach($KRITERIA as $k => $v):?>                          
                                <td><?=round($avg[$key][$k], 4)?></td>
                                <?php endforeach?>
                            <?php endforeach?>
                        </tr>
                    </table>
                </div>
                <div class="panel-body">Jarak Antar Cluster Baru</div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">    
                        <thead><tr>
                            <td>Cluster 1</td>
                            <td>Cluster 1</td>
                            <td>D</td>
                        </tr></thead>                
                        <?php foreach($combination as $key => $val):?>
                        <tr>
                            <td><?=$val[0]?></td>
                            <td><?=$val[1]?></td> 
                            <td><?=round($jarak_pusat_cluster[$key], 4)?></td>                        
                        </tr>
                        <?php endforeach?>
                        <tr>
                            <td class="text-right" colspan="2">BVC</td>
                            <td><?=round(array_sum($jarak_pusat_cluster), 4)?></td>
                        </tr>
                    </table>
                </div>
                <div class="panel-body">
                <?php
                if($iterasi==$maksimum && $rasio > $rasio_sebelum){
                    $stop = true;
                    $ket = "Karena iterasi ($iterasi) sudah mencapai maksimum iterasi, maka iterasi dihentikan.";
                } else if($rasio <= $rasio_sebelum){
                    $stop = true; 
                    $ket = "Karena rasio ($rasio) Tidak > rasio sebelumnya ($rasio_sebelum), maka iterasi dihentikan.";   
                } else {
                    $iterasi++;
                    $ket = "Karena rasio ($rasio) > rasio sebelumnya ($rasio_sebelum), maka iterasi dilanjutkan.";
                    $rasio_sebelum = $rasio;
                    $pusat_cluster = $avg;
                }    
                ?>
                <?=$ket?>
                </div>
            </div>
            <?php endwhile?>                
        </div>                                       
    </div>
    <div class="panel-body">
        Iterasi ke: <?=$iterasi?><br />
        Rasio : <?=$rasio?>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">    
            <thead><tr>
                <td>Kode</td>
                <td>Nama</td>
                <td>Cluster</td>
            </tr></thead>                
            <?php foreach($ALTERNATIF as $key => $val):?>
            <tr>
                <td><?=$val[kode]?></td>
                <td><?=$val[nama]?></td> 
                <td><?=$keanggotaan[$key]?></td>                        
            </tr>
            <?php endforeach?>
        </table>
    </div>
</div>
