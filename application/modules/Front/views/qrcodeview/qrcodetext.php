<div class="container" style="margin-top:11px;">
    <div class="row">
      	<div class="col-md-6">
			<!-- <?php echo base_url();
			echo $_SERVER['DOCUMENT_ROOT'];
			?> -->
			<h4>QR Code</h4>
			<form action="<?= base_url() . 'Front/qrcodeGenerator' ?>" method="post">
				<div class="form-group">
				    <label for="text">Enter Text For Qr Code Generation:</label>
				    <input type="text" class="form-control" name="qrcode_text">
			  	</div>
			  	<div class="form-group">
				   <button class="btn btn-default">Submit</button>
			  	</div>
			</form>
		</div>
	</div>
</div>				

