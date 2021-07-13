<div class="container" style="margin-top:11px;">
    <div class="row">
      	<div class="col-md-6">

			<h4>Barcode</h4>
			<form action="<?= base_url() . 'Front/set_barcode' ?>" method="post">
				<div class="form-group">
				    <label for="text">Enter Order Number:</label>
				    <input type="text" class="form-control" name="ordernumber" required="required">
			  	</div>
			  	<div class="form-group">
				   <button class="btn btn-default">Submit</button>
			  	</div>
			</form>
		</div>
	</div>
</div>				

