@extends('layout.layout')

@section('read')
class="active"
@stop

<!-- header -->
@section('header')
<h1>
    Read Mail
    <small>One can read a particular message here</small>
</h1>
@stop
<!-- /header -->
<!-- breadcrumbs -->
@section('breadcrumb')
<ol class="breadcrumb">
    <li><a href="#">Mailbox</a></li>
    <li><a href="#">Inbox</a></li>
    <li><a href="#">Read Mail</a></li>
</ol>
@stop
<!-- /breadcrumbs -->
<!-- content -->
@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Read Mail</h3>
    </div>

    <?php $thread = App\Thread::where('id', '=', $id)->first(); ?>
    <div class="box-body no-padding">
        <div class="mailbox-read-info">
            <h3>{!! $thread->title !!}</h3>
            <h5>From: {!! $thread->email !!} <span class="mailbox-read-time pull-right">{!! $thread->created_at !!}</span></h5>
        </div>
        <div class="mailbox-read-message">
            <?php
            $attachment = App\Attachment::where('thread_id', '=', $thread->id)->first();
            if ($attachment == null) {
                $body = $thread->body;
            } else {
                // dd($attachment->file);
                // print $attachment->file;
                // header("Content-type: image/jpeg");
                // echo "<img src='".base64_decode($attachment->file)."' style='width:128px;height:128px'/> ";
                $body = $thread->body;
                $attachments = App\Attachment::where('thread_id', '=', $thread->id)->orderBy('id', 'DESC')->get();
                // $i = 0;
                foreach ($attachments as $attachment) {
                    // $i++;
                    if ($attachment->type == 'jpg' || $attachment->type == 'png') {
                        $image = @imagecreatefromstring($attachment->file);
                        ob_start();
                        imagejpeg($image, null, 80);
                        $data = ob_get_contents();
                        ob_end_clean();
                        $var = '<img style="max-width:200px;max-height:200px;" src="data:image/' . $attachment->type . ';base64,' . base64_encode($data) . '" />';
                        // echo $var;
                        // echo $attachment->name;
                        // $body = explode($attachment->name, $body);
                        $body = str_replace($attachment->name, "data:image/" . $attachment->type . ";base64," . base64_encode($data), $body);

                        $string = $body;
                        $start = "<head>";
                        $end = "</head>";
                        if (strpos($string, $start) == false || strpos($string, $start) == false) {
                            
                        } else {
                            $ini = strpos($string, $start);
                            $ini += strlen($start);
                            $len = strpos($string, $end, $ini) - $ini;
                            $parsed = substr($string, $ini, $len);
                            $body2 = $parsed;
                            $body = str_replace($body2, " ", $body);
                        }
                    } else {
                        
                    }
                }
                // echo $body;
                // $body = explode($attachment->file, $body);
                // $body = $body[0];
            }
            $string = $body;
            $start = "<head>";
            $end = "</head>";
            if (strpos($string, $start) == false || strpos($string, $start) == false) {
                
            } else {
                $ini = strpos($string, $start);
                $ini += strlen($start);
                $len = strpos($string, $end, $ini) - $ini;
                $parsed = substr($string, $ini, $len);
                $body2 = $parsed;
                $body = str_replace($body2, " ", $body);
            }
            ?>
            {!! $body !!}    
        </div>
        <div class="box-footer">

            <ul class='mailbox-attachments clearfix'>
                <?php
                $attachments = App\Attachment::where('thread_id', '=', $thread->id)->get();
                foreach ($attachments as $attachment) {

                    $size = $attachment->size;
                    $units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
                    $power = $size > 0 ? floor(log($size, 1024)) : 0;
                    $value = number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];

                    if ($attachment->poster == 'ATTACHMENT') {
                        if ($attachment->type == 'jpg' || $attachment->type == 'JPG' || $attachment->type == 'jpeg' || $attachment->type == 'JPEG' || $attachment->type == 'png' || $attachment->type == 'PNG' || $attachment->type == 'gif' || $attachment->type == 'GIF') {
                            $image = @imagecreatefromstring($attachment->file);
                            ob_start();
                            imagejpeg($image, null, 80);
                            $data = ob_get_contents();
                            ob_end_clean();
                            $var = '<a href="' . URL::route('image', array('image_id' => $attachment->id)) . '" target="_blank"><img style="max-width:200px;height:133px;" src="data:image/jpg;base64,' . base64_encode($data) . '"/></a>';


                            echo '<li style="background-color:#f4f4f4;"><span class="mailbox-attachment-icon has-img">' . $var . '</span><div class="mailbox-attachment-info"><b style="word-wrap: break-word;">' . $attachment->name . '</b><br/><p>' . $value . '</p></div></li>';
                        } else {
                            $var = '<a style="max-width:200px;height:133px;color:#666;" href="' . URL::route('image', array('image_id' => $attachment->id)) . '" target="_blank"><span class="mailbox-attachment-icon" style="background-color:#fff;">' . strtoupper($attachment->type) . '</span><div class="mailbox-attachment-info"><span ><b style="word-wrap: break-word;">' . $attachment->name . '</b><br/><p>' . $value . '</p></span></div></a>';
                            echo '<li style="background-color:#f4f4f4;">' . $var . '</li>';
                        }
                    }
                }
                ?>
            </ul>
        </div>
    </div>
</div>
@stop
