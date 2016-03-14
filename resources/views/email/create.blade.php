@extends('layout.layout')

@section('create')
class="active"
@stop

<!-- header -->
@section('header')

<h1>
    Create Email
    <small>One can create an email settings</small>
</h1>

@stop
<!-- /header -->
<!-- breadcrumbs -->
@section('breadcrumb')
<ol class="breadcrumb">
    <li><a href="#">Email</a></li>
    <li><a href="#">Create</a></li>
</ol>
@stop
<!-- /breadcrumbs -->
<!-- content -->
@section('content')

<!-- open a form -->
<form id="form">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Email Information & Settings</h3>
        </div>
        <div class="box-body">
            <div id="alert" style="display:none;">
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <div id="alert-message"></div>
                </div>
            </div>
        </div>
        <div class="box-body">
            <div class="row">
                <!-- email address -->
                <div class="col-xs-4 form-group {!! $errors->has('email_address') ? 'has-error' : '' !!}" id = "email_address_error">
                    <label>Email Address</label>
                    {!! $errors->first('email_address', '<spam class="help-block">:message</spam>') !!}
                    <input type="text" name="email_address" class='form-control'  id='email_address'>
                </div>
                <!-- Email name -->
                <div class="col-xs-4 form-group {!! $errors->has('email_name') ? 'has-error' : ''!!}" id="email_name_error">
                    <label>Email Name</label>
                    {!! $errors->first('email_name', '<spam class="help-block">:message</spam>') !!}
                    <input type="text" name="email_name" class='form-control'  id='email_name'>
                </div>
                <!-- password -->
                <div class="col-xs-4 form-group {!! $errors->has('password') ? 'has-error' : ''!!}" id="password_error">
                    <label>password</label>
                    {!! $errors->first('password', '<spam class="help-block">:message</spam>') !!}
                    <input type="password" name="password" class='form-control'  id='password'>
                </div>
            </div>
        </div>

        <div class="box-header with-border">
            <h3 class="box-title">Incoming Email Information</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-xs-3 form-group {!! $errors->has('fetching_protocol') ? 'has-error' : ''!!}" id="fetching_protocol_error">
                    <label>Fetching Protocol</label>
                    {!! $errors->first('fetching_protocol', '<spam class="help-block">:message</spam>') !!}
                    <input type="text" name="fetching_protocol" class='form-control'  id='fetching_protocol'>
                </div>
                <div class="col-xs-3 form-group  {!! $errors->has('fetching_host') ? 'has-error' : ''!!}" id="fetching_host_error">
                    <label>Fetching Host</label>
                    {!! $errors->first('fetching_host', '<spam class="help-block">:message</spam>') !!}
                    <input type="text" name="fetching_host" class='form-control'  id='fetching_host'>
                </div>
                <div class="col-xs-3 form-group {!! $errors->has('fetching_port') ? 'has-error' : ''!!}" id="fetching_port_error">
                    <label>Fetching Port</label>
                    {!! $errors->first('fetching_port', '<spam class="help-block">:message</spam>') !!}
                    <input type="text" name="fetching_port" class='form-control'  id='fetching_port'>
                </div>
                <div class="col-xs-3 form-group {!! $errors->has('fetching_encryption') ? 'has-error' : ''!!}" id="fetching_encryption_error">
                    <label>Fetching Encryption</label>
                    {!! $errors->first('fetching_encryption', '<spam class="help-block">:message</spam>') !!}
                    <input type="text" name="fetching_encryption" class='form-control'  id='fetching_encryption'>
                </div>
            </div>
        </div>

        <div class="box-footer">
            <button class="btn btn-primary" type="submit"> Submit</button>
        </div>
    </div>
</form>

<div class="modal fade" id="loadingpopup" style="padding:200px;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div id="head">
                    <button type="button" class="close" id="close" data-dismiss="modal" aria-label="Close" style="display:none;"><span aria-hidden="true">×</span></button>
                    <div class="col-md-5"></div><div class="col-md-2"><img src="{{asset("lb-faveo/media/images/gifloader.gif")}}" ></div><div class="col-md-5"></div>
                    <br/>
                    <br/>
                    <br/>
                    <center><h3 style="color:#80DE02;">Testing incoming & outgoing mail server</h3></center>
                    <br/>
                    <center><h4>Please wait while testing is in progress ...</h4></center>
                    <center><h4>(Please do not use "Refresh" or "Back" button)</h4></center>
                    <br/>
                </div>
            </div>
        </div>
    </div>
