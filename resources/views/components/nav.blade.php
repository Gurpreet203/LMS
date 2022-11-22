<nav class="nav">
    <div>
        <i class="bi bi-bell"></i>

        <div class="btn-group">
            <button class="btn-sm dropdown-toggle" id="nav-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="margin-left:0;">
              {{Auth::user()->name}}
            </button>
            <ul class="dropdown-menu">
                <li class="drop-items">
                    <div class="drop-items-icon">
                        <i class="bi bi-gear"></i>
                        <a href="{{ route('account') }}">Account & setting</a>
                    </div>
                </li>
              <li>
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <div class="drop-items-icon">
                        <i class="bi bi-box-arrow-left"></i>
                        <input type="submit" class="drop-items" value="Logout"> 
                    </div>
                     
                </form>
              </li>
            </ul>
          </div>
    </div>
</nav>