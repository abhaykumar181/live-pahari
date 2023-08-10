<div class="sidebar-nav sidebar-dark px-0 box-shadow-none min-vh-100">
    <!-- Brand Logo -->
    <a href="javascript:;" class="brand-link px-3">
        <span class="brand-text font-weight-light"><b> {{ env('APP_NAME', 'Pahari Host')}}</b></span>
    </a>
    <div class="sidebar">
        <ul class="nav flex-column">
            <li class="nav-item mb-1 {{ (getControllerName() == 'DashboardController') ? 'active' : '' }}"><a class="nav-link px-3" href="{{ route('admin.dashboard') }}"> <i class="fa-solid fa-gauge"></i> Dashboard</a></li>
            
            <li class="nav-item mb-1 {{ (getControllerName() == 'LocationController') ? 'active' : '' }}"><a class="nav-link px-3" href="{{ route('admin.locations.index') }}"> <i class="fa-solid fa-list"></i> Locations</a></li>
            
            <li class="nav-item mb-1 {{ (getControllerName() == 'TestimonialController') ? 'active' : '' }}"><a class="nav-link px-3" href="{{ route('admin.testimonials.index') }}"> <i class="fa-solid fa-comment-dots"></i> Testimonials</a></li>
            
            <li class="nav-item mb-1 {{ (getControllerName() == 'AddonsController') ? 'active' : '' }}"><a class="nav-link px-3" href="{{ route('admin.addons.index') }}"> <i class="fa-solid fa-puzzle-piece"></i> Addons</a></li>
            
        
        </ul>
    </div>
</div>