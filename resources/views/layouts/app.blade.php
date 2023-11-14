<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Referral Database') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
   

</head>

<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Referral Database') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @guest
                        <li><a href="{{ route('login') }}">Login</a></li>
                        @php 
                        /*<li><a href="{{ route('register') }}">Register</a></li>*/
                        @endphp
                        @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu">
                                <li>
                                    @if (Auth::user()->hasAnyRole(["admin", "supervisor", "executive"]))
                                    <a href="{{ route('referrals') }}">
                                        Referrals
                                    </a>
                                    @endif
                                    @if (Auth::user()->hasAnyRole(["admin", "supervisor"]))
                                    <a href="{{ route('add-referral') }}">
                                        Add Referral
                                    </a>
                                    <a href="/referrals/upload">Bulk Upload Referral</a>
                                    @endif
                                    @if (Auth::user()->hasAnyRole(['admin']))
                                    <a href="/users">Manage users</a>
                                    @endif
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#filter").click(function() {
                var country = $("#country").val();
                if (country == undefined) {
                    country = $("#city").val();
                }
                var divider = window.location.href.substr(-1) == '/' ? '' : '/'
                window.location.href = window.location.origin + window.location.pathname + divider + country;
            });
        });
    </script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2({
                placeholder: 'Select a category',
                allowClear: true,
            });
        });
    </script>
    <script>
        document.addEventListener('mousemove', function(event) {
            var elementUnderCursor = document.elementFromPoint(event.clientX, event.clientY);
            
            // Check if an element is under the cursor
            if (elementUnderCursor) {
               
                window.cursorEl = elementUnderCursor;
            } else {
                
                window.cursorEl = null;
            }
        });
        function getCursor() {
            return window.cursorEl;
        }
        $(document).ready(function() {
            window.inControl = false;
            getCursor();
           

            document.querySelectorAll('.copy').forEach(span =>{
            span.ondblclick = function() {
            document.execCommand("copy");
            }
            document.body.addEventListener('keydown', function(event){
                if(event.keyCode == 17) {
                    window.inControl = true;
                }
            });
            document.body.addEventListener('keyup', function(event){
                    window.inControl = false;
            });

            span.addEventListener('click', handleKeyDown = function() {
                if(window.inControl != true) return;
                query = unescape(location.href.split('?')[1]);
                queryObject = {};
                raw = [];
                if(query !== 'undefined')
                {
                    
                    queries = query.split('&');  
                    queries.forEach(e=>{
                        all = e.split('=');
                        if(all[0].includes('filter[')) 
                        {
                            
                            queryObject[all[0].split('[')[1].split(']')[0]] = all[1];
                        }
                        else {
                            raw.push(all[0]);
                            queryObject[all[0]] = all[1];
                        }
                    });
                }
                el = getCursor();
                
                type = el.getAttribute('data-type') || el.previousElementSibling.getAttribute('data-type');
                
                    queryObject[type] = el.textContent;
                    
                    if(type == "city" && (!queryObject.country || queryObject.country === "")){
                    return toastr.error('Please select a country first');
                }
                queryString = "?";
                Object.keys(queryObject).forEach(e=>{
                    if(raw.includes(e))
                    {
                        if(queryObject[e] == 'undefined' || !queryObject[e]) return;
                        queryString+=`&${e}=${queryObject[e]}`;
                    }
                    else 
                    {
                        
                        if(queryObject[e] == 'undefined' || !queryObject[e]) return;
                        queryString+=`&filter[${e}]=${queryObject[e]}`;
                    } 
                });
                
                window.location.href = '/referrals-filtered' + queryString;
                
            });
            
            span.addEventListener("copy", function(event) {
                event.preventDefault();
                if (event.clipboardData) {
                    event.clipboardData.setData("text/plain", span.textContent);
                    copyData = event.clipboardData.getData("text");
                    toastr.success('You just copied ' + copyData,'Copied!', 1)
                }
            });
        })
        });
        let filterBtn = document.querySelector('.filter-btn');
        filterBtn.addEventListener('toggle', (event) => {
             if(filterBtn.hasAttribute('open')) {
                document.querySelector('.btn-info').textContent = "Hide filters";
            }
            else {
                document.querySelector('.btn-info').textContent = "Show filters";
             }
        })
    </script>
    
<style>
    td p {
       display: flex;
    }
    td p b {
        width: 25%;
        display: block;
        color: #ac0c3c;
        background-color: #fff7af;
        text-align: center;
        margin: auto;
    }
    tr {
        background-color: #0a90e5 !important;
        color: #ffffff !important;
        transition: 1s all cubic-bezier(0.075, 0.82, 0.165, 1);
    }
    tr td:hover {
        background-color: #006dff9c !important;
    }
    tr:hover {
        background-color: #002dbc !important;
        color: #ffffff !important;
    }
    td p span {
        color: darkgreen;
        display: block;
        border: 1px solid #c1c1c1;
        background-color: #e8e8e8;
        font-weight: 500;
        width: 70%;
        position: relative;
        left: 0px;
        text-align:center;
        float: right;
    }
    tr > :nth-child(3), tr > :nth-child(4), tr > :nth-child(5) {
        width: 150px;
        min-width: 150px;
    }
    /* td {
        width: 180px !important;;
        /* width: max-content; */
    } */
    .col-md-6 {
        width: 45%;
        max-width: 45%;
    }
    .col-md-4 {
        width: 25%;
        max-width: 25%;
    }
    .containered {
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
    }
    .containered label, .containered select {
        display: block;
        width: 100%;
    }
</style>
</body>

</html>