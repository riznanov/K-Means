<?php
    $row = $db->get_row("SELECT * FROM tb_siswa WHERE id_siswa='$_GET[ID]'"); 
?>
<div class="page-header">
    <h1>Ubah Data Siswa</h1>
</div>
<div class="row">
    <div class="col-sm-6">
        <?php if($_POST) include'aksi.php'?>
        <form method="post" action="?m=alternatif_ubah&ID=<?=$row->id_siswa?>">
            <div class="form-group">
                <label>ID Siswa <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="kode_siswa" value="<?=$row->kode_siswa?>"/>
            </div>
            <div class="form-group">
                <label>Nama Siswa <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="nama_siswa" value="<?=$row->nama_siswa?>"/>
            </div>
            <div class="form-group">
                <label>Jenis Kelamin</label>
                <textarea class="form-control" name="jenis_kelamin"><?=$row->jenis_kelamin?></textarea>
            </div>
			<div class="form-group">
                <label>Alamat <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="alamat" value="<?=$row->alamat?>"/>
            </div>
			<div class="form-group">
                <label>Asal Sekolah <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="asal_sekolah" value="<?=$row->asal_sekolah?>"/>
            </div>
			<div class="form-group">
                <label>Rata-Rata Nilai <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="rata_rata" value="<?=$row->rata_rata?>"/>
            </div>
            <div class="page-header">
                <button class="btn btn-primary"><span class="glyphicon glyphicon-save"></span> Simpan</button>
                <a class="btn btn-danger" href="?m=alternatif"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
            </div>
        </form>
    </div>
</div>