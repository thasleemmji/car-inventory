@extends('layouts.common')

@section('content')
<section class="jumbotron text-center">
  <div class="container">
    <i class="page-icon fa fa-search"></i>
    <h1 class="jumbotron-heading mb-0">Inventory</h1>
    <ol class="breadcrumb justify-content-center">
        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Inventory</li>                        
    </ol>
  </div>
</section>

<div class="content-body text-muted">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-sm-12">
                <table class="table table-bordered mb-0 nowrap datatable table-hover" cellspacing="0" width="100%" role="grid">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Manufacturer</th>
                        <th>Model</th>
                        <th class="text-center">Count</th>
                    </tr>
                </thead>
                <tbody>
                	@if($manufactures!=FALSE)
                	<?php $i=1; ?>
                		@foreach($manufactures as $man)
	                		@foreach($man->models as $model)
	                			@if(count($model->cars)>0)
		                		<tr class="modelRow" data-modal="{{$model->id}}">
		                		 	<td>{{$i++}}</td>
		                		 	<td class="manufacturerName">{{strtoupper($man->manufacturer)}}</td>
		                		 	<td class="modelName">{{ucwords($model->model)}}</td>
		                		 	<td align="center">{{count($model->cars)}}</td>
		                		</tr>
		                		@endif
	                		@endforeach
                		@endforeach
                	@else
	                	<tr>
	                		<td colspan="4" align="center">No manufactures found.</td>
	                	</tr>
                	@endif
                </tbody>
            </table>
            </div>
        </div>
    </div>
  <style type="text/css">
  	.custombox-modal-container {min-width: 80%!important;}
  	.swal2-container {z-index: 99999;}
  </style>
<!-- list Modal -->
<a href="#list-modal" id="listModalOpenBtn" class="d-none" data-animation="push" data-plugin="custommodal" data-overlaySpeed="1000" data-overlayColor="#36404a"></a>
<div id="list-modal" class="modal-demo">
    <button type="button" class="close" onclick="Custombox.close();">
        <span>&times;</span><span class="sr-only">Close</span>
    </button>
    <h4 class="custom-modal-title" id="modalTitle"></h4>
    <div class="custom-modal-text">
    	<div class="row justify-content-center">
    		<div class="col-md-12 table-responsive">
    			<table class="table table-striped table-bordered">
    				<thead>
    					<th>#</th>
    					<th>Image</th>
    					<th>Reg. No</th>
    					<th>Color</th>
    					<th>Manufacture Year</th>
    					<th>Notes</th>
    					<th>Sold</th>
    				</thead>
    				<tbody id="tblBody">
    					
    				</tbody>
    			</table>
    		</div>
    	</div>
    </div>
</div>
<script type="text/javascript">
$(".modelRow").click(function(){
	var modelID = $(this).attr("data-modal");
	var manufacturer = $(this).find('.manufacturerName').text();
	var modelName = $(this).find('.modelName').text();

  	$.ajax({
	    url: burl+'/models/'+modelID,
	    type: 'GET',
	    dataType: 'JSON',
	    success: function (res) {
	    	$('#modalTitle').text(manufacturer + ' ' + modelName);
	    	$('#tblBody').html(res);
	    	//now open the modal
	        $('#listModalOpenBtn').trigger('click');
	    }
	});
});

function updateRowNo() {
  var i = 0;
   $('#tblBody tr').each(function(){
      $(this).find('.rowNo').text(++i);
   });
}
$(document).on('click','.sellCar',function(e) {
	var car = $(this).attr("data-car");
	var rowCount = $('#tblBody tr').length;
	swal({
	    title: 'Mark as Sold?',
	    text: 'This will change the sold status of this car and hence it wont be in the list anymore.',
	    type: 'warning',
	    showCancelButton: true,
	    confirmButtonColor: '#4fa7f3',
	    cancelButtonColor: '#d57171',
	    confirmButtonText: 'Confirm'
	}).then(function () {
		$.ajax({
	        url: burl+'/updateSold',
	        type: 'POST',
	        data: {car:car},
	        dataType: 'JSON',
	        beforeSend: function() {
	           $("#sellBtn_"+car).prop('disabled', true);
	           $("#sellBtn_"+car).html('<i class="fa fa-circle-o-notch fa-spin"></i>');
	        },
	        success: function (res) {
	        	if(res==1) {
	        		$("#row_"+car).remove();
		        	updateRowNo();
					if(rowCount<=1) {
						var tr = '<tr><td colspan="7" align="center">No Cars found.</td></tr>';
						$('#tblBody').html(tr);
					}
					ajaxAlert('success','Sold status for this car has been updated successfully');
					setTimeout(function(){ 
			           window.location.href = "{{ url('inventory') }}";
			        }, 2000);
	        	}else {
	        		$("#sellBtn_"+car).prop('disabled', false);
	           		$("#sellBtn_"+car).html('Sold');
	        		ajaxAlert('error','Something went wrong. Try again');
	        	}
	        }
	    });
	});
});

</script>
@endsection