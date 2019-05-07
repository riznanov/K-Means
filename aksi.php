<?php
require_once 'functions.php';
/** LOGIN */ 
if ($act=='login'){
    $id_admin = esc_field($_POST[id_admin]);
    $password_admin = esc_field($_POST[password_admin]);
    
    $row = $db->get_row("SELECT * FROM tb_admin WHERE id_admin='$id_admin' AND password_admin='$password_admin'");
    if($row){
        $_SESSION[login] = $row->id_admin;
        redirect_js("index.php");
    } else{
        print_msg("Salah kombinasi username dan password.");
    }          
} elseif($act=='logout'){
    unset($_SESSION[login]);
    header("location:login.php");
} else if ($mod=='password'){
    $pass1 = $_POST[pass1];
    $pass2 = $_POST[pass2];
    $pass3 = $_POST[pass3];
    
    $row = $db->get_row("SELECT * FROM tb_admin WHERE id_admin='$_SESSION[login]' AND password_admin='$pass1'");        
    
    if($pass1=='' || $pass2=='' || $pass3=='')
        print_msg('Field bertanda * harus diisi.');
    elseif(!$row)
        print_msg('Password lama salah.');
    elseif( $pass2 != $pass3 )
        print_msg('Password baru dan konfirmasi password baru tidak sama.');
    else{        
        $db->query("UPDATE tb_admin SET password_admin='$pass2' WHERE id_admin='$_SESSION[login]'");                    
        print_msg('Password berhasil diubah.', 'success');
    }
} 

/** ALTERNATIF */
elseif($mod=='alternatif_tambah'){
    $kode_siswa = $_POST['kode_siswa'];
    $nama_siswa = $_POST['nama_siswa'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
	$alamat = $_POST['alamat'];
	$asal_sekolah = $_POST['asal_sekolah'];
	$rata_rata = $_POST['rata_rata'];
    if($kode_siswa=='' || $nama_siswa=='')
        print_msg("Field yang bertanda * tidak boleh kosong!");
    elseif($db->get_results("SELECT * FROM tb_siswa WHERE kode_siswa='$kode_siswa'"))
        print_msg("Kode sudah ada!");
    else{
        $db->query("INSERT INTO tb_siswa (kode_siswa, nama_siswa, jenis_kelamin, alamat, asal_sekolah, rata_rata) VALUES ('$kode_siswa', '$nama_siswa', '$jenis_kelamin', '$alamat','$asal_sekolah', '$rata_rata')");
        $ID = $db->insert_id;            
        $db->query("INSERT INTO tb_rel_alternatif(id_siswa, id_kriteria, nilai) SELECT '$ID', id_kriteria, -1 FROM tb_kriteria");       
        redirect_js("index.php?m=alternatif");
    }
} else if($mod=='alternatif_ubah'){
    $kode_siswa = $_POST['kode_siswa'];
    $nama_siswa = $_POST['nama_siswa'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
	$alamat = $_POST['alamat'];
	$asal_sekolah = $_POST['asal_sekolah'];
	$rata_rata = $_POST['rata_rata'];
    
    if($kode_siswa=='' || $nama_siswa=='')
        print_msg("Field yang bertanda * tidak boleh kosong!");
    elseif($db->get_results("SELECT * FROM tb_siswa WHERE kode_siswa='$kode_siswa' AND id_siswa<>'$_GET[ID]'"))
        print_msg("Kode sudah ada!");
    else{
        $db->query("UPDATE tb_siswa SET kode_siswa='$kode_siswa', nama_siswa='$nama_siswa', jenis_kelamin='$jenis_kelamin', alamat='$alamat', asal_sekolah='$asal_sekolah', rata_rata='$rata_rata' WHERE id_siswa='$_GET[ID]'");
        redirect_js("index.php?m=alternatif");
    }
} else if ($act=='alternatif_hapus'){
    $db->query("DELETE FROM tb_siswa WHERE id_siswa='$_GET[ID]'");
    $db->query("DELETE FROM tb_rel_alternatif WHERE id_siswa='$_GET[ID]'");
    header("location:index.php?m=alternatif");
} 
/** KRITERIA */    
if($mod=='kriteria_tambah'){
    $kode_kriteria = $_POST['kode_kriteria'];
    $nama_kriteria = $_POST['nama_kriteria'];
    $nilai_min = $_POST['nilai_min'];
   
    if($kode_kriteria=='' || $nama_kriteria=='' || $nilai_min=='')
        print_msg("Field bertanda * tidak boleh kosong!");
    elseif($db->get_results("SELECT * FROM tb_kriteria WHERE kode_kriteria='$kode_kriteria'"))
        print_msg("Kode sudah ada!");
    else{
        $db->query("INSERT INTO tb_kriteria (kode_kriteria, nama_kriteria, nilai_min) 
            VALUES ('$kode_kriteria', '$nama_kriteria', $nilai_min)");
        $ID = $db->insert_id;        
        $db->query("INSERT INTO tb_rel_alternatif(id_alternatif, id_kriteria, nilai) SELECT id_alternatif, '$ID', -1  FROM tb_alternatif");           
        redirect_js("index.php?m=kriteria");
    }                    
} else if($mod=='kriteria_ubah'){
    $kode_kriteria = $_POST['kode_kriteria'];
    $nama_kriteria = $_POST['nama_kriteria'];
    $nilai_min = $_POST['nilai_min'];
	
    if($kode_kriteria=='' || $nama_kriteria=='' || $nilai_min=='')
        print_msg("Field bertanda * tidak boleh kosong!");
    elseif($db->get_results("SELECT * FROM tb_kriteria WHERE kode_kriteria='$kode_kriteria' AND id_kriteria<>'$_GET[ID]'"))
        print_msg("Kode sudah ada!");
    else{
        $db->query("UPDATE tb_kriteria SET kode_kriteria='$kode_kriteria', nama_kriteria='$nama_kriteria', nilai_min='$nilai_min' WHERE id_kriteria='$_GET[ID]'");
        redirect_js("index.php?m=kriteria");
    }    
} else if ($act=='kriteria_hapus'){
    $db->query("DELETE FROM tb_kriteria WHERE id_kriteria='$_GET[ID]'");
    $db->query("DELETE FROM tb_rel_alternatif WHERE id_kriteria='$_GET[ID]'");
    header("location:index.php?m=kriteria");
} 
/** RELASI ALTERNATIF */ 
else if ($act=='rel_alternatif_ubah'){
    foreach($_POST as $key => $value){
        $ID = str_replace('ID-', '', $key);
        $db->query("UPDATE tb_rel_alternatif SET nilai='$value' WHERE ID='$ID'");
    }
    header("location:index.php?m=rel_alternatif");
}                   
?>