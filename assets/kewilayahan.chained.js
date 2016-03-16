$(document).ready(function () {
	$('#kabkota_id').remoteChained({
		parents: '#provinsi_id',
		attribute: 'id',
		url: url
	});

	$('#kecamatan_id').remoteChained({
		parents: '#kabkota_id',
		attribute: 'id',
		url: url
	});

	$('#desa_id').remoteChained({
		parents: '#kecamatan_id',
		attribute: 'id',
		url: url
	});
})