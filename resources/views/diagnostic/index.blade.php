@extends('layout.layout')

@section('diagnos')
class="active"
@stop

<!-- header -->
@section('header')
<h1>
    Email Diagnostic
    <small>Use the following form to test whether your Outgoing Email settings are properly established</small>
</h1>
@stop
<!-- /header -->
<!-- breadcrumbs -->
@section('breadcrumb')
<ol class="breadcrumb">
    <li><a href="#">Email</a></li>
    <li><a href="#">Diagnostic</a></li>
</ol>
@stop
<!-- /breadcrumbs -->
<!-- content -->
@section('content')
<form action="{!! route('post.diag.email') !!}" method="POST">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="box box-primary">
        <div class="box-header">
            @if(Session::has('success'))
            <div class="alert alert-success alert-dismissable">
                <i class="fa  fa-check-circle"></i>
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{Session::get('success')}}
            </div>
            @endif
            <!-- failure message -->
            @if(Session::has('fails'))
            <div class="alert alert-danger alert-dismissable">
                <i class="fa fa-ban"></i>
                <b>Fail!</b>
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{Session::get('fails')}}
            </div>
            @endif
            @if(Session::has('errors'))
            <?php //dd($errors); ?>
            <div class="alert alert-danger alert-dismissable">
                <i class="fa fa-ban"></i>
                <b>Alert!</b>
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <br/>
                @if($errors->first('from'))
                <li class="error-message-padding">{!! $errors->first('from', ':message') !!}</li>
                @endif
                @if($errors->first('to'))
                <li class="error-message-padding">{!! $errors->first('to', ':message') !!}</li>
                @endif
                @if($errors->first('subject'))
                <li class="error-message-padding">{!! $errors->first('subject', ':message') !!}</li>
                @endif
                @if($errors->first('message'))
                <li class="error-message-padding">{!! $errors->first('message', ':message') !!}</li>
                @endif
            </div>
            @endif
        </div>
        <div class="box-body">
            <div class="row form-group no-padding {!! $errors->has('from') ? 'has-error' : '' !!}">
                <div class="col-md-2">
                    <label>From <span class="text-red">*</span> :</label>
                </div>
                <div class="col-md-4">
                    {!! $errors->first('fetching_encryption', '<spam class="help-block">:message</spam>') !!}
                    <select name="from" class="form-control" id="from">
                        <option value="">Choose an email</option>
                        <optgroup>Email</optgroup>
                        @foreach($emails as $email)
                        <?php
                        if ($email->email_address == $email->email_name) {
                            $email1 = $email->email_address;
                        } else {
                            $email1 = $email->email_name . ' ( ' . $email->email_address . ' ) ';
                        }
                        ?>
                        <option value="{!! $email->id !!}"> {{ $email1 }} </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row form-group no-padding {!! $errors->has('to') ? 'has-error' : '' !!}">
                <div class="col-md-2">
                    <label>To <span class="text-red">*</span> :</label>
                </div>
                <div class="col-md-4">
                    <input type="text" name="to" class="form-control" id="to">
                </div>
            </div>
            <div class="row form-group no-padding {!! $errors->has('subject') ? 'has-error' : '' !!}">
                <div class="col-md-2">
                    <label>Subject <span class="text-red">*</span> :</label>
                </div>
                <div class="col-md-8">
                    <input type="text" name="subject" class="form-control" id="sunject">
                </div>
            </div>
            <div class="row form-group no-padding {!! $errors->has('message') ? 'has-error' : '' !!}">
                <div class="col-md-2">
                    <label>Message <span class="text-red">*</span> :</label>
                </div>
                <div class="col-md-10">
                    <textarea name="message" id="message" class="form-control" style="height:200px;"></textarea>
                </div>
            </div>
        </div>
        <div class="box-footer">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-2">
                    <input type="submit" class="btn btn-primary" value="Send Email">
                </div>            
            </div>
        </div>
    </div>
</form>
@stop