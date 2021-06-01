 <nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
     <div class="container-fluid">
         <!-- Brand -->
         <a class="h4 mb-0 text-white text-uppercase d-none d-lg-inline-block" href="{{ route('dashboard') }}">Dashboard
             ({{ Auth::user()->name }})</a>

         <ul class="navbar-nav align-items-center d-none d-md-flex">
             <li class="nav-item dropdown">
                 <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                     aria-expanded="false">
                     <div class="media align-items-center">
                         <span class="avatar avatar-sm rounded-circle">
                             <img alt="Image placeholder" src="{{ asset('images/place.jpg') }}">
                         </span>
                         <div class="media-body ml-2 d-none d-lg-block">
                             <span class="mb-0 text-sm  font-weight-bold">{{ Auth::user()->name }}</span>
                         </div>
                     </div>
                 </a>
                 <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                     <div class=" dropdown-header noti-title">
                         <h6 class="text-overflow m-0">Welcome!</h6>
                     </div>
                     <a href="{{ route('profile') }}" class="dropdown-item">
                         <i class="ni ni-single-02"></i>
                         <span>My profile</span>
                     </a>

                     <a href="{{ route('referrals') }}" class="dropdown-item">
                         <i class="ni ni-calendar-grid-58"></i>
                         <span>Referrals</span>
                     </a>
                     <a href="#settings" class="dropdown-item" data-toggle="modal" data-target="#changePassword">
                         <i class="ni ni-settings-gear-65"></i>
                         <span>Change Password</span>
                     </a>
                     <div class="dropdown-divider"></div>
                     <a href="{{ route('logout') }}" class="dropdown-item">
                         <i class="ni ni-user-run"></i>
                         <span>Logout</span>
                     </a>
                 </div>
             </li>
         </ul>
     </div>
 </nav>

 <!-- Modal -->
<div class="modal fade" id="changePassword" tabindex="-1" aria-labelledby="changePasswordLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="changePasswordLabel"><i class="ni ni-settings-gear-65"></i> Change Password</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{ route('update-password') }}">
        <div class="form-group">
        <label class="font-weight-bold">Current Password</label>
        <input required type="password" name="oldPassword" placeholder="Enter Current Password" class="form-control" />
        </div>

        <div class="form-group">
        <label class="font-weight-bold">New Password</label>
        <input required type="password" name="newPassword" placeholder="Enter New Password" class="form-control" min="8" />
        </div>

        <div class="form-group">
        <label class="font-weight-bold">Confirm Password</label>
        <input required type="password" name="confirmPassword" placeholder="Confirm Password" class="form-control" min="8" />
        </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>

      </form>

    </div>
  </div>
</div>