</div>

<button style="display:none" data-toggle="modal" data-target="#loadingpopup" id="click"></button>

<script type="text/javascript">
    //submit form
    $('#form').on('submit', function () {
        var form_data = $(this).serialize();
        // $("#spin").addClass("fa-spin");
        var email_address = document.getElementById('email_address').value;
        var email_name = document.getElementById('email_name').value;
        var password = document.getElementById('password').value;
        var fetching_protocol = document.getElementById('fetching_protocol').value;
        var fetching_host = document.getElementById('fetching_host').value;
        var fetching_port = document.getElementById('fetching_port').value;
        var fetching_encryption = document.getElementById('fetching_encryption').value;

        var filter_number = /^([0-9])/;
        var error_list = [];
        var error = "";
        // checking for validation of email
        if (email_address) {
            var filter_email = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            if (!filter_email.test(email_address)) {
                var error = "Please provide a valid email address";
                error_list.push(error);
                $("#email_address_error").addClass("has-error");
            }
        } else if (email_address == "") {
            var error = "Email Address is a required field";
            error_list.push(error);
            $("#email_address_error").addClass("has-error");
        }
        // checking for validation of email name
        if (email_name == "") {
            var error = "Email Name is a required field";
            error_list.push(error);
            $("#email_name_error").addClass("has-error");
        }

        // checking for validation of password
        if (password == "") {
            var error = "Password is a required field";
            error_list.push(error);
            $("#password_error").addClass("has-error");
        }

        if (fetching_host == "") {
            var error = "Fetching Host is a required field";
            error_list.push(error);
            $("#fetching_host_error").addClass("has-error");
        }
        // checking for validation of fetching port
        if (fetching_port == "") {
            var error = "Fetching Port is a required field";
            error_list.push(error);
            $("#fetching_port_error").addClass("has-error");
        }
        // checking for validation of mailbox protocol
        if (fetching_encryption == "") {
            var error = "Fetching Encryption is a required field";
            error_list.push(error);
            $("#fetching_encryption_error").addClass("has-error");
        }
        // checking for validation of mailbox protocol
        if (fetching_protocol == "") {
            var error = "Fetching Protocol is a required field";
            error_list.push(error);
            $("#fetching_protocol_error").addClass("has-error");
        }

        // executing error chatch
        if (error) {
            var ssss = "";
            $.each(error_list, function (key, value) {
                ssss += "<li class='error-message-padding'>" + value + "</li>";
            });
            if (ssss) {
                var error_result = "<div class='alert alert-danger alert-dismissable'> <i class='fa fa-ban'> </i> <b> Alert!</b><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button><div id='alert-message'>" + ssss + "</div></div>";
                $('#alert').empty();
                $('#alert').html(error_result);
                $('#alert').show();
                $("#spin").removeClass("fa-spin");
                return false;
            }
        }

// Ajax communicating to backend for further Checking/Saving the details
        $.ajax({
            type: "POST",
            url: "{!! route('validating.email.settings') !!}",
            dataType: "html",
            data: form_data,
            headers: {
                'X-CSRF-Token': $('meta[name="_token"]').attr('content')
            },
            beforeSend: function () {
                $('#alert').empty();
                $("#click").trigger("click");
                // alert(email_address);

            },
            success: function (response) {
                if (response == 1) {
                    $("#close").trigger("click");
                    var error_result = "<div class='alert alert-success alert-dismissable'> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button><div id='alert-message'>Your details saved successfully</div></div>";
                    $('#alert').html(error_result);
                    $('#alert').show();
                } else {
                    $("#close").trigger("click");
                    var error_result = "<div class='alert alert-danger alert-dismissable'> <i class='fa fa-ban'> </i> <b> Alert!</b><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button><div id='alert-message'>" + response + "</div></div>";
                    $('#alert').html(error_result);
                    $('#alert').show();
                }
            },
            error: function (response) {
                $("#close").trigger("click");
                var errorsHtml = "<div class='alert alert-danger alert-dismissable'> <i class='fa fa-ban'> </i> <b> Alert!</b><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button><div id='alert-message'>Unable to process the details </div></div>";
                $('#alert').empty();
                $('#alert').html(errorsHtml);
                $('#alert').show();
                return false;
            }
        });
        return false;
    });
</script>

@stop