<!-- Header-->
<header id="header" class="header">
    <div class="top-left">
        <div class="navbar-header">
            <!-- <a class="navbar-brand" href="./"><img src="{{ asset('theme/images/bopt-logo.png') }}" alt="Logo"></a> -->
            <a class="navbar-brand" href="./"><img src="{{ asset('theme/images/bellevue-logo1.png') }}" alt="Logo"></a>
            <a class="navbar-brand hidden" href="./"><img src="{{ asset('images/logo2.png') }}" alt="Logo"></a>
           
        </div>
    </div>
    <div class="top-right">
    <a id="menuToggle" class="menutoggle"><i class="fa fa-bars"></i></a>
        <div class="hd-name">
            <!-- <h2>BOARD OF PRACTICAL TRAINING (EASTERN REGION)</h2>
                            <h4><span style="font-size: 20px;">Under Ministry of HRD, Government of India</span></h4> -->
        </div>
        <div class="header-menu">
           

            <div class="user-area dropdown float-right">
                <a style="display: block;overflow: hidden;float:left;padding: 20px 15px 0 0;" class="home" href="{{url('dashboard')}}"><img style="width:22px;" src="{{ asset('images/home.png') }}" alt="Logo"></a>

                <a title="Logout" style="display: block;overflow: hidden;float:left;padding: 25px 15px 0 0;" class="home" href="{{url('logout')}}"><img style="width:27px;" src="{{ asset('images/logout.png') }}" alt="Logo"></a>

                <!-- <div class="user-menu dropdown-menu">
                            
							<a class="nav-link" href="change-login-password.php"><i class="fa fa-bars"></i> Change Password</a></li>

                            <a class="nav-link" href="#"><i class="fa fa- user"></i>Notifications <span class="count">13</span></a>

                            <a class="nav-link" href="#"><i class="fa fa -cog"></i>Settings</a>

                            <a class="nav-link" href="{{url('mainLogout')}}"><i class="fa fa-power-off"></i>Logout</a>
                        </div> -->
            </div>

        </div>
    </div>
</header>
<!-- /#header -->