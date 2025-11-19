

 <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top shadow-sm navbar-custom d-flex justify-content-between align-items-center px-3">

            <!-- Desktop collapse button -->
            <button class="btn btn-dark d-none d-md-inline" id="toggleSidebar">
                <i class='bx bx-menu'></i>
            </button>

            <!-- Mobile sidebar toggle -->
            <button class="btn btn-dark d-md-none" id="toggleMobileSidebar">
                <i class='bx bx-menu'></i>
            </button>

                      <div class="dropdown">
                          <img src="{{ Auth::user()->foto ? asset('foto_profil/' . Auth::user()->foto) : asset('avatar.jpg') }}" class="navbar-photo dropdown-toggle" data-bs-toggle="dropdown">
                          <ul class="dropdown-menu dropdown-menu-end" style="min-width: 220px;">
                              <li class="user-header text-center p-3">
                                  <img src="{{ Auth::user()->foto ? asset('foto_profil/' . Auth::user()->foto) : asset('avatar.jpg') }}" 
                                      class="img-circle elevation-2 mb-2 d-block mx-auto"
                                      alt="User Image"
                                      style="width: 80px; height: 80px; object-fit: cover;">
                                  <p>
                                      {{ Auth::user()->name }}<br>
                                      <span class="badge badge-success">{{ ucfirst(Auth::user()->role) }}</span>
                                  </p>
                              </li>  

                              <li class="px-3 pb-3">
                                  <div class="d-flex justify-content-between gap-2">
                                      <a href="{{ route('profil.edit') }}" class="btn btn-white text-primary flex-fill text-center">
                                          <i class="fas fa-user-cog"></i> Profile
                                      </a>
                                      <a href="{{ route('logout') }}" 
                                        class="btn btn-white text-danger flex-fill text-center"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                          <i class="fas fa-sign-out-alt"></i> Sign out
                                      </a>
                                  </div>

                                  <!-- Form logout tersembunyi -->
                                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                      @csrf
                                  </form>
                              </li>
                          </ul>
                      </div>
        </nav>
