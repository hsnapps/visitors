<!-- Header -->
<header id="header" class="transparent-navbar">
    <!-- container -->
    <div class="container">
        <!-- navbar header -->
        <div class="navbar-header">
            <!-- Logo -->
            <div class="navbar-brand">
                <a class="logo" href="{{ route('home') }}">
                    <img class="logo-img" src="./img/site-logo.png" alt="logo">
                    <img class="logo-alt-img" src="./img/site-logo.png" alt="logo">
                </a>
            </div>
            <!-- /Logo -->

            <!-- Mobile toggle -->
            <button class="navbar-toggle">
                    <i class="fa fa-bars"></i>
                </button>
            <!-- /Mobile toggle -->
        </div>
        <!-- /navbar header -->

        <!-- Navigation -->
        <nav id="nav">
            <ul class="main-nav nav navbar-nav navbar-right">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="#">Abstract </a></li>
                <li><a href="#">Registration </a></li>
                <li> <!-- First Tier Drop Down -->
                    <label for="drop-2" class="toggle">Past events +</label>
                    <a href="#">Past events</a>
                    <input type="checkbox" id="drop-2"/>
                    <ul>
                        <li><!-- Second Tier Drop Down -->        
                            <label for="drop-3" class="toggle">Rsos 2017 +</label>
                            <a href="#">Rsos 2017</a>         
                            <input type="checkbox" id="drop-3"/>
                            <ul>
                                <li><a href="gallery-2017.html">Gallery</a></li>
                                <li><a href="flyers-2017.html">Flyers</a></li>
                                <li><a href="#">Speakers</a></li>
                            </ul>
                        </li>
                        <li> <!-- Second Tier Drop Down -->        
                            <label for="drop-4" class="toggle">Rsos 2018 +</label>
                            <a href="#">Rsos 2018</a>         
                            <input type="checkbox" id="drop-4"/>
                            <ul>
                                <li><a href="gallery-2018.html">Gallery</a></li>
                                <li class="active"><a href="flyers-2018.html">Flyers</a></li>
                                <li><a href="#">Speakers</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li>
                    <!-- First Tier Drop Down -->
                    <label for="drop-1" class="toggle">Committees +</label>
                    <a href="#">Committees</a>
                    <input type="checkbox" id="drop-1"/>
                    <ul>
                        <li><a href="#">Scientific committees</a></li>
                        <li><a href="#">Organizational committees</a></li>
                        <li><a href="#">Events and Activities Committee</a></li>
                        <li><a href="#">Media committees</a></li>
                        <li><a href="#">Training & Development Committee</a></li>
                    </ul>
                </li>
                <li><a href="#">Scientific program</a></li>
                <li><a href="#">Courses</a></li>
                <li><a href="#">Fees</a></li>
                <li><a href="contact.html">Contact</a></li>
            </ul>

            <a id="logout" class="btn btn-link btn-lg" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-3x fa-sign-out text-danger"></i></a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;"> {{ csrf_field() }} </form>
        </nav>
        <!-- /Navigation -->
    </div>
    <!-- /container -->
</header>
<!-- /Header -->