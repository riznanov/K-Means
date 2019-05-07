<div class="page-header">
    <h1>Input Nilai Minimal</h1>
</div>
<div class="row">
    <div class="col-sm-6">
        <?php if($_POST) include'aksi.php'?>
        <form method="post" action="?m=kriteria_tambah">
            <div class="form-group">
                <label>No <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="kode_kriteria" value="<?=$_POST[kode_kriteria]?>"/>
            </div>
            <div class="form-group">
                <label>Mata Pelajaran <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="nama_kriteria" value="<?=$_POST[nama_kriteria]?>"/>
            </div>
			<div class="form-group">
                <label>Nilai Minimal <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="nilai_min" value="<?=$_POST[nilai_min]?>"/>
            </div>
            <div class="form-group">
                <button class="btn btn-primary"><span class="glyphicon glyphicon-save"></span> Simpan</button>
                <a class="btn btn-danger" href="?m=kriteria"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
            </div>
        </form>
    </div>
</div>