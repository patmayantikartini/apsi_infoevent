<?php 
	include"../inc/config.php"; 
	validate_admin_not_login("login.php");
	
	$aa = mysql_query("update booking SET `read`='1' where id=$_GET[id]") or die(mysql_error());
	
	include"inc/header.php";
	
?> 
	
	<div class="container">
		<?php
			$q = mysql_query("select*from booking where id='$_GET[id]'");
			$data = mysql_fetch_object($q);
			//$ongkir = $data->ongkir;
			$kota = $data->kota;
			$dataPembayaran = mysql_query("select * from pembayaran where id_booking='$data->id' and status='verified'") or die (mysql_error());
			$totalPembayaran = 0;
			while ($d = mysql_fetch_array($dataPembayaran)) {
				$totalPembayaran += $d['total'];
			}

			$q1 = mysql_query("select*from detail_booking where booking_id='$data->id'");
			$totalBayar = 0;
			while($data2=mysql_fetch_object($q1)){
				$katpro1 = mysql_query("select*from event where id='$data2->event_id'");
				$a = mysql_fetch_object($katpro1);
				$totalBayar += ($a->harga * $data2->qty);
			}
			$totalBayar += $ongkir;
		?>
		<h4 class="pull-left">Event Detail</h4> 
		<a class="btn btn-sm btn-primary pull-right" href="event.php">&laquo; Kembali</a>
		<br>
		<hr> 
		<div class="row col-md-12">
		<table class="table table-striped table-hove">
			<tr>
				<td width="200">Nama Pemesan</td> 
				<?php
					$katpro = mysql_query("select*from user where id='$data->user_id'");
							$user = mysql_fetch_array($katpro);
				?>
				<td><?php echo $user['nama'] ?></td> 
			</tr>
			<tr>
				<td>Tanggal Booking</td>  
				<td><?php echo substr($data->tanggal_booking,0,10); ?></td> 
			</tr>
			<tr>
				<td>Tanggal Event</td>  
				<td><?php echo $data->tanggal_event ?></td> 
			</tr>
			<tr>
			
				<td>Telephone</td> 
				<td><?php echo $data->telephone ?></td> 
			</tr>
				<td>Alamat</td> 
				
				<td><?php echo $data->alamat ?></td> 
			</tr> 
			<tr>
				<td>Total Bayar</td>
				<td><b><?php echo "Rp. " . number_format($totalBayar, 2, ",", "."); ?></b></td>
			</tr>
			<tr>
				<td>Dibayar</td>
				<td><?php echo "Rp. " . number_format($totalPembayaran, 2, ",", "."); ?></td>
			</tr>
			<tr>
				<td>Kekurangan</td>
				<td><?php echo "Rp. " . number_format($totalBayar - $totalPembayaran, 2, ",", "."); ?></td>
			</tr>
			<tr>
				<td>Status</td>
				<td><?php echo $data->status; ?></td>
			</tr>
		</table>
		</div>
		<div class="row col-md-12"> 
		<h4>List Pesanan</h4> 
		<hr> 
		<table class="table table-striped table-hove"> 
		<thead> 
				<tr> 
					<th>#</th> 
					<th>Nama Event</th> 
					<th>Harga</th> 
					<th>QTY</th> 
					<th>Harga *</th>   
				</tr> 
			</thead> 
			<tbody> 
		 <?php 
			$q = mysql_query("select*from detail_booking where booking_id='$_GET[id]'");
			$total = 0;
		 while($data=mysql_fetch_object($q)){ ?> 
				<tr> 
					<th scope="row"><?php echo $no++; ?></th> 
					<?php
						$katpro = mysql_query("select*from event where id='$data->event_id'");
						$p = mysql_fetch_object($katpro);
					?>
					<td><?php echo $p->nama ?></td> 
					<td><?php echo number_format($p->harga, 2, ',', '.')  ?></td>  
					<td><?php echo $data->qty ?></td>
					<?php $t = $data->qty*$p->harga; 
						$total += $t;
					?>
					<td><?php echo number_format($t, 2, ',', '.')  ?></td>  
				</tr>
			<?php } ?>
				<tr>
					<td colspan="3" class="text-center">
					<h5><b>KOTA & ONGKIR</b></h5>
					</td>
					<td class="text-bold">
					<h5><b><?php  echo $kota ? $kota : "Tidak di ketahui"; ?></b></h5>
					</td>
					<td class="text-bold">
					<h5><b><?php  echo number_format($ongkir, 2, ',', '.') ?></b></h5>
					</td>
				</tr>
				<tr>
					<td colspan="4" class="text-center">
					<h5><b>TOTAL HARGA</b></h5>
					</td>
					<td class="text-bold">
					<h5><b><?php  echo number_format($total + $ongkir, 2, ',', '.') ?></b></h5>
					</td>
				</tr>
			</tbody> 
		</table>
		 </div>
    </div> <!-- /container -->
	
<?php include"inc/footer.php"; ?>