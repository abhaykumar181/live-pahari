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
            
            <li class="nav-item mb-1 {{ (getControllerName() == 'AddonsController') ? 'active' : '' }}"><a class="nav-link px-3" href="{{ route('admin.addons.index') }}"> <i class="fa-solid fa-puzzle-piece"></i> Add-ons</a></li>
           
            <li class="nav-item mb-1 {{ (getControllerName() == 'PropertiesController') ? 'active' : '' }}"><a class="nav-link px-3" href="{{ route('admin.properties.index') }}"> <i class="fa-solid fa-house"></i> Properties</a></li>
            
            <li class="nav-item mb-1 {{ (getControllerName() == 'PackageController') ? 'active' : '' }}"><a class="nav-link px-3" href="{{ route('admin.packages.index') }}"> <i class="fa-solid fa-box"></i> Packages</a></li>
            
            <li class="nav-item mb-1 {{ (getControllerName() == 'PageController') ? 'active' : '' }}"><a class="nav-link px-3" href="{{ route('admin.pages.index') }}"> <i class="fa-solid fa-file"></i> Pages</a></li>
            
            <li class="nav-item mb-1 {{ (getControllerName() == 'BookingsController') ? 'active' : '' }}"><a class="nav-link px-3" href="{{ route('admin.bookings.index') }}"> <i class="fa-solid fa-store"></i> Bookings</a></li>
            
            <li class="nav-item mb-1 {{ (getControllerName() == 'SettingsController') ? 'active' : '' }}"><a class="nav-link px-3" href="{{ route('admin.settings.settings') }}"> <i class="fa-solid fa-gear"></i> Settings</a></li>
            
        </ul>
    </div>
</div>