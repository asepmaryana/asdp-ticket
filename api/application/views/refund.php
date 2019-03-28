				<div class="col-sm-12 margin-bottom-20">
					<div class="text-center">
						<img src="../assets/images/header.png" width="100%" border="0"/>
					</div>
				</div>
				<div class="col-sm-12 margin-bottom-20">
					<div class="text-center">
						<h5>
							<strong>DAFTAR TIKET REFUND</strong>
						</h5>
					</div>
				</div>
				<br/>
				<table style="width: 100%;">
					<tr>
						<td style="width: 20%; padding: 5px;"><strong>TANGGAL</strong></td>
						<td style="width: 80%; padding: 5px;">: <?php echo $tanggal; ?></td>
					</tr>
					<tr>
						<td style="width: 20%; padding: 5px;"><strong>STATUS</strong></td>
						<td style="width: 80%; padding: 5px;">: <?php echo $status; ?></td>
					</tr>
				</table>				
				<?php if(count($rows) == 0): ?>
				<p>Data tiket refund tidak ditemukan.</p>
				<?php else: ?>
				<br/>
				<table style="width: 100%; border: 1px solid;">
					<tr>
						<th style="width: 5%; padding: 5px; background-color: #cccccc; text-align: center; border: 1px solid; padding: 5px;">NO</th>
						<th style="width: 10%; padding: 5px; background-color: #cccccc; text-align: center; border: 1px solid; padding: 5px;">KODE BOOKING</th>
						<th style="width: 15%; padding: 5px; background-color: #cccccc; text-align: center; border: 1px solid; padding: 5px;">RUTE</th>
						<th style="width: 10%; padding: 5px; background-color: #cccccc; text-align: center; border: 1px solid; padding: 5px;">TGL BERANGKAT</th>
						<th style="width: 15%; padding: 5px; background-color: #cccccc; text-align: center; border: 1px solid; padding: 5px;">NAMA</th>
						<th style="width: 10%; padding: 5px; background-color: #cccccc; text-align: center; border: 1px solid; padding: 5px;">KELAMIN</th>
						<th style="width: 25%; padding: 5px; background-color: #cccccc; text-align: center; border: 1px solid; padding: 5px;">ALAMAT</th>
						<th style="width: 10%; padding: 5px; background-color: #cccccc; text-align: center; border: 1px solid; padding: 5px;">STATUS</th>
					</tr>
					<?php $no=1; foreach ($rows as $row): ?>
					<tr>
						<td style="text-align: center; border: 1px solid; padding: 5px;"><?php echo $no; ?></td>
						<td style="text-align: center; border: 1px solid; padding: 5px;"><?php echo $row->kode_booking; ?></td>
						<td style="border: 1px solid; padding: 5px;"><?php echo $row->asal.' - '.$row->tujuan; ?></td>
						<td style="text-align: center; border: 1px solid; padding: 5px;"><?php echo $row->tgl_berangkat; ?></td>
						<td style="border: 1px solid; padding: 5px;"><?php echo $row->nama; ?></td>
						<td style="text-align: center; border: 1px solid; padding: 5px;"><?php echo $row->jenis_kelamin; ?></td>
						<td style="border: 1px solid; padding: 5px;"><?php echo $row->alamat; ?></td>
						<td style="text-align: center; border: 1px solid; padding: 5px;"><?php echo $row->status_refund; ?></td>
					</tr>
					<?php $no++; endforeach; ?>
				</table>
				<?php endif; ?>