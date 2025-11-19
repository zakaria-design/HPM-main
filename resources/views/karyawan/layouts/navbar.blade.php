  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown user-menu">
        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
         <img src="{{ Auth::user()->foto 
             ? asset('foto_profil/' . Auth::user()->foto) 
             : asset('avatar.jpg') }}" 
              class="user-image img-circle elevation-2" 
              alt="User Image"
              style="object-fit: cover;">
         <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <!-- User image -->
          <li class="user-header">
              <img src="{{ Auth::user()->foto 
             ? asset('foto_profil/' . Auth::user()->foto) 
             : asset('avatar.jpg') }}" 
              class="img-circle elevation-2"
              alt="User Image"
              style="width: 80px; height: 80px; object-fit: cover;">

              <p class="mt-2">
                  {{ Auth::user()->name }}
                  <div><span class="badge badge-success">{{ ucfirst(Auth::user()->role) }}</span></div>
              </p>
          </li>  
         <!-- Menu Footer-->
          <li class="user-footer">
            <!-- Profile button -->
            <a href="{{ route('profil.edit') }}" class="btn btn-primary btn-flat">
                <i class="fas fa-user-cog"></i> Profile
            </a>
              <!-- Logout <a> -->
              <a href="{{ route('logout') }}" 
                class="btn btn-danger btn-flat float-right"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i> Sign out
              </a>

              <!-- Form logout tersembunyi -->
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
              </form>
              </li>
        </ul>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->