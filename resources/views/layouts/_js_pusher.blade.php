{{--<script>--}}


    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = {{ env("MIX_PUSHER_CONSOLE_LOG") }};

    {{--var pusher = new Pusher('{{ env("PUSHER_APP_KEY") }}', {--}}
    {{--    cluster: '{{ env('PUSHER_CLUSTER') }}',--}}
    {{--    forceTLS: true--}}
    {{--});--}}

    {{--var channel = pusher.subscribe(`message.${message}`);--}}
    {{--channel.bind('ParentMessageSent', function(data) {--}}
    {{--});--}}
{{--</script>--}}
