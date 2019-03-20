@extends('layouts.common')

@section('content')
<section class="jumbotron text-center">
  <div class="container">
    <i class="page-icon fa fa-car"></i>
    <h1 class="jumbotron-heading mb-0">Car Models</h1>
    <ol class="breadcrumb justify-content-center">
        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Models</li>                        
    </ol>
  </div>
</section>

<div class="content-body text-muted">
<form id="addModel" method="POST" action="javascript:;" autocomplete="off">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 col-sm-12 form-group">
                <label class="control-label mandatory d-block">Choose Manufacturer</label>
                <select class="selectpicker" data-live-search="true" data-style="btn-light" name="manufacturer" id="manufacturer">
                    <option value="">Select Manufacturer</option>
                    @if($manufacturers!=FALSE)
                     @foreach($manufacturers as $man)
                        <option value="{{$man->id}}">{{strtoupper($man->manufacturer)}}</option>
                     @endforeach
                    @endif
                </select>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 form-group">
                <label class="control-label mandatory d-block">Model Name</label>
                <input type="text" class="form-control" id="modelName">
            </div>
        </div>

        <div class="row justify-content-center mt-3 mb-3">
            <div class="col-12 text-center">
                <h4>Added Cars (<span id="addedCount">0</span>)</h4>
            </div>
        </div>

        <div class="row justify-content-center" id="carsList">
            <!-- selected car details using jquery here -->

            <div class="col-lg-3 col-md-4 col-sm-6 col-12 form-group">
                <div id="addItem">
                    <a href="#add-modal" id="addModalOpen" class="btn btn-light" data-animation="push" data-plugin="custommodal" data-overlaySpeed="1000" data-overlayColor="#36404a"><i class="fa fa-plus"></i> Add Car</a>
                </div>
            </div>
      </div>
      <div class="row justify-content-center mt-3 mb-3">
            <div class="col-12 text-center form-group">
                <button type="reset" class="btn btn-danger">Cancel</button>
                <button type="submit" id="addModelBtn" class="btn btn-success">Save Model Data</button>
            </div>
      </div>
    </div>
</form>
<!-- add Modal -->
<div id="add-modal" class="modal-demo">
    <button type="button" class="close" onclick="Custombox.close();">
        <span>&times;</span><span class="sr-only">Close</span>
    </button>
    <h4 class="custom-modal-title">Add New Manufacturer</h4>
    <div class="custom-modal-text">
        <form id="addCarForm" class="form" action="javascript:;" method="POST" autocomplete="off" enctype='multipart/form-data'>
            <input type="hidden" id="imgChange1" value="0">
            <input type="hidden" id="imgChange2" value="0">
            <input type="hidden" id="typeErr1" value="1">
            <input type="hidden" id="typeErr2" value="1">
            <section>
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-6 col-sm-12 form-group">
                        <label class="control-label mandatory">Registration No.</label>
                        <input type="text" class="form-control" id="regNo">
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12 form-group">
                        <label class="control-label mandatory">Color</label>
                        <input type="text" class="form-control" id="color">
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12 form-group">
                        <label class="control-label mandatory">Year of Manufacture</label>
                        <select class="form-control" id="mYear">
                            <option value="">Select Year</option>
                            @for($i=date('Y');$i>1900;$i--)
                              <option value="{{$i}}">{{$i}}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-6 col-sm-12 form-group">
                        <label class="control-label mandatory">Choose Image 1</label>
                        <div class="selectedImg" id="showBg1">
                            <div class="btn-group" id="imgBtnGrp1">
                                <button type="button" class="btn btn-primary btn-sm" id="imgTrigger1"><i class="fa fa-image"></i> Choose</button>
                                <button type="button" class="btn btn-danger btn-sm d-no" id="imgRemove1"><i class="fa fa-times"></i></button>
                            </div>
                            <input type="file" class="d-none" id="imgInp1" name="imgInp1" accept="image/*">
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 form-group">
                        <label class="control-label mandatory">Choose Image 2</label>
                        <div class="selectedImg" id="showBg2">
                            <div class="btn-group" id="imgBtnGrp2">
                                <button type="button" class="btn btn-primary btn-sm" id="imgTrigger2"><i class="fa fa-image"></i> Choose</button>
                                <button type="button" class="btn btn-danger btn-sm d-no" id="imgRemove2"><i class="fa fa-times"></i></button>
                            </div>
                            <input type="file" class="d-none" id="imgInp2" name="imgInp2" accept="image/*">
                        </div>
                    </div>
                    <div class="col-12 form-group">
                        <label class="control-label">Note</label>
                        <textarea class="form-control" id="note"></textarea>
                    </div>
                    <div class="col-12 text-center">
                        <button type="button" onclick="Custombox.close();" class="btn btn-light">Close</button>
                        <button type="submit" id="addCarBtn" class="btn btn-success">Add Car</button>
                    </div>
                </div>
            </section>
        </form>
    </div>
