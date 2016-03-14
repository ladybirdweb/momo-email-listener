@extends('layout.layout')

@section('inbox')
class="active"
@stop

<!-- header -->
@section('header')
<h1>
    Inbox
    <small>List of all the read mails</small>
</h1>
@stop
<!-- /header -->
<!-- breadcrumbs -->
@section('breadcrumb')
<ol class="breadcrumb">
    <li><a href="#">Mailbox</a></li>
    <li><a href="#">Inbox</a></li>
</ol>
@stop
<!-- /breadcrumbs -->
<!-- content -->
@section('content')

<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title">Emails List</h3>
    </div>

    <div class="box-body no-padding">
        <?php $threads = App\Thread::paginate(5); ?>
        <div class="table-responsive mailbox-messages">

            <table class="table table-hover table-striped">

                @foreach($threads as $thread)
                <tr class="read">

                    <td class="contact">
                        <a href="{!! url('readmail/'.$thread->id) !!}">
                            {!! $thread->name !!}
                        </a>
                    </td>
                    <td class="contact">
                        <a href="{!! url('readmail/'.$thread->id) !!}">
                            {!! $thread->email !!}
                        </a>
                    </td>
                    <td class="Subject">
                        {!! $thread->title !!}
                    </td>

                </tr>

                @endforeach
            </table>
            <div class="pull-right">
                {!! $threads->setPath(url('/')); !!}
            </div>
        </div>



    </div>
</div>
<script>
    $(function () {
//Enable iCheck plugin for checkboxes
//iCheck for checkbox and radio inputs
        $('.mailbox-messages input[type="checkbox"]').iCheck({
            checkboxClass: 'icheckbox_flat-blue',
            radioClass: 'iradio_flat-blue'
        });

//Enable check and uncheck all functionality
        $(".checkbox-toggle").click(function () {
            var clicks = $(this).data('clicks');
            if (clicks) {
                //Uncheck all checkboxes
                $(".mailbox-messages input[type='checkbox']").iCheck("uncheck");
                $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
            } else {
                //Check all checkboxes
                $(".mailbox-messages input[type='checkbox']").iCheck("check");
                $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');
            }
            $(this).data("clicks", !clicks);
        });

//Handle starring for glyphicon and font awesome
        $(".mailbox-star").click(function (e) {
            e.preventDefault();
            //detect type
            var $this = $(this).find("a > i");
            var glyph = $this.hasClass("glyphicon");
            var fa = $this.hasClass("fa");

            //Switch states
            if (glyph) {
                $this.toggleClass("glyphicon-star");
                $this.toggleClass("glyphicon-star-empty");
            }

            if (fa) {
                $this.toggleClass("fa-star");
                $this.toggleClass("fa-star-o");
            }
        });
    });
</script>
@stop
