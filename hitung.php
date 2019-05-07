<style>    
    .text-primary{font-weight: bold;}
</style>
<div class="page-header">
    <h1>Hasil Pengelompokan Siswa</h1>
</div>
<?php
    $c = $db->get_results("SELECT * FROM tb_rel_alternatif WHERE nilai < 0 ");
    if (!$ALTERNATIF || !$KRITERIA):
        echo "Tampaknya anda belum mengatur Nilai Siswa dan Kriteria. Silahkan tambahkan minimal 3 Nilai Siswa dan 2 kriteria.";
    elseif ($c):
        echo "Tampaknya anda belum mengatur nilai siswa. Silahkan atur pada menu <strong>Nilai Siswa</strong>.";
    else:
        $data = get_data();
?>
   
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Pengaturan</h3>
        </div>
        <div class="panel-body">
            <?php
            $succes = false;
            if($_POST){
                $jumlah = $_POST[jumlah];
                $maksimum =100;
                if($jumlah < 2 || $maksimum < 10){
                    print_msg('Masukkan minimal 2 clustering, dan 10 iterasi');
                } else {
                    $succes = true;
                }
            }
            ?>
            <form method="post" action="?m=hitung#hasil">
                <div class="form-group">
                    <label>Jumlah Kelas Dibentuk <span class="text-danger">*</span></label>
                    <input class="form-control aw" type="text" name="jumlah" value="<?=set_value($_POST[jumlah], 3)?>" />
                </div>
                <div class="form-group">
                    <button class="btn btn-primary"><span class="glyphicon glyphicon-refresh"></span>Proses</button>
                </div>
            </form>
        </div>
    </div>        
    <?php     
    if($succes)
        include 'hasil.php';
    ?>            
<?php endif?>

