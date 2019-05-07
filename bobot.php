<?php
    $row = $db->get_row("SELECT * FROM tb_nilai WHERE id_nilai='$_GET[ID]'"); 
?>
<div class="page-header">
    <h1>Ubah Nilai Bobot </h1>
</div>
<div class="row">
    <div class="col-sm-6">
        <?php if($_POST) include'aksi.php'?>
        <form method="post" action="?m=bobot_ubah&ID=<?=$row->id_siswa?>">
            <div class="form-group">
                <label>Bahasa Indonesia <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="b_indo" value="<?=$row->b_indo?>"/>
            </div>
            <div class="form-group">
                <label>Matematika <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="mtk" value="<?=$row->mtk?>"/>
            </div>
			<div class="form-group">
                <label>IPA <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="ipa" value="<?=$row->ipa?>"/>
            </div>
			<div class="form-group">
                <label>Prestasi <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="prestasi" value="<?=$row->prestasi?>"/>
            </div>
            <div class="page-header">
                <button class="btn btn-primary"><span class="glyphicon glyphicon-save"></span> Simpan</button>
                <a class="btn btn-danger" href=""><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
            </div>
        </form>
    </div>
</div>