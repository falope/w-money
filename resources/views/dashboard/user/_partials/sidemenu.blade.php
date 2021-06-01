<li class="nav-item {{ Route::current()->getName() == 'dashboard' ? 'active' : '' }}">
    <a class="nav-link {{ Route::current()->getName() == 'dashboard' ? 'active' : '' }}"
        href="{{ route('dashboard') }}">
        <i class="ni ni-tv-2 text-primary"></i> Dashboard
    </a>
</li>
<li class="nav-item {{ Route::current()->getName() == 'partnership' ? 'active' : '' }}">
    <a class="nav-link {{ Route::current()->getName() == 'partnership' ? 'active' : '' }}"
        href="{{ route('partnership') }}">
        <i class="ni ni-planet text-blue"></i> New Partnership
    </a>
</li>

<li class="nav-item {{ Route::current()->getName() == 'active-investments' ? 'active' : '' }}">
    <a class="nav-link {{ Route::current()->getName() == 'active-investments' ? 'active' : '' }}"
        href="{{ route('active-investments') }}">
        <i class="ni ni-bullet-list-67 text-red"></i> Active Investments
    </a>
</li>

<li class="nav-item {{ Route::current()->getName() == 'completed-investments' ? 'active' : '' }}">
    <a class="nav-link {{ Route::current()->getName() == 'completed-investments' ? 'active' : '' }}"
        href="{{ route('completed-investments') }}">
        <i class="ni ni-bullet-list-67 text-red"></i> Completed Investments
    </a>
</li>
<li class="nav-item {{ Route::current()->getName() == 'referrals' ? 'active' : '' }}">
    <a class="nav-link {{ Route::current()->getName() == 'referrals' ? 'active' : '' }}"
        href="{{ route('referrals') }}">
        <i class="ni ni-circle-08 text-pink"></i> Referrals
    </a>
</li>

<li class="nav-item {{ Route::current()->getName() == 'profile' ? 'active' : '' }}">
    <a class="nav-link {{ Route::current()->getName() == 'profile' ? 'active' : '' }}"
        href="{{ route('profile') }}">
        <i class="ni ni-single-02 text-yellow"></i> User profile
    </a>
</li>

<li class="nav-item">
    <a class="nav-link" data-toggle="modal" data-target="#changePassword"
    href="#settings">
        <i class="ni ni-settings-gear-65 text-red"></i>Change Password
    </a>
</li>

<li class="nav-item">
    <a class="nav-link" href="{{ route('logout') }}">
        <i class="ni ni-key-25 text-info"></i> Sign out
    </a>
</li>
