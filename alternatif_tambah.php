<div class="page-header">
    <h1>Tambah Alternatif</h1>
</div>
<div class="row">
    <div class="col-sm-6">
        <?php if($_POST) include'aksi.php'?>
        <form method="post" action="?m=alternatif_tambah">
            <div class="form-group">
                <label>ID Siswa<span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="kode_siswa" value="<?=$_POST[kode_siswa]?>"/>
            </div>
            <div class="form-group">
                <label>Nama Siswa <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="nama_siswa" value="<?=$_POST[nama_siswa]?>"/>
            </div>
			<div class="form-group">
                <label>Jenis Kelamin</label>
                <textarea class="form-control" name="jenis_kelamin"><?=$_POST[jenis_kelamin]?></textarea>
            </div>
			<div class="form-group">
                <label>Alamat</label>
                <textarea class="form-control" name="alamat"><?=$_POST[alamat]?></textarea>
            </div>
			<div class="form-group">
                <label>Asal Sekolah</label>
                <textarea class="form-control" name="asal_sekolah"><?=$_POST[asal_sekolah]?></textarea>
            </div>
			<div class="form-group">
                <label>Rata-Rata Nilai</label>
                <textarea class="form-control" name="rata_rata"><?=$_POST[rata_rata]?></textarea>
            </div>
            <div class="form-group">
                <button class="btn btn-primary"><span class="glyphicon glyphicon-save"></span> Simpan</button>
                <a class="btn btn-danger" href="?m=alternatif"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
            </div>
        </form>
    </div>
</div>