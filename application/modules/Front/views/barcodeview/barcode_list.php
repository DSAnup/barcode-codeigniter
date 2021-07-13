<div class="container" style="margin-top:11px;">
	<div class="row">
		<div class="box">
			<div class="box">
				<!-- /.box-header -->
				<div class="box-body">
					<div class="col-md-12" style="color: #79a0e0">
						<h3>Barcode List</h3>
					</div>
					<table id="myTable" class="table table-bordered table-striped" border="1">
						<thead style="background-color: #79a0e0">
							<tr>
								<th width="5%">SL</th>
								<th width="15%">Generate. Date</th>
								<th width="15%">Order Number</th>
								<th width="15%">Barcode</th>
								<th width="25%">Barcode Label</th>
							</tr>
						</thead>
						<tbody id="itembody">
							<?php $i=0; foreach ($adm as $s) {?>
								<tr>
									<td><?= ++$i;?></td>
									<td><?= date('d-M-y', strtotime($s->manu_date));?></td>
									<td><?= $s->ordernumber;?></td>
									<td><?= $s->barcode;?></td>
									<td><a href="<?= base_url().'uploads/'.$s->imgname?>" target="_blank"><img src="<?= base_url().'uploads/'.$s->imgname?>"></a></td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>				

