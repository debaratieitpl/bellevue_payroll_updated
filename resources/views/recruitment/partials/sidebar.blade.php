<!-- Left Panel -->
@if(Session('admin')->user_type=='user')
<aside id="left-panel" class="left-panel">
  <nav class="navbar navbar-expand-sm navbar-default">
    <div id="main-menu" class="main-menu collapse navbar-collapse">

      <?php $menus = array();
foreach ($Roledata as $roleaccess) {
    $menus[] = $roleaccess->menu;

}
$menuslist = array_unique($menus);
?>



<ul class="nav navbar-nav">
    <li class="active"> <a href="{{ url('recruitmentdashboard') }}"><img src="{{ asset('images/dashboard-icon.png') }}" alt="" />Dashboard </a> </li>
    <li class="menu-item-has-children dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">  <img src="{{ asset('images/lv-allo.png') }}" alt="" /> Recruitment Management</a>
      <ul class="sub-menu children dropdown-menu">
      <li><a href="{{ url('recruitment/job-list') }}"><img src="{{ asset('images/daily-att.png') }}" alt="" />Job List</a></li>
      <li><a href="{{ url('recruitment/job-post') }}"><img src="{{ asset('images/daily-att.png') }}" alt="" />Job Posting</a></li>
      <li><a href="{{ url('recruitment/job-published') }}"><img src="{{ asset('images/daily-att.png') }}" alt="" />Job Published</a></li>
      <li><a href="{{ url('recruitment/candidate') }}"><img src="{{ asset('images/daily-att.png') }}" alt="" />Job Applied</a></li>
      <li><a href="{{ url('recruitment/short-listing') }}"><img src="{{ asset('images/daily-att.png') }}" alt="" />Short Listng</a></li>
      <li><a href="{{ url('recruitment/interview') }}"><img src="{{ asset('images/daily-att.png') }}" alt="" />Interview</a></li>
      <li><a href="{{ url('recruitment/hired') }}"><img src="{{ asset('images/daily-att.png') }}" alt="" />Hired</a></li>
      <li><a href="{{ url('recruitment/offer-letter') }}"><img src="{{ asset('images/daily-att.png') }}" alt="" />Generate Offer Letter</a></li>
      {{-- <li><a href="{{ url('attendance/view-montly-attendance-data-all') }}"><img src="{{ asset('images/daily-att.png') }}" alt="" />Search</a></li>
      <li><a href="{{ url('attendance/view-montly-attendance-data-all') }}"><img src="{{ asset('images/daily-att.png') }}" alt="" />Status Search</a></li>
      <li><a href="{{ url('attendance/view-montly-attendance-data-all') }}"><img src="{{ asset('images/daily-att.png') }}" alt="" />Rejected</a></li>
      <li><a href="{{ url('attendance/view-montly-attendance-data-all') }}"><img src="{{ asset('images/daily-att.png') }}" alt="" />Message Center</a></li> --}}
      </ul>
    </li>
    {{-- <li class="menu-item-has-children dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <img src="{{ asset('images/reports.png') }}" alt="" /> Report Module</a>
                <ul class="sub-menu children dropdown-menu">
                    <li><a href="{{ url('attendance/report-monthly-attendance') }}"><img src="{{ asset('images/payroll.png') }}" alt="" /> View Attandance</a></li>
                </ul>
    </li> --}}

  </ul>
    </div>

  </nav>
</aside>
@else
<!-- /#left-panel -->


<aside id="left-panel" class="left-panel">
  <nav class="navbar navbar-expand-sm navbar-default">
    <div id="main-menu" class="main-menu collapse navbar-collapse">



      <ul class="nav navbar-nav">
        <li class="active"> <a href="{{ url('recruitmentdashboard') }}"><img src="{{ asset('images/dashboard-icon.png') }}" alt="" />Dashboard </a> </li>
        <li class="menu-item-has-children dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">  <img src="{{ asset('images/lv-allo.png') }}" alt="" /> Recruitment Management</a>
          <ul class="sub-menu children dropdown-menu">
          <li><a href="{{ url('recruitment/job-list') }}"><img src="{{ asset('images/daily-att.png') }}" alt="" />Job List</a></li>
          <li><a href="{{ url('recruitment/job-post') }}"><img src="{{ asset('images/daily-att.png') }}" alt="" />Job Posting</a></li>
          <li><a href="{{ url('recruitment/job-published') }}"><img src="{{ asset('images/daily-att.png') }}" alt="" />Job Published</a></li>
          <li><a href="{{ url('recruitment/candidate') }}"><img src="{{ asset('images/daily-att.png') }}" alt="" />Job Applied</a></li>
          <li><a href="{{ url('recruitment/short-listing') }}"><img src="{{ asset('images/daily-att.png') }}" alt="" />Short Listng</a></li>
          <li><a href="{{ url('recruitment/interview') }}"><img src="{{ asset('images/daily-att.png') }}" alt="" />Interview</a></li>
          <li><a href="{{ url('recruitment/hired') }}"><img src="{{ asset('images/daily-att.png') }}" alt="" />Hired</a></li>
          <li><a href="{{ url('recruitment/offer-letter') }}"><img src="{{ asset('images/daily-att.png') }}" alt="" />Generate Offer Letter</a></li>
          {{-- <li><a href="{{ url('attendance/view-montly-attendance-data-all') }}"><img src="{{ asset('images/daily-att.png') }}" alt="" />Search</a></li>
          <li><a href="{{ url('attendance/view-montly-attendance-data-all') }}"><img src="{{ asset('images/daily-att.png') }}" alt="" />Status Search</a></li>
          <li><a href="{{ url('attendance/view-montly-attendance-data-all') }}"><img src="{{ asset('images/daily-att.png') }}" alt="" />Rejected</a></li>
          <li><a href="{{ url('attendance/view-montly-attendance-data-all') }}"><img src="{{ asset('images/daily-att.png') }}" alt="" />Message Center</a></li> --}}
          </ul>
        </li>
        {{-- <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <img src="{{ asset('images/reports.png') }}" alt="" /> Report Module</a>
                    <ul class="sub-menu children dropdown-menu">
                        <li><a href="{{ url('attendance/report-monthly-attendance') }}"><img src="{{ asset('images/payroll.png') }}" alt="" /> View Attandance</a></li>
                    </ul>
        </li> --}}

      </ul>
    </div>
    <!-- /.navbar-collapse -->
  </nav>
</aside>
@endif
