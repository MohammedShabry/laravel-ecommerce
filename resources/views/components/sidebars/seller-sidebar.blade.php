<aside
    class="fixed inset-y-0 left-0 bg-white border-r border-gray-200 w-64 transform transition-transform duration-200 ease-in-out z-40"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
>
    <div class="p-4 border-b border-gray-100">
        <h1 class="text-xl font-bold text-gray-800">Seller Panel</h1>
    </div>

    <ul class="mt-4 space-y-2">
        <li>
            <a href="#"
               class="flex items-center px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg">
                <i class="fas fa-tachometer-alt mr-3"></i> Dashboard
            </a>
        </li>
        <li>
            <a href="#"
               class="flex items-center px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg">
                <i class="fas fa-shopping-cart mr-3"></i> Orders
            </a>
        </li>
        <li>
            <a href="#"
               class="flex items-center px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg">
                <i class="fas fa-box-open mr-3"></i> Preorders
            </a>
        </li>
        <li>
            <a href="#"
               class="flex items-center px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg">
                <i class="fas fa-dollar-sign mr-3"></i> Earnings
            </a>
        </li>
        <li>
            <a href="#"
               class="flex items-center px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg">
                <i class="fas fa-cog mr-3"></i> Settings
            </a>
        </li>
    </ul>
</aside>
