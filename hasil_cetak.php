<h3>Hasil Clustering Pengelompokkan Siswa Baru SMP N 2 Magelang</h3>
<div class="table-responsive">
    <table class="table table-bordered table-hover table-striped">
        <thead><tr>
            <th>No</th>
            <th>Kode</th>
            <th>Nama Siswa</th>
			<th>Jenis Kelamin</th>
            <th>Centroid</th>
        </tr></thead>
        <?php
        $q = esc_field($_GET['q']);
        $rows = $db->get_results("SELECT * FROM tb_siswa WHERE nama_siswa LIKE '%$q%' ORDER BY centroid");
        $no=0;
        
        foreach($rows as $row):?>
        <tr>
            <td><?=++$no ?></td>
            <td><?=$row->kode_siswa?></td>
            <td><?=$row->nama_siswa?></td>
			<td><?=$row->jenis_kelamin?></td>
            <td><?=$row->centroid?></td>
        </tr>
    <?php endforeach; ?>
    </table>
</div>