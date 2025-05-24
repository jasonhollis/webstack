<?php include __DIR__."/analytics_logger.php"; ?>
<nav class="bg-white dark:bg-black/90 fixed top-0 left-0 right-0 w-full shadow z-50">
  <div class="w-full px-4 sm:px-6 py-3 flex flex-wrap justify-between items-center overflow-x-auto">
    <a href="index.php" class="flex items-center space-x-2">
      <picture>
        <source srcset="images/logos/KTP Logo2.png" media="(prefers-color-scheme: dark)">
        <img src="/images/logos/KTP Logo.png" alt="KTP Logo" class="h-8 w-auto">
      </picture>
      <span class="font-bold text-gray-900 dark:text-white text-lg">KTP Digital</span>
    </a>

    <!-- Hamburger toggle -->
    <button id="nav-toggle" class="md:hidden text-gray-900 dark:text-white focus:outline-none transition-transform duration-300 ease-in-out ml-2">
      <svg id="icon-hamburger" class="w-6 h-6 block" fill="none" stroke="currentColor" stroke-width="2"
           viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
        <path d="M4 6h16M4 12h16M4 18h16" />
      </svg>
      <svg id="icon-close" class="w-6 h-6 hidden" fill="none" stroke="currentColor" stroke-width="2"
           viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
        <path d="M6 18L18 6M6 6l12 12" />
      </svg>
    </button>

    <!-- Desktop nav -->
    <div class="hidden md:flex space-x-4 text-sm font-medium text-gray-800 dark:text-white whitespace-nowrap">
      <a href="index.php" class="hover:underline">Home</a>
      <a href="smallbiz.php" class="hover:underline">Small Business</a>
      <a href="enterprise.php" class="hover:underline">Enterprise</a>
      <a href="automation.php" class="hover:underline">Automation</a>
      <a href="about.php" class="hover:underline">About</a>
      <a href="contact.php" class="hover:underline">Contact</a>
    </div>
  </div>

  <!-- Mobile dropdown -->
  <div id="nav-dropdown" class="md:hidden max-h-0 overflow-hidden transition-all duration-300 ease-in-out px-4 text-sm font-medium text-gray-800 dark:text-white">
    <div class="pt-2 pb-4 space-y-2">
      <a href="index.php" class="block hover:underline nav-link">Home</a>
      <a href="smallbiz.php" class="block hover:underline nav-link">Small Business</a>
      <a href="enterprise.php" class="block hover:underline nav-link">Enterprise</a>
      <a href="automation.php" class="block hover:underline nav-link">Automation</a>
      <a href="about.php" class="block hover:underline nav-link">About</a>
      <a href="contact.php" class="block hover:underline nav-link">Contact</a>
    </div>
  </div>

  <script>
    const toggle = document.getElementById('nav-toggle');
    const dropdown = document.getElementById('nav-dropdown');
    const iconHamburger = document.getElementById('icon-hamburger');
    const iconClose = document.getElementById('icon-close');

    toggle.addEventListener('click', () => {
      const isClosed = dropdown.classList.contains('max-h-0');
      dropdown.classList.toggle('max-h-0', !isClosed);
      dropdown.classList.toggle('max-h-96', isClosed);
      iconHamburger.classList.toggle('hidden', isClosed);
      iconClose.classList.toggle('hidden', !isClosed);
    });

    document.querySelectorAll('.nav-link').forEach(link => {
      link.addEventListener('click', () => {
        dropdown.classList.add('max-h-0');
        dropdown.classList.remove('max-h-96');
        iconHamburger.classList.remove('hidden');
        iconClose.classList.add('hidden');
      });
    });
  </script>
</nav>
