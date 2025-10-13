<nav class="bg-white border-b border-gray-200 px-4 py-2 flex items-center justify-between shadow-sm">
    {{-- Left section --}}
    <div class="flex items-center space-x-3">
        {{-- Sidebar toggle --}}
        <button class="text-gray-600 hover:text-gray-800 focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        {{-- Quick icons --}}
        <div class="flex items-center space-x-2">
            <button class="p-2 rounded-full hover:bg-gray-100 text-gray-600">
                <i class="fas fa-globe"></i>
            </button>
            <button class="p-2 rounded-full hover:bg-gray-100 text-gray-600">
                <i class="fas fa-calculator"></i>
            </button>
            <button class="p-2 rounded-full hover:bg-gray-100 text-gray-600">
                <i class="fas fa-chart-bar"></i>
            </button>
        </div>

        {{-- Nav Links --}}
        <ul class="flex items-center space-x-5 text-sm font-medium ml-4">
            <li><a href="#" class="text-blue-500">Dashboard</a></li>
            <li><a href="#" class="text-gray-700 hover:text-blue-500">Orders</a></li>
            <li><a href="#" class="text-gray-700 hover:text-blue-500">Preorders</a></li>
            <li><a href="#" class="text-gray-700 hover:text-blue-500">Earnings</a></li>
            <li class="flex flex-col text-xs leading-tight">
                <a href="#" class="text-gray-700 hover:text-blue-500 font-medium">Homepage</a>
                <a href="#" class="text-gray-700 hover:text-blue-500">Settings</a>
            </li>
        </ul>
    </div>

    {{-- Right section --}}
    <div class="flex items-center space-x-4">
        {{-- Add New button --}}
        <button class="bg-blue-50 text-blue-500 font-medium px-3 py-1 rounded-lg flex items-center space-x-1 hover:bg-blue-100">
            <span>Add New</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
        </button>

        {{-- Notification bell --}}
        <button class="p-2 rounded-full hover:bg-gray-100 text-gray-600">
            <i class="fas fa-bell"></i>
        </button>

        {{-- Flag icon --}}
        <img src="https://flagcdn.com/us.svg" alt="flag" class="w-6 h-6 rounded-full">

        {{-- Profile --}}
        <div class="flex items-center space-x-2">
            <img src="https://randomuser.me/api/portraits/men/85.jpg" alt="profile" class="w-8 h-8 rounded-full">
            <div class="text-right">
                <p class="text-sm font-medium text-gray-800">William C. Schroyer</p>
                <p class="text-xs text-gray-500">admin</p>
            </div>
        </div>
    </div>
</nav>
