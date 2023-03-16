<div class='cms-search'>
    <div class='cms-search-left'>
        <div class='cms-menu-hold'>
            <a href="" class='cms-menu-hold-trigger'>
                <img src="{{ url('backend/locomotif/img/icon5.svg') }}">
            </a>
        </div>
        <div class='cms-menu-search-hold'>
            <form method='POST' action='' class='cms-menu-search-hold-element'>
                @csrf
                <div for="cmsSearch" class='cmsSearchSubmitHold'>
                    <input type="submit" value='' id='cmsSearchSubmit'>
                    <img src="{{ url('backend/locomotif/img/icon6.svg') }}">
                </div>
                <input type="text" name='cmsSearch' id='cmsSearch' placeholder="Search">
            </form>
        </div>
    </div><!--cms-search-left-->
    <div class='cms-search-right'>
        <div class='cms-infos-left'>
            <ul>
                <li>
                    <a href="" class='notification'>
                        <img src="{{ url('backend/locomotif/img/icon7.svg') }}">
                    </a>
                </li>
                <li>
                    <a href="">
                        <img src="{{ url('backend/locomotif/img/icon8.svg') }}">
                    </a>
                </li>
                <li class='logout-tab'>
					<a href="{{ route('admin/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <svg id="Logout" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 16 16">
                            <path id="Logout-2" data-name="Logout" d="M4.361,3.5a.861.861,0,0,0-.861.861V15.639a.861.861,0,0,0,.861.861H7.583a.75.75,0,0,1,0,1.5H4.361A2.361,2.361,0,0,1,2,15.639V4.361A2.361,2.361,0,0,1,4.361,2H7.583a.75.75,0,0,1,0,1.5Zm8.331,1.942a.75.75,0,0,1,1.061,0L17.78,9.47a.749.749,0,0,1,0,1.061l-4.028,4.028A.75.75,0,0,1,12.692,13.5l2.747-2.748H7.583a.75.75,0,0,1,0-1.5h7.856L12.692,6.5A.75.75,0,0,1,12.692,5.442Z" transform="translate(-2 -2)" fill="#6e7782" fill-rule="evenodd"/>
                          </svg>                          
                    </a>
					<form id="logout-form" action="{{ route('admin/logout') }}" method="POST" style="display: none;">
					    @csrf
					</form>
				</li>
            </ul>
        </div>
        <div class='cms-infos-right'>
            <div class='dashboard-infos'>
                <a href="/admin/users" class='dashboard-mask-hold'>
                    <div class='dashboard-mask'>
                        <img src="{{ url('backend/locomotif/img/user.jpg') }}">
                    </div>
                </a>
                <a class='dashboard-username' href="/admin/users">User name th... <span><img src="{{ url('backend/locomotif/img/icon9.svg') }}"></span> </a>
            </div>
        </div>
    </div>
</div>