@extends('layout.layout')

@section('list')
class="active"
@stop

<!-- header -->
@section('header')
<h1>
    List of Emails
    <small>These are the list of all the emails available to be read in the system</small>
</h1>
@stop
<!-- /header -->
<!-- breadcrumbs -->
@section('breadcrumb')
<ol class="breadcrumb">
    <li><a href="#">Email</a></li>
    <li><a href="#">List all</a></li>
</ol>
@stop
<!-- /breadcrumbs -->
<!-- content -->
@section('content')

<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title">Emails List</h3>
    </div>
    <div class="box-body">
        @if(Session::has('success'))
        <div class="alert alert-success alert-dismissable">
            <i class="fa  fa-check-circle"></i>
            <b>Success!</b>
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
        <table id="datatables-example" class="table table-striped table-bordered" width="100%" cellspacing="0">

            <tr>
                <th width="100px">Email Name</th>
                <th width="100px">Email address</th>
                <th width="100px">Action</th>
            </tr>
            @foreach($emails as $email)
            <tr>
                <td>{{ $email->email_name }}</td>
                <td><a href="{{route('emails.edit', $email->id)}}"> {{$email->email_address }}</a>
                <td>
                    <form action="{!! route('emails.destroy', $email->id) !!}" method="POST">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <a href="{{route('emails.edit', $email->id)}}" class="btn btn-info btn-xs btn-flat"><i class="fa fa-edit"> </i> Edit</a>
                        <!-- To pop up a confirm Message -->
                        <button type="submit" class="btn btn-warning btn-xs btn-flat" onclick='return confirm("Are you sure?")'><i class="fa fa-trash"></i> Delete</button>
                    </form>

                </td>
            </tr>

            @endforeach
            @if(!isset($email))
            <tr>
                <td>Nothing to diaplay</td>
                <td></td>
                <td></td>
            </tr>  
            @endif
        </table>
    </div>
    <div class="box-footer no-border">

    </div>
</div>              
@stop
