@extends('layouts.common')

@section('content')
<section class="jumbotron text-center">
  <div class="container">
    <i class="page-icon fa fa-industry"></i>
    <h1 class="jumbotron-heading mb-0">Manufacturers</h1>
    <ol class="breadcrumb justify-content-center">
        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Manufacturers</li>                        
    </ol>
  </div>
</section>

<div class="content-body text-muted">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-sm-12 text-right form-group">
                <a href="#add-modal" id="addModalOpen" class="btn btn-primary" data-animation="push" data-plugin="custommodal" data-overlaySpeed="1000" data-overlayColor="#36404a"><i class="fa fa-plus"></i> Add New</a>
            </div>
            <div class="col-md-8 col-sm-12">
                <table class="table table-bordered mb-0 nowrap" id="manufacturerTable" cellspacing="0" width="100%" role="grid">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Manufacturer</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
            </div>
        </div>
    </div>
<!-- add Modal -->
<div id="add-modal" class="modal-demo">
    <button type="button" class="close" onclick="Custombox.close();">
        <span>&times;</span><span class="sr-only">Close</span>
    </button>
    <h4 class="custom-modal-title">Add New Manufacturer</h4>
    <div class="custom-modal-text">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <form id="addForm" class="form" action="javascript:;" method="POST" autocomplete="off">
                    <section>
                        <div class="row justify-content-center">
                            <div class="col-md-7 col-12 form-group">
                                <label class="control-label mandatory">Manufacturer Name</label>
                                <input type="text" class="form-control" id="manufacturer">
                            </div>
                            <div class="col-md-7 col-12 form-group">
                                <label class="control-label mandatory">Status</label>
                                <select class="form-control" id="status">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                            <div class="col-md-7 col-12 form-group text-center mb-0">
                                <button type="button" onclick="Custombox.close();" class="btn btn-light">Close</button>
                                <button type="submit" id="addBtn" class="btn btn-success">Add Manufacturer</button>
                            </div>
                        </div>
                    </section>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
function refreshTable() {//get the manufacturer data over ajax
    $('#manufacturerTable').dataTable().fnDestroy();
    $('#manufacturerTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: burl+'/getManufatureres',
        columns: [
            {data: 'index'},
            {data: 'manufacturer'},
            {data: 'status'},
            {data: 'action'}
        ],
        language: {
          emptyTable: 'No Manufacturers found. Add New',
          processing: '<i class="fa fa-circle-o-notch fa-spin"></i>'
        }


    });
}
$(document).ready(function() {
    refreshTable();
});
//delete Manufacturer
function deleteFn(id) {
   swal({
    title: 'Delete this Manufacturer?',
    text: 'This will remove the entire manufacturer details, model data associated with it.',
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#4fa7f3',
    cancelButtonColor: '#d57171',
    confirmButtonText: 'Delete'
  }).then(function () {
       $.ajax({
            url: burl+'/manufacturers/'+id,
            type: 'DELETE',
            dataType: 'JSON',
            beforeSend: function() {
               $("#dltBtn_"+id).prop('disabled', true);
               $("#dltBtn_"+id).html('<i class="fa fa-circle-o-notch fa-spin"></i>');
             },
            success: function (res) {
                if(res==1) {
                    refreshTable();
                    ajaxAlert('success','This manufacturer has been deleted successfully');
                }else if(res==2) {
                    ajaxAlert('error','The manufacturer you looking at does not exist');
                }else {
                    ajaxAlert('error','Something went wrong. Try again');
                }
            }
        });
  });
}
$("#addModalOpen").click(function(){
    $("#manufacturer").focus();
});

$("#addForm").submit(function(){
    var manufacturer = $("#manufacturer").val();
    var status = $("#status").val();
    if(!nullValidate(manufacturer,'manufacturer','Enter a manufacturer name')) {
        return false;
    }
     //value,inputField,dbColumn,table,message
    if(!fieldExist(manufacturer,'manufacturer','manufacturer','manufacturers','This Manufacturer already exist. Use different name')) {
        return false;
    }
    $.ajax({
        url: burl+'/manufacturers',
        type: 'POST',
        data: {manufacturer:manufacturer,status:status},
        dataType: 'JSON',
        beforeSend: function() {
           $("#addBtn").prop('disabled', true);
           $("#addBtn").html('<i class="fa fa-circle-o-notch fa-spin"></i> Adding');
        },
        success: function (res) {
            if(res==1) {
                refreshTable();
                ajaxAlert('success','New Manufacturer added successfully');
            }else {
                ajaxAlert('error','Something went wrong. Try again');
            }
            Custombox.close();
            $("#addBtn").prop('disabled', false);
            $("#addBtn").html('Add Manufacturer');
            $('#addForm')[0].reset();
        }
    });
});
</script>
@endsection