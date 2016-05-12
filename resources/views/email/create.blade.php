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
                    <label>Password</label>
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
                <div class="form-group">
                    <!-- status -->
                    <div class="col-xs-2 form-group">
                        <label>Fetching Status</label>
                    </div>
                    <div class="col-xs-2 form-group">
                        <input type="checkbox" name="fetching_status" id="fetching_status"> Enable
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-xs-2 form-group {!! $errors->has('fetching_protocol') ? 'has-error' : ''!!}" id="fetching_protocol_error">
                    <label>Fetching Protocol</label>
                    {!! $errors->first('fetching_protocol', '<spam class="help-block">:message</spam>') !!}
                    <!-- <input type="text" name="fetching_protocol" class='form-control'  id='fetching_protocol'> -->
                    <select name="fetching_protocol" class='form-control'  id='fetching_protocol'>
                        <option value="imap">IMAP</option>
                        <option value="pop">POP3</option>
                    </select>
                </div>
                <div class="col-xs-2 form-group  {!! $errors->has('fetching_host') ? 'has-error' : ''!!}" id="fetching_host_error">
                    <label>Fetching Host</label>
                    {!! $errors->first('fetching_host', '<spam class="help-block">:message</spam>') !!}
                    <input type="text" name="fetching_host" class='form-control'  id='fetching_host'>
                </div>
                <div class="col-xs-2 form-group {!! $errors->has('fetching_port') ? 'has-error' : ''!!}" id="fetching_port_error">
                    <label>Fetching Port</label>
                    {!! $errors->first('fetching_port', '<spam class="help-block">:message</spam>') !!}
                    <input type="text" name="fetching_port" class='form-control'  id='fetching_port'>
                </div>
                <div class="col-xs-2 form-group {!! $errors->has('fetching_encryption') ? 'has-error' : ''!!}" id="fetching_encryption_error">
                    <label>Fetching Encryption</label>
                    {!! $errors->first('fetching_encryption', '<spam class="help-block">:message</spam>') !!}
                    <!-- <input type="text" name="fetching_encryption" class='form-control'  id='fetching_encryption'> -->
                    <select name="fetching_encryption" class='form-control'  id='fetching_encryption'>
                        <option value="">-----Select-----</option>
                        <option value="none">None</option>
                        <option value="ssl">SSL</option>
                        <option value="tls">TLS</option>
                        <option value="starttls">STARTTLS</option>
                    </select>
                </div>
                <div class="col-xs-2">
                    <label>Authentication</label>
                    <select name="imap_authentication" class="form-control" id="imap_authentication">
                        <option value="normal">Normal Password</option>
                    </select>
                </div>
                <div class="col-xs-2 form-group">                   
                    <br/>
                    <input type="checkbox" name="imap_validate" value="/novalidate-cert" id="imap_validate">&nbsp; Validate certificates from TLS/SSL server
                </div>
            </div>
        </div>
        <div class="box-header with-border">
            <h3 class="box-title">Outgoing Email Information</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <!-- status -->
                <div class="form-group">
                    <div class="col-xs-2 form-group"> 
                        <label>Sending Status</label>
                    </div> 
                    <div class="col-xs-2 form-group"> 
                        <input type="checkbox" name="sending_status" id="sending_status"> Enable
                    </div> 
                </div>
            </div>
            <div class="row">
                <!-- Encryption -->
                <div class="col-xs-2 form-group {!! $errors->has('sending_protocol') ? 'has-error' : ''!!}" id="sending_protocol_error">
                    <label>Sending Protocol</label>
                    {!! $errors->first('sending_protocol', '<spam class="help-block">:message</spam>') !!} 
                    <select name="sending_protocol" class="form-control" id="sending_protocol">
                        <option value="smtp">SMTP</option>
                        <option value="mail">PHP-MAIL</option>
                    </select>
                </div> 
                <!-- sending hoost -->
                <div class="col-xs-2 form-group {!! $errors->has('sending_host') ? 'has-error' : ''!!}" id="sending_host_error">
                    <label>Sending Host</label>
                    {!! $errors->first('sending_host', '<spam class="help-block">:message</spam>') !!} 
                    <input type="text" name="sending_host" class="form-control" id="sending_host">
                </div> 
                <!-- sending port -->
                <div class="col-xs-2 form-group {!! $errors->has('sending_port') ? 'has-error' : ''!!}" id="sending_port_error">
                    <label>Sending Port</label>
                    {!! $errors->first('sending_port', '<spam class="help-block">:message</spam>') !!}
                    <input type="text" name="sending_port" class="form-control" id="sending_port">
                </div>
                <!-- Encryption -->
                <div class="col-xs-2 form-group {!! $errors->has('sending_encryption') ? 'has-error' : ''!!}" id="sending_encryption_error">
                    <label>Sending Encryption</label>
                    {!! $errors->first('sending_encryption', '<spam class="help-block">:message</spam>') !!} 
                    <select name="sending_encryption" class="form-control" id="sending_encryption">
                        <option value="">-----Select-----</option>
                        <option value="none">None</option>
                        <option value="ssl">SSL</option>
                        <option value="tls">TLS</option>
                        <option value="starttls">STARTTLS</option>
                    </select>
                </div>
                <div class="col-xs-2">
                    <label>Authentication</label>
                    <select name="smtp_authentication" class="form-control" id="smtp_authentication">
                        <option value="normal">Normal Password</option>
                    </select>
                </div>
                <div class="col-xs-2 form-group">
                    <br/>
                    <input type="checkbox" name="smtp_validate" id="smtp_validate">&nbsp; Validate certificates from TLS/SSL server
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
<!--<button class="btn " onclick="changedef(1)" id="defalut1">default</button>
<button class="btn btn-primary" onclick="changepri(1)" id="primary1">primary</button>
<br/>
<button class="btn " onclick="changedef(2)" id="defalut2">default</button>
<button class="btn btn-primary" onclick="changepri(2)" id="primary2">primary</button>-->

