<div class="container" style="margin-top:11px;">
    <div class="row">
    	<div class="booth">
    		<video id="video" width="400" height="300" autoplay></video>
    		<canvas id="canvas" width="400" height="300"></canvas>
    	</div>
    </div>
</div>				
<style type="text/css">
	.booth{
		width: 400px;
		background: #ccc;
		border:1px solid lightgrey;
	}
</style>
<script type="text/javascript">
	(function(){
		var video = document.getElementById('video'),
			vendorUrl = window.URL || window.webkitURL

		navigator.getMedia = navigator.getUserMedia ||
							 navigator.webkitGetUserMedia ||
							 navigator.mozGetUserMedia ||
							 navigator.msGetUserMedia;

		navigator.getMedia({
			video: true,
			audio: false
		}, function(stream){
			console.log(stream)
		}, function(error){
		})
	})();
</script>
