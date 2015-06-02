@extends('app')

@section('content')
<div class="container">

</div>
@endsection
@section('endbody')
    <script src="/externform"></script>
    <script type="text/javascript">
        /*var validNavigation = false;

        function wireUpEvents() {
            var dont_confirm_leave = 0;
            var leave_message = 'You sure you want to leave?'

            function goodbye(e) {
                if (!validNavigation) {
                    if (dont_confirm_leave !== 1) {
                        if (!e) e = window.event;
                        //e.cancelBubble is supported by IE - this will kill the bubbling process.
                        e.cancelBubble = true;
                        e.returnValue = leave_message;
                        //e.stopPropagation works in Firefox.
                        if (e.stopPropagation) {
                            e.stopPropagation();
                            e.preventDefault();
                        }
                        //return works for Chrome and Safari
                        return leave_message;
                    }
                }
            }
            window.onbeforeunload=goodbye;
        }
        wireUpEvents();
        */
    </script>
@endsection