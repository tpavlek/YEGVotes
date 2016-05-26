@extends('layout')

@section('title')
    Upgrade the Potato used to broadcast #yegcc meetings
@stop

@section('content')

    <h2 class="section-header">
        It's time to upgrade the potato used to broadcast Edmonton City Council Meetings
    </h2>

    <div class="section" style="max-width:900px; margin: 0 auto; line-height: 1.5em;">
        <p>
            Did you know that <a href="#">#yegcc</a> meetings are broadcast on a <a href="http://councilontheweb.edmonton.ca/">live stream</a> during every
            meeting?
        </p>

        <p>
            This is a fantastic feature that allows citizens to keep up with city council happenings without having to
            be unemployed, sitting in city hall during work hours every day. Unfortunately, the streaming hardware
            has not been upgraded since Edmonton incorporated as a city in <strong>1904</strong>
        </p>


    </div>
    <div class="whitecard potato-demo"">
        <h3>So the real question is which do you want to see more?</h3>
        <img src="/img/potato/potato-cam.jpg" style="vertical-align: middle;"/>
        <span>or</span>
        <img src="/img/potato/iveson-fabio.jpg" style="max-width:400px;vertical-align: middle;"/>
    </div>

    <h1>What should #yegcc use to film council meetings?</h1>

    <div class="potato-select">
        <div class="option-select @if($vote && $vote->vote == "potato") selected @endif" data-vote-choice="potato" >
            <img src="/img/potato/potato.png" />
        </div>

        <div class="option-select @if($vote && $vote->vote == "camera") selected @endif" data-vote-choice="camera">
            <img src="/img/potato/red.png" />
        </div>
    </div>

    <div class="agreement @if($agreement !== null) display @endif" >
        <span class="agreement-amount">{{ $agreement or '' }}</span> people agree with you!
    </div>
    <br/>

    <div class="whitecard" style="display: inline-block;">
        <!-- Begin MailChimp Signup Form -->
        <link href="//cdn-images.mailchimp.com/embedcode/classic-10_7.css" rel="stylesheet" type="text/css">
        <style type="text/css">
            #mc_embed_signup{background:#fff; clear:left; font:14px Helvetica,Arial,sans-serif; }
            /* Add your own MailChimp form style overrides in your site stylesheet or in this style block.
               We recommend moving this block and the preceding CSS link to the HEAD of your HTML file. */
        </style>
        <div id="mc_embed_signup">
            <form action="//tpavlek.us13.list-manage.com/subscribe/post?u=45528f4b6626291ccfb196fa7&amp;id=3eed285fc5" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
                <div id="mc_embed_signup_scroll">
                    <h2>Let council know potatoes are for eating, not filming</h2>
                    <div class="indicates-required"><span class="asterisk">*</span> indicates required</div>
                    <div class="mc-field-group">
                        <label for="mce-EMAIL">Email Address  <span class="asterisk">*</span>
                        </label>
                        <input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL">
                    </div>
                    <div class="mc-field-group">
                        <label for="mce-FNAME">First Name  <span class="asterisk">*</span>
                        </label>
                        <input type="text" value="" name="FNAME" class="required" id="mce-FNAME">
                    </div>
                    <div class="mc-field-group">
                        <label for="mce-LNAME">Last Name </label>
                        <input type="text" value="" name="LNAME" class="" id="mce-LNAME">
                    </div>
                    <div id="mce-responses" class="clear">
                        <div class="response" id="mce-error-response" style="display:none"></div>
                        <div class="response" id="mce-success-response" style="display:none"></div>
                    </div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
                    <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_45528f4b6626291ccfb196fa7_3eed285fc5" tabindex="-1" value=""></div>
                    <div class="clear"><input type="submit" value="Sign" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
                </div>
            </form>
        </div>
        <script type='text/javascript' src='//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js'></script><script type='text/javascript'>(function($) {window.fnames = new Array(); window.ftypes = new Array();fnames[0]='EMAIL';ftypes[0]='email';fnames[1]='FNAME';ftypes[1]='text';fnames[2]='LNAME';ftypes[2]='text';}(jQuery));var $mcj = jQuery.noConflict(true);</script>
        <!--End mc_embed_signup-->
    </div>
@stop

@section('scripts')
    <script>
        $('.option-select').click(function() {
            $('.option-select').removeClass('selected');
            $(this).addClass('selected');

            vote($(this).data('vote-choice'));
        });

        function vote(choice) {
            $.ajax({
                method: "POST",
                url: "{{ URL::route('potato.vote') }}",
                data: { vote: choice, _token: "{{ csrf_token() }}"},
                success: function(data) {
                    $('.agreement-amount').html(data[choice]);
                    $('.agreement').show('fast');
                },
                error: function (jqxhr) {
                    alert("An error occurred! Please email troy@tpavlek.me");
                }
            });
        }
    </script>
@stop
