<?php 
if (!defined('ANALYTICS_LOADED')) {
    include_once __DIR__."/analytics_logger.php";
    define('ANALYTICS_LOADED', true);
}
include_once __DIR__."/services_menu.php";
?>
<nav class="bg-white dark:bg-black/90 fixed top-0 left-0 right-0 w-full shadow z-50">
  <div class="w-full px-4 sm:px-6 py-3 flex flex-wrap justify-between items-center">
    <a href="/" class="flex items-center space-x-2">
      <picture>
        <source srcset="images/logos/KTP Logo2.png" media="(prefers-color-scheme: dark)">
        <img src="/images/logos/KTP Logo.png" alt="KTP Logo" class="h-8 w-auto" style="max-height: 32px; height: 32px;">
      </picture>
      <span class="font-bold text-gray-900 dark:text-white text-lg">KTP Digital</span>
    </a>

    <!-- Hamburger toggle -->
    <button id="nav-toggle" class="lg:hidden text-gray-900 dark:text-white focus:outline-none transition-transform duration-300 ease-in-out ml-2">
      <svg id="icon-hamburger" class="w-6 h-6 block" fill="none" stroke="currentColor" stroke-width="2"
           viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
        <path d="M4 6h16M4 12h16M4 18h16" />
      </svg>
      <svg id="icon-close" class="w-6 h-6 hidden" fill="none" stroke="currentColor" stroke-width="2"
           viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
        <path d="M6 18L18 6M6 6l12 12" />
      </svg>
    </button>

    <!-- Desktop nav with dropdowns -->
    <div class="hidden lg:flex items-center space-x-1 text-sm font-medium text-gray-800 dark:text-white">
      <a href="/" class="px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-800 rounded transition">Home</a>
      
      <!-- Services Dropdown -->
      <div class="relative group">
        <button class="px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-800 rounded transition flex items-center">
          Services
          <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
          </svg>
        </button>
        <div class="absolute left-0 mt-1 w-64 bg-white dark:bg-gray-900 rounded-lg shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
          <?php foreach ($service_categories as $category => $data): ?>
            <div class="px-4 py-2 border-b border-gray-200 dark:border-gray-700 last:border-0">
              <div class="text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1">
                <?php echo $data['icon'] . ' ' . $category; ?>
              </div>
              <?php foreach ($data['pages'] as $url => $title): ?>
                <a href="<?php echo $url; ?>" class="block py-1 text-sm text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition">
                  <?php echo $title; ?>
                </a>
              <?php endforeach; ?>
            </div>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- Quick Links -->
      <a href="/premium-landing.php" class="px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-800 rounded transition">Premium</a>
      <a href="/about.php" class="px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-800 rounded transition">About</a>
      <a href="/contact.php" class="px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-800 rounded transition">Contact</a>
      
      <!-- CTA Button -->
      <a href="/lead_form.php" class="ml-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Get Quote</a>
    </div>
  </div>

  <!-- Mobile dropdown -->
  <div id="nav-dropdown" class="lg:hidden max-h-0 overflow-hidden transition-all duration-300 ease-in-out px-4 text-sm font-medium text-gray-800 dark:text-white">
    <div class="pt-2 pb-4 space-y-2">
      <a href="/" class="block py-2 hover:bg-gray-100 dark:hover:bg-gray-800 rounded px-3 nav-link">Home</a>
      
      <!-- Mobile Services Accordion -->
      <?php foreach ($service_categories as $category => $data): ?>
        <div class="mobile-category">
          <button class="w-full text-left py-2 px-3 hover:bg-gray-100 dark:hover:bg-gray-800 rounded flex justify-between items-center category-toggle">
            <span><?php echo $data['icon'] . ' ' . $category; ?></span>
            <svg class="w-4 h-4 transform transition-transform category-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
          </button>
          <div class="category-content hidden pl-6 space-y-1 mt-1">
            <?php foreach ($data['pages'] as $url => $title): ?>
              <a href="<?php echo $url; ?>" class="block py-1 text-sm text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 nav-link">
                <?php echo $title; ?>
              </a>
            <?php endforeach; ?>
          </div>
        </div>
      <?php endforeach; ?>
      
      <a href="/premium-landing.php" class="block py-2 hover:bg-gray-100 dark:hover:bg-gray-800 rounded px-3 nav-link">Premium Services</a>
      <a href="/about.php" class="block py-2 hover:bg-gray-100 dark:hover:bg-gray-800 rounded px-3 nav-link">About</a>
      <a href="/contact.php" class="block py-2 hover:bg-gray-100 dark:hover:bg-gray-800 rounded px-3 nav-link">Contact</a>
      <a href="/lead_form.php" class="block py-2 bg-blue-600 text-white rounded px-3 mt-2 text-center">Get Quote</a>
    </div>
  </div>

  <script>
    // Mobile nav toggle
    const toggle = document.getElementById('nav-toggle');
    const dropdown = document.getElementById('nav-dropdown');
    const iconHamburger = document.getElementById('icon-hamburger');
    const iconClose = document.getElementById('icon-close');

    toggle.addEventListener('click', () => {
      const isClosed = dropdown.classList.contains('max-h-0');
      dropdown.classList.toggle('max-h-0', !isClosed);
      dropdown.classList.toggle('max-h-[600px]', isClosed);
      dropdown.style.overflow = isClosed ? 'auto' : 'hidden';
      iconHamburger.classList.toggle('hidden', isClosed);
      iconClose.classList.toggle('hidden', !isClosed);
    });

    // Mobile category toggles
    document.querySelectorAll('.category-toggle').forEach(button => {
      button.addEventListener('click', () => {
        const content = button.nextElementSibling;
        const arrow = button.querySelector('.category-arrow');
        content.classList.toggle('hidden');
        arrow.classList.toggle('rotate-180');
      });
    });

    // Close mobile nav on link click
    document.querySelectorAll('.nav-link').forEach(link => {
      link.addEventListener('click', () => {
        dropdown.classList.add('max-h-0');
        dropdown.classList.remove('max-h-[600px]');
        dropdown.style.overflow = 'hidden';
        iconHamburger.classList.remove('hidden');
        iconClose.classList.add('hidden');
      });
    });

    // Close dropdowns when clicking outside
    document.addEventListener('click', (e) => {
      if (!e.target.closest('nav')) {
        dropdown.classList.add('max-h-0');
        dropdown.classList.remove('max-h-[600px]');
        dropdown.style.overflow = 'hidden';
        iconHamburger.classList.remove('hidden');
        iconClose.classList.add('hidden');
      }
    });
  </script>

  <style>
    /* Smooth dropdown animations */
    .group:hover .group-hover\:visible {
      animation: fadeIn 0.2s ease-in-out;
    }
    
    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(-10px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
    
    /* Mobile category arrow rotation */
    .category-arrow {
      transition: transform 0.2s ease;
    }
    
    .category-arrow.rotate-180 {
      transform: rotate(180deg);
    }
    
    /* Ensure dropdown doesn't get cut off */
    nav {
      overflow: visible !important;
    }
  </style>
</nav>