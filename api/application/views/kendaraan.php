				<div class="col-sm-12 margin-bottom-20">
					<div class="text-center">
						<img src="../assets/images/header.png" width="100%" border="0"/>
					</div>
				</div>
				<div class="col-sm-12 margin-bottom-20">
					<div class="text-center">
						<h5>
							<strong>DATA KENDARAAN</strong>
						</h5>
					</div>
				</div>
				<br/>
				<table style="width: 100%;">
					<tr>
						<td style="width: 20%; padding: 5px;"><strong>KAPAL</strong></td>
						<td style="width: 80%; padding: 5px;">: <?php echo $kapal; ?></td>
					</tr>
					<tr>
						<td style="width: 20%; padding: 5px;"><strong>DERMAGA</strong></td>
						<td style="width: 80%; padding: 5px;">: <?php echo $dermaga; ?></td>
					</tr>
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
				<p>Data penumpang tidak ditemukan.</p>
				<?php else: ?>
				<br/>
				<table style="width: 100%; border: 1px solid;">
					<tr>
						<th style="width: 5%; padding: 5px; background-color: #cccccc; text-align: center; border: 1px solid; padding: 5px;">NO</th>
						<th style="width: 15%; padding: 5px; background-color: #cccccc; text-align: center; border: 1px solid; padding: 5px;">KODE BOARDING</th>
						<th style="width: 10%; padding: 5px; background-color: #cccccc; text-align: center; border: 1px solid; padding: 5px;">GOLONGAN</th>
						<th style="width: 15%; padding: 5px; background-color: #cccccc; text-align: center; border: 1px solid; padding: 5px;">NAMA</th>
						<th style="width: 10%; padding: 5px; background-color: #cccccc; text-align: center; border: 1px solid; padding: 5px;">JENIS KELAMIN</th>
						<th style="width: 10%; padding: 5px; background-color: #cccccc; text-align: center; border: 1px solid; padding: 5px;">USIA</th>
						<th style="width: 25%; padding: 5px; background-color: #cccccc; text-align: center; border: 1px solid; padding: 5px;">ALAMAT</th>
						<th style="width: 10%; padding: 5px; background-color: #cccccc; text-align: center; border: 1px solid; padding: 5px;">NO. POLISI</th>
					</tr>
					<?php $no=1; foreach ($rows as $row): ?>
					<tr>
						<td style="text-align: center; border: 1px solid; padding: 5px;"><?php echo $no; ?></td>
						<td style="text-align: center; border: 1px solid; padding: 5px;"><?php echo $row->kode_boarding; ?></td>
						<td style="text-align: center; border: 1px solid; padding: 5px;"><?php echo $row->golongan; ?></td>
						<td style="border: 1px solid; padding: 5px;"><?php echo $row->nama; ?></td>
						<td style="text-align: center; border: 1px solid; padding: 5px;"><?php echo $row->jenis_kelamin; ?></td>
						<td style="text-align: center; border: 1px solid; padding: 5px;"><?php echo $row->usia; ?></td>
						<td style="border: 1px solid; padding: 5px;"><?php echo $row->alamat; ?></td>
						<td style="text-align: center; border: 1px solid; padding: 5px;"><?php echo $row->no_polisi; ?></td>
					</tr>
					<?php $no++; endforeach; ?>
				</table>
				<?php endif; ?>