<button style="display:none" data-toggle="modal" data-target="#loadingpopup" id="click"></button>

<script type="text/javascript">
//    function changedef(id) {
//        $("#defalut"+id).removeClass("btn-default");
//        $("#defalut"+id).addClass("btn-primary");
//        $("#primary"+id).removeClass("btn-primary");
//    }
//    function changepri(id) {
//        $("#primary"+id).removeClass("btn-default");
//        $("#primary"+id).addClass("btn-primary");
//        $("#defalut"+id).removeClass("btn-primary");
//    }


    //submit form
    $('#form').on('submit', function() {
        var form_data = $(this).serialize();
        $("#spin").addClass("fa-spin");
        var email_address = document.getElementById('email_address').value;
        var email_name = document.getElementById('email_name').value;
        var password = document.getElementById('password').value;
        var fetching_status = $('input#fetching_status[type="checkbox"]:checked', this).val();
        var fetching_protocol = document.getElementById('fetching_protocol').value;
        var fetching_host = document.getElementById('fetching_host').value;
        var fetching_port = document.getElementById('fetching_port').value;
        var fetching_encryption = document.getElementById('fetching_encryption').value;
        var fetching_authentication = document.getElementById('imap_authentication').value;
        var sending_status = $('input#sending_status[type="checkbox"]:checked', this).val();
        var sending_protocol = document.getElementById('sending_protocol').value;
        var sending_host = document.getElementById('sending_host').value;
        var sending_port = document.getElementById('sending_port').value;
        var sending_encryption = document.getElementById('sending_encryption').value;
//        var sending_authentication = document.getElementById('smtp_authentication').value;
//        var fetching_validate = $('input#validate[type="checkbox"]:checked', this).val();

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
        // checking for validation of fetching host
        if (fetching_status == 'on') {
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

        } else {
            // checking for validation of fetching port
            if (fetching_port) {
                if (!filter_number.test(fetching_port)) {
                    var error = "The Fetching Port Number must be an integer";
                    error_list.push(error);
                    $("#fetching_port_error").addClass("has-error");
                }
            }
        }
        // checking for validation of sending status
        if (sending_status == 'on') {
            if (sending_protocol == 'smtp') {
                // checking for validation of sending host
                if (sending_host == "") {
                    var error = "Sending Host is a required field";
                    error_list.push(error);
                    $("#sending_host_error").addClass("has-error");
                }
                // checking for validation of sending port
                if (sending_port == "") {
                    var error = "Sending Port is a required field";
                    error_list.push(error);
                    $("#sending_port_error").addClass("has-error");
                }
                // checking for validation of sending encryption
                if (sending_encryption == "") {
                    var error = "Sending Encryption is a required field";
                    error_list.push(error);
                    $("#sending_encryption_error").addClass("has-error");
                }
                // checking for validation of sending protocol
                if (sending_protocol == "") {
                    var error = "Transfer Protocol is a required field";
                    error_list.push(error);
                    $("#sending_protocol_error").addClass("has-error");
                }
            }
        } else {
            // checking for validation of fetching port
            if (sending_port) {
                if (!filter_number.test(sending_port)) {
                    var error = "The Sending Port Number must be an integer";
                    error_list.push(error);
                    $("#sending_port_error").addClass("has-error");
                }
            }
        }
        // executing error chatch
        if (error) {
            var ssss = "";
            $.each(error_list, function(key, value) {
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
            beforeSend: function() {
                $('#alert').empty();
                $("#click").trigger("click");
            },
            success: function(response) {
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
            error: function(response) {
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