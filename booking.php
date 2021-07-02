<?php 
	include"../inc/config.php"; 
	validate_admin_not_login("login.php");
	
	
	if(!empty($_GET)){
		if($_GET['act'] == 'delete'){
			
			$q = mysql_query("delete from booking WHERE id='$_GET[id]'");
			if($q){ alert("Success"); redir("booking.php"); }
		}  
	}
	
	if(!empty($_GET['act']) && $_GET['act'] == 'edit'){
		if(!empty($_POST)){
			extract($_POST); 

			$q = mysql_query("update booking SET nama='$nama',tanggal_booking='$tanggal_booking',tanggal_event='$tanggal_event',user_id='$user_id',alamat='$alamat',telephone='$telephone' where id=$_GET[id]") or die(mysql_error());
			if($q){ alert("Success"); redir("booking.php"); }
		}
	}
	
	
	include"inc/header.php";
	
?> 
	
	<div class="container">
		<?php
			$q = mysql_query("select*from booking order by id desc");
			$j = mysql_num_rows($q);
		?>
		<h4>Daftar Event Dibooking (<?php echo ($j>0)?$j:0; ?>)</h4>
		<!--a class="btn btn-sm btn-primary" href="booking.php?act=create">Add Data</a-->
		<hr>
		<?php
			if(!empty($_GET)){ 
				if($_GET['act'] == 'edit'){
					$data = mysql_fetch_object(mysql_query("select*from booking where id='$_GET[id]'"));
				?>
					<div class="row col-md-6">
					<form action="booking.php?act=edit&&id=<?php echo $_GET['id'] ?>" method="post" enctype="multipart/form-data">
						<label>Orang Yang Mesan</label><br>
						<select name="user_id" required class="form-control"> 
						<?php
								$katpro = mysql_query("select*from user where id='$data->user_id'");
								$kpa = mysql_fetch_array($katpro);
							?>
								<option value="<?php echo $kpa['id']; ?>"><?php echo $kpa['nama'] ?></option>
							<?php
								$katpro = mysql_query("select*from user");
								while($kp = mysql_fetch_array($katpro)){
							?>
								<option value="<?php echo $kp['id']; ?>"><?php echo $kp['nama'] ?></option>
								<?php } ?>
						</select><br>
						<label>Tanggal Booking</label><br>
						<input type="text" class="form-control" name="tanggal_booking" value="<?php echo substr($data->tanggal_event,0,10); ?>" required><br>
						<label>Tanggal Digunakan</label><br>
						<input type="text" class="form-control" name="tanggal_event" value="<?php echo $data->tanggal_event; ?>" required><br>
						<label>Nama</label><br>
						<input type="text" class="form-control" name="nama" value="<?php echo $data->nama; ?>" required><br>
						<label>Telephone</label><br>
						<input type="text" class="form-control" name="telephone" value="<?php echo $data->telephone; ?>" required><br>
						<label>Alamat</label><br>
						<input type="text" class="form-control" name="alamat" value="<?php echo $data->alamat; ?>" required><br>
						 
						<input type="submit" name="form-edit" value="Simpan" class="btn btn-success">
					</form>
					</div>
					<div class="row col-md-12"><hr></div>
				<?php	
				} 
			}
		?>
		
		<table class="table table-striped table-hove"> 
			<thead> 
				<tr> 
					<th>#</th> 
					<th>Nama User</th> 
					<th>Tanggal Booking</th> 
					<th>Tanggal Event</th> 
					<th>Telephone</th> 
					<th>Status</th> 
					<th>*</th> 
				</tr> 
			</thead> 
			<tbody> 
		<?php while($data=mysql_fetch_object($q)){ ?> 
				<tr <?php if($data->read == 0 ){ echo 'style="background:#cce9f8 !important;"'; } ?> > 
					<th scope="row"><?php echo $no++; ?></th> 
					<?php
						$katpro = mysql_query("select*from user where id='$data->user_id'");
						$user = mysql_fetch_array($katpro);
					?>
					<td><?php echo $data->nama ?></td> 
					<td><?php echo substr($data->tanggal_pesan,0,10) ?></td> 
					<td><?php echo $data->tanggal_digunakan ?></td> 
					<td><?php echo $data->telephone ?></td> 
					<td><?php echo $data->status ?></td> 
					<td>
						<a class="btn btn-sm btn-warning" href="detail_booking.php?id=<?php echo $data->id ?>">Detail</a>
						<a class="btn btn-sm btn-success" href="booking.php?act=edit&&id=<?php echo $data->id ?>">Edit</a>
						<a class="btn btn-sm btn-danger" href="booking.php?act=delete&&id=<?php echo $data->id ?>">Delete</a>
					</td> 
				</tr>
		<?php } ?>
			</tbody> 
		</table> 
    </div> <!-- /container -->
	
<?php include"inc/footer.php"; ?>