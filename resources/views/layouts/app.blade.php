<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'instagram') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="http://fonts.googleapis.com/earlyaccess/droidarabickufi.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-rtl.css') }}">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet"  href="{{ asset('js/pusherNotifications.js') }}">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    @yield('style')

</head>
<body class="bg-dark">
    @include('partial.header')
    <div class="container">
        <main class="py-4">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    @include('partial.flash')
                </div>
            </div>
            @yield('content')
        </main>
        @include('partial.footer')
    </div>

    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
  <script>
    // Enable pusher logging - don't include this in production

    Pusher.logToConsole = true;

    var notificationsWrapper = $('.dropdown-notifications');
    var notificationsToggle = notificationsWrapper.find('a[data-toggle]');
    var notificationsCountElem = notificationsToggle.find('span[data-count]');
    var notificationsCount = parseInt(notificationsCountElem.data('count'));
    var notifications = notificationsWrapper.find('li.scrollable-container');


    var pusher = new Pusher('f47bb7df4271f1970dc3', {
      cluster: 'eu'
    });

    var channel = pusher.subscribe('new-notification');
    channel.bind('App\\Events\\NewNotification', function (data) {
    var existingNotifications = notifications.html();
    var newNotificationHtml = `<a href="`+data.user_id+`"><div class="media-body"><h6 class="media-heading text-right">` + data.user_name + `</h6> <p class="notification-text font-small-3 text-muted text-right">` + data.comment + `</p><small style="direction: ltr;"><p class="media-meta text-muted text-right" style="direction: ltr;">` + data.date + data.time + `</p> </small></div></div></a>`;
    notifications.html(newNotificationHtml + existingNotifications);
    notificationsCount += 1;
    notificationsCountElem.attr('data-count', notificationsCount);
    notificationsWrapper.find('.notif-count').text(notificationsCount);
    notificationsWrapper.show();
});


    // Vue application
    const app = new Vue({
      el: '#app',
      data: {
        messages: [],
      },
    });
  </script>





    <script src="{{ asset('/js/app.js') }}"></script>
    <script src="{{ asset('assets/js/alert-message.js') }}"></script>

    <!-- Import typeahead.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="//js.pusher.com/3.1/pusher.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {
            let bloodhound = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.whitespace,
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                remote: {
                    url: '{{url("search")}}?searchName=%QUERY%',//'/user/find?q=%QUERY%',
                    wildcard: '%QUERY%'
                },
            });

            $('#search').typeahead({
                hint: true,
                highlight: true,
                minLength: 1
            }, {
                name: 'users',
                source: bloodhound,
                limit: 10,
                display: function(data) {
                    return data.name  //Input value to be set when you select a suggestion.
                },
                templates: {
                    empty: [
                        '<div class="list-group search-results-dropdown"><div class="list-group-item" style="direction: rtl; text-align: right; ">لا يوجد نتائج بحث مطابقة</div></div>'
                    ],
                    header: [
                        '<div class="list-group search-results-dropdown">'
                    ],
                    suggestion: function(data) {
                        return '<div style="font-weight:normal;direction: rtl; text-align: right; width:100%" class="list-group-item"> <a href="{{url('user_info')}}/'+data.id+'"> <img src="{{asset('images/users')}}/'+data.avatar+'" style=" margin-left: 2%; " width="35px" height="35px"/>' + data.first_name+' '+data.last_name + '</a></div></div>'
                    }
                }
            });
        });
    </script>

    @yield('script')
</body>
</html>