</div>
<script type="text/javascript">
$("#addModel").submit(function(){
    var manufacturer = $("#manufacturer").val();
    var modelName = $("#modelName").val();
    var count = $('.single-car').length;

    var images1 = $("input[name='images1[]']").map(function(){return $(this).val();}).get();
    var images2 = $("input[name='images2[]']").map(function(){return $(this).val();}).get();
    var regNos = $("input[name='regNos[]']").map(function(){return $(this).val();}).get();
    var colors = $("input[name='colors[]']").map(function(){return $(this).val();}).get();
    var mYears = $("input[name='mYears[]']").map(function(){return $(this).val();}).get();
    var notes = $("input[name='notes[]']").map(function(){return $(this).val();}).get();

    if(!nullValidate(manufacturer,'manufacturer','Select a Manufacturer')) {
        return false;
    }
    if(!nullValidate(modelName,'modelName','Enter a Model name')) {
        return false;
    }
    if(count==0) {
        $.toast({text: 'Add atleast one car to continue',position: 'bottom-right',icon: 'error',hideAfter: 3000,stack: 1});
        return false;
    }
    $.ajax({
      url: burl+'/models',
      type: 'POST',
      data: {manufacturer:manufacturer,modelName:modelName,images1:images1,images2:images2,regNos:regNos,colors:colors,mYears:mYears,notes:notes},
      dataType: 'JSON',
      beforeSend: function() {
         $("#addModelBtn").prop('disabled', true);
         $("#addModelBtn").html('<i class="fa fa-circle-o-notch fa-spin"></i> Saving');
      },
      success: function (res) {
          $("#addModelBtn").prop('disabled', false);
          $("#addModelBtn").html('Save Model Data');
          if(res==1) {
              $("#manufacturer").val('');
              $("#modelName").val('');
              $('.single-car').remove();
              updateCount();
              ajaxAlert('success','Model details added successfully');
          }else {
              ajaxAlert('error','Something went wrong. Try again');
          }
      }
  });
    
});
function updateCount() {
    var count = $('.single-car').length;
    $('#addedCount').text(count);
    return true;
}
$(document).on('click','.removeItem',function(e) {
    $(this).closest('.single-car').remove();
    updateCount();
});
$("#addCarForm").submit(function(){
    var regNo = $("#regNo").val();
    var color = $("#color").val();
    var mYear = $("#mYear").val();
    var note = $("#note").val();
    var modelName = $("#modelName").val();
    var manName = $("#manufacturer option:selected").text();

    var imgChange1 = $("#imgChange1").val();
    var imgChange2 = $("#imgChange2").val();
    var typeErr1 = $("#typeErr1").val();
    var typeErr2 = $("#typeErr2").val();

    if(!nullValidate(regNo,'regNo','Enter the Registration number')) {
        return false;
    }
    if(!nullValidate(color,'color','Enter a color')) {
        return false;
    }
    if(!nullValidate(mYear,'mYear','Select the year of manufacture')) {
        return false;
    }
    if(imgChange1 == 0 || imgChange2 == 0) {//left any image blank
        $.toast({text: 'Choose both images to upload',position: 'bottom-right',icon: 'error',hideAfter: 3000,stack: 1});
        return false;
    }else if(typeErr1 == 0 || typeErr2 == 0) {
        $.toast({text: 'Only .jpg, .jpeg, .png image files are supported',position: 'bottom-right',icon: 'error',hideAfter: 3000,stack: 1});
        return false;
    }
    var formData = new FormData(this);
    $.ajax({
        url: burl+'/uploadimage',
        type: 'POST',
        data:formData,
        cache:false,
        contentType: false,
        processData: false,
        dataType: 'JSON',
        beforeSend: function() {
           $("#addCarBtn").prop('disabled', true);
           $("#addCarBtn").html('<i class="fa fa-circle-o-notch fa-spin"></i> Adding');
        },
        success: function (res) {
            var html = '<div class="col-lg-3 col-md-4 col-sm-6 col-12 form-group single-car"><div class="card"><i class="fa fa-times-circle text-right removeItem"></i><div class="owl-carousel owl-theme car-image"><div class="item" style="background-image: url(\''+burl+'/uploads/'+res.image1+'\');"></div><div class="item" style="background-image: url(\''+burl+'/uploads/'+res.image2+'\');"></div></div><input type="hidden" name="images1[]" value="'+res.image1+'" /><input type="hidden" name="images2[]" value="'+res.image2+'" /><h4 class="car-title">'+manName+' <span>'+modelName+'</span></h4><dl class="row mb-0"><dd class="col-md-4 pr-0">Reg. No.:</dd><dt class="col-md-8 pl-0">'+regNo+'<input type="hidden" name="regNos[]" value="'+regNo+'" /></dt><dd class="col-md-3 pr-0">Color:</dd><dt class="col-md-3 pl-0">'+color+'<input type="hidden" name="colors[]" value="'+color+'" /></dt><dd class="col-md-3 pr-0">Year:</dd><dt class="col-md-3 pl-0">'+mYear+'<input type="hidden" name="mYears[]" value="'+mYear+'" /></dt></dl><input type="hidden" name="notes[]" value="'+note+'" /></div></div>';
            $("#carsList").prepend(html);
            updateCount();
            //reInitializing the owlCarousel after append
            $('.car-image').owlCarousel({center: true,items:1,loop:true,margin:10,nav:false,dots:false,autoplay:true,autoplayTimeout:3000});

            Custombox.close();
            $("#addCarBtn").prop('disabled', false);
            $("#addCarBtn").html('Add Manufacturer');
            $('#addCarForm')[0].reset();
            $("#imgInp1").val('');$('#imgChange1').val('0');$('#imgTrigger1').html('<i class="fa fa-image"></i> Choose');$('#imgRemove1').hide();$('#showBg1').css("background-image", "");
            $("#imgInp2").val('');$('#imgChange2').val('0');$('#imgTrigger2').html('<i class="fa fa-image"></i> Choose');$('#imgRemove2').hide();$('#showBg2').css("background-image", "");
        }
    });
});
$('#addModalOpen').click(function(){
    var manufacturer = $("#manufacturer").val();
    var model = $("#modelName").val();
    if(manufacturer =='' || model == '') {
        ajaxAlert('error','Please fill both the Manufacturer and Model name first');
        Custombox.close();
    }
});
$('#imgTrigger1').click(function(){ $('#imgInp1').trigger('click'); });
$('#imgTrigger2').click(function(){$('#imgInp2').trigger('click');});
//display selected img prior upload
$("#imgInp1").change(function () {
    if(this.files && this.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        $('#showBg1').css("background-image", "url("+e.target.result+")");  
      }
      reader.readAsDataURL(this.files[0]);
    }
    $('#imgTrigger1').html('<i class="fa fa-image"></i> Change');
    $('#imgRemove1').fadeIn();
    $('#imgChange1').val('1');
    var type = this.files[0].type;
    var validTypes = ["image/jpg", "image/jpeg", "image/png"];
    if($.inArray(type, validTypes) < 0) {//unsupported
        $('#typeErr1').val('0');
    }
    else {//image file is supported
        $('#typeErr1').val('1');
    }
});
$("#imgInp2").change(function () {
    if(this.files && this.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        $('#showBg2').css("background-image", "url("+e.target.result+")");  
      }
      reader.readAsDataURL(this.files[0]);
    }
    $('#imgTrigger2').html('<i class="fa fa-image"></i> Change');
    $('#imgRemove2').fadeIn();
    $('#imgChange2').val('1');
    var type = this.files[0].type;
    var validTypes = ["image/jpg", "image/jpeg", "image/png"];
    if($.inArray(type, validTypes) < 0) {//unsupported
        $('#typeErr2').val('0');
    }
    else {//image file is supported
        $('#typeErr2').val('1');
    }
});
$('#imgRemove1').click(function(){
    $("#imgInp1").val('');
    $('#imgChange1').val('0');
    $('#imgTrigger1').html('<i class="fa fa-image"></i> Choose');
    $('#imgRemove1').hide();
    $('#showBg1').css("background-image", "");
});
$('#imgRemove2').click(function(){
    $("#imgInp2").val('');
    $('#imgChange2').val('0');
    $('#imgTrigger2').html('<i class="fa fa-image"></i> Choose');
    $('#imgRemove2').hide();
    $('#showBg2').css("background-image", "");
});

</script>
@endsection