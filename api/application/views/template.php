				<br/><br/><br/>
				<div class="col-sm-12 margin-bottom-20">
					<div class="text-center">
						<h5>
							<strong>REKAPITULASI DATA PENUMPANG DAN KENDARAAN</strong>
						</h5>
					</div>
				</div>
				<br/>
				<table style="width: 100%; border: 1px solid;">
					<tr>
						<td colspan="2" style="width: 100%; padding: 5px; border: 1px solid;">
							<table style="width: 100%;">
								<tr>
									<td style="width: 150px;"> TANGGAL </td>
									<td> : <?php echo $tanggal; ?></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td style="width: 50%; padding: 5px; border: 1px solid;">
							<table style="width: 100%;">
								<tr>
									<td style="width: 150px;"> NAMA KAPAL </td>
									<td> : <?php echo $kapal; ?> </td>
								</tr>
							</table>
						</td>
						<td style="width: 50%; padding: 5px; border: 1px solid;"> 
							<table style="width: 100%;">
								<tr>
									<td style="width: 150px;"> WAKTU TIBA </td>
									<td> :  </td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td style="width: 50%; padding: 5px; border: 1px solid;">
							<table style="width: 100%;">
								<tr>
									<td style="width: 150px;"> DERMAGA </td>
									<td> : <?php echo $dermaga; ?></td>
								</tr>
							</table>
						</td>
						<td style="width: 50%; padding: 5px; border: 1px solid;">
							<table style="width: 100%;">
								<tr>
									<td style="width: 150px;"> WAKTU BERANGKAT </td>
									<td> : <?php echo $jam; ?> </td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td style="width: 50%; padding: 5px; border: 1px solid;" valign="top">
							PENUMPANG <br/><br/>
							<table style="width: 100%;">
								<tr>
									<td style="width: 10px; height: 30px;"> &nbsp; </td>
									<td style="width: 140px;">1. Dewasa </td>
									<td> &nbsp; </td>
									<td style="width: 100px"> &nbsp; </td>
								</tr>
								<tr>
									<td style="width: 10px; height: 30px;"> &nbsp; </td>
									<td style="padding-left: 20px">a. Laki-Laki</td>
									<td> : </td>
									<td style="width: 100px; text-align: right; padding-right: 15px;"><?php echo number_format($pen['dewasa']['laki'],0,',','.'); ?> Orang </td>
								</tr>
								<tr>
									<td style="width: 10px; height: 30px;"> &nbsp; </td>
									<td style="padding-left: 20px">b. Perempuan</td>
									<td> : </td>
									<td style="width: 100px; text-align: right; padding-right: 15px;"><?php echo number_format($pen['dewasa']['perempuan'],0,',','.'); ?> Orang </td>
								</tr>
								<tr>
									<td style="width: 10px; height: 30px;"> &nbsp; </td>
									<td style="width: 140px;">2. Anak</td>
									<td> : </td>
									<td style="width: 100px; text-align: right; padding-right: 15px;"><?php echo number_format($pen['anak'],0,',','.'); ?> Orang </td>
								</tr>
								
								<tr>
									<td style="width: 10px; height: 30px;"> &nbsp; </td>
									<td style="width: 140px;">3. Balita</td>
									<td> : </td>
									<td style="width: 100px; text-align: right; padding-right: 15px;"><?php echo number_format($pen['balita'],0,',','.'); ?> Orang </td>
								</tr>
							</table>
						</td>
						<td style="width: 50%; padding: 5px; border: 1px solid;" valign="top">
							KENDARAAN <br/><br/>
							<table style="width: 100%;">
								<tr>
									<td style="width: 10px; height: 30px;"> &nbsp; </td>
									<td style="width: 140px;">1. Golongan I </td>
									<td> : </td>
									<td style="width: 100px; text-align: right; padding-right: 15px;"><?php echo number_format($ken['I'],0,',','.'); ?> Unit </td>
								</tr>
								<tr>
									<td style="width: 10px; height: 30px;"> &nbsp; </td>
									<td style="width: 140px;">2. Golongan II </td>
									<td> : </td>
									<td style="width: 100px; text-align: right; padding-right: 15px;"><?php echo number_format($ken['II'],0,',','.'); ?> Unit </td>
								</tr>
								<tr>
									<td style="width: 10px; height: 30px;"> &nbsp; </td>
									<td style="width: 140px;">3. Golongan III </td>
									<td> : </td>
									<td style="width: 100px; text-align: right; padding-right: 15px;"><?php echo number_format($ken['III'],0,',','.'); ?> Unit </td>
								</tr>
								<tr>
									<td style="width: 10px; height: 30px;"> &nbsp; </td>
									<td style="width: 140px;">4. Golongan IV A </td>
									<td> : </td>
									<td style="width: 100px; text-align: right; padding-right: 15px;"><?php echo number_format($ken['IVa'],0,',','.'); ?> Unit </td>
								</tr>
								<tr>
									<td style="width: 10px; height: 30px;"> &nbsp; </td>
									<td style="width: 140px; padding-left: 18px;">Golongan IV B </td>
									<td> : </td>
									<td style="width: 100px; text-align: right; padding-right: 15px;"><?php echo number_format($ken['IVb'],0,',','.'); ?> Unit </td>
								</tr>
								<tr>
									<td style="width: 10px; height: 30px;"> &nbsp; </td>
									<td style="width: 140px;">5. Golongan V A </td>
									<td> : </td>
									<td style="width: 100px; text-align: right; padding-right: 15px;"><?php echo number_format($ken['Va'],0,',','.'); ?> Unit </td>
								</tr>
								<tr>
									<td style="width: 10px; height: 30px;"> &nbsp; </td>
									<td style="width: 140px; padding-left: 18px;">Golongan V B </td>
									<td> : </td>
									<td style="width: 100px; text-align: right; padding-right: 15px;"><?php echo number_format($ken['Vb'],0,',','.'); ?> Unit </td>
								</tr>
								<tr>
									<td style="width: 10px; height: 30px;"> &nbsp; </td>
									<td style="width: 140px;">6. Golongan VI A </td>
									<td> : </td>
									<td style="width: 100px; text-align: right; padding-right: 15px;"><?php echo number_format($ken['VIa'],0,',','.'); ?> Unit </td>
								</tr>
								<tr>
									<td style="width: 10px; height: 30px;"> &nbsp; </td>
									<td style="width: 140px; padding-left: 18px;">Golongan VI B </td>
									<td> : </td>
									<td style="width: 100px; text-align: right; padding-right: 15px;"><?php echo number_format($ken['VIb'],0,',','.'); ?> Unit </td>
								</tr>
								<tr>
									<td style="width: 10px; height: 30px;"> &nbsp; </td>
									<td style="width: 140px;">7. Golongan VII </td>
									<td> : </td>
									<td style="width: 100px; text-align: right; padding-right: 15px;"><?php echo number_format($ken['VII'],0,',','.'); ?> Unit </td>
								</tr>
								<tr>
									<td style="width: 10px; height: 30px;"> &nbsp; </td>
									<td style="width: 140px;">8. Golongan VIII </td>
									<td> : </td>
									<td style="width: 100px; text-align: right; padding-right: 15px;"><?php echo number_format($ken['VIII'],0,',','.'); ?> Unit </td>
								</tr>
								<tr>
									<td style="width: 10px; height: 30px;"> &nbsp; </td>
									<td style="width: 140px;">9. Golongan IX </td>
									<td> : </td>
									<td style="width: 100px; text-align: right; padding-right: 15px;"><?php echo number_format($ken['IX'],0,',','.'); ?> Unit </td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td style="width: 50%; padding: 5px; border: 1px solid;">
							<table style="width: 100%;">
								<tr>
									<td style="width: 150px;"> JUMLAH PENUMPANG </td>
									<td> : </td>
									<td style="width: 100px; text-align: right; padding-right: 15px;"><?php echo number_format($pen['total'],0,',','.'); ?> Orang </td>
								</tr>
							</table>
						</td>
						<td style="width: 50%; padding: 5px; border: 1px solid;">
							<table style="width: 100%;">
								<tr>
									<td style="width: 150px;"> JUMLAH KENDARAAN </td>
									<td> : </td>
									<td style="width: 100px; text-align: right; padding-right: 15px;"><?php echo number_format($ken['total'],0,',','.'); ?> Unit </td>
								</tr>
							</table>
						</td>
					</tr>
					
					<tr>
						<td style="width: 50%; padding: 5px; border: 1px solid;">
							&nbsp;
						</td>
						<td style="width: 50%; padding: 20px; border: 1px solid; text-align: center;">
							Petugas Operator Kapal <br/>
							ttd <br/>
							<br/>
							<br/>
							<br/>
							<br/>
							<br/>
							. . . . . . . . . . . . . . . . . . . 
						</td>
					</tr>
				</table>