<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        $id = isset($_POST['id']) ? $_POST['id'] : NULL;
        $nama = isset($_POST['nama']) ? $_POST['nama'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $notelp = isset($_POST['notelp']) ? $_POST['notelp'] : '';
        $pekerjaan = isset($_POST['pekerjaan']) ? $_POST['pekerjaan'] : '';
        $Alamat = isset($_POST['Alamat']) ? $_POST['Alamat'] : '';

        $stmt = $pdo->prepare('UPDATE kontak SET id = ?, nama = ?, email = ?, notelp = ?, pekerjaan = ?, Alamat = ? WHERE id = ?');
        $stmt->execute([$id, $nama, $email, $notelp, $pekerjaan, $Alamat, $_GET['id']]);
        $msg = 'Updated Successfully!';
    }

    $stmt = $pdo->prepare('SELECT * FROM kontak WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contact) {
        exit('Contact doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>



<?=template_header('Read')?>

<div class="content update">
	<h2>Update Contact #<?=$contact['id']?></h2>
    <form action="update.php?id=<?=$contact['id']?>" method="post">
        <label for="id">ID</label>
        <label for="nama">Nama</label>
        <input type="text" name="id" value="<?=$contact['id']?>" id="id">
        <input type="text" name="nama" value="<?=$contact['nama']?>" id="nama">
        <label for="email">Email</label>
        <label for="notelp">No. Telp</label>
        <input type="text" name="email" value="<?=$contact['email']?>" id="email">
        <input type="text" name="notelp" value="<?=$contact['notelp']?>" id="notelp">
        <label for="pekerjaan">Pekerjaan</label>
        <input type="text" name="pekerjaan" value="<?=$contact['pekerjaan']?>" id="pekerjaan">
        <label for="Alamat">Alamat</label>
        <input type="text" name="alamat" value="<?=$contact['Alamat']?>" id="Alamat">
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>