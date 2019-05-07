<div class="page-header">
    <h1>Data Siswa</h1>
</div>
<div class="panel panel-default">
    <div class="panel-heading">
        <form class="form-inline">
            <input type="hidden" name="m" value="alternatif" />
            <div class="form-group">
                <input class="form-control" type="text" placeholder="Pencarian. . ." name="q" value="<?=$_GET['q']?>" />
            </div>
            <div class="form-group">
                <button class="btn btn-success"><span class="glyphicon glyphicon-refresh"></span> Refresh</a>
            </div>
            <div class="form-group">
                <a class="btn btn-primary" href="?m=alternatif_tambah"><span class="glyphicon glyphicon-plus"></span> Tambah</a>
            </div>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
            <thead><tr>
                <th>No</th>
                <th>Id Siswa</th>
                <th>Nama Siswa</th>
                <th>Jenis Kelamin</th>
				<th>Alamat</th>
				<th>Asal Sekolah</th>
				<th>Rata-Rata Nilai</th>
                <th>Aksi</th>
            </tr></thead>
            <?php
            $q = esc_field($_GET['q']);
            $rows = $db->get_results("SELECT * FROM tb_siswa WHERE nama_siswa LIKE '%$q%' ORDER BY id_siswa");
            $no=0;
            
            foreach($rows as $row):?>
            <tr>
                <td><?=++$no ?></td>
                <td><?=$row->kode_siswa?></td>
                <td><?=$row->nama_siswa?></td>
                <td><?=$row->jenis_kelamin?></td>
				<td><?=$row->alamat?></td>
				<td><?=$row->asal_sekolah?></td>
				<td><?=$row->rata_rata?></td>
                <td>
                    <a class="btn btn-xs btn-warning" href="?m=alternatif_ubah&ID=<?=$row->id_siswa?>"><span class="glyphicon glyphicon-edit"></span></a>
                    <a class="btn btn-xs btn-danger" href="aksi.php?act=alternatif_hapus&ID=<?=$row->id_siswa?>" onclick="return confirm('Hapus data?')"><span class="glyphicon glyphicon-trash"></span></a>
                </td>
            </tr>
        <?php endforeach; ?>
        </table>
    </div>
</div>