<?php include_once __DIR__."/analytics_logger.php"; ?>
<?php
require 'layout.php';

$page_title = "About KTP Digital | Premium IT Solutions Melbourne";
$page_desc = "Melbourne's premium IT consultancy specializing in enterprise automation and luxury home technology. White glove service for discerning clients since 2010.";

$content = <<<HTML
<div class="max-w-6xl mx-auto">
  <!-- Hero Section -->
  <div class="text-center mb-12">
    <h1 class="text-4xl md:text-5xl font-bold mb-4 text-gray-900">About KTP Digital</h1>
    <p class="text-xl text-gray-600 max-w-3xl mx-auto">
      Melbourne's premier technology consultancy delivering enterprise-grade solutions 
      for luxury homes and businesses across Australia.
    </p>
  </div>

  <!-- Value Proposition -->
  <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white rounded-2xl p-8 md:p-12 mb-12">
    <div class="max-w-4xl mx-auto text-center">
      <h2 class="text-3xl font-bold mb-4">White Glove Technology Services</h2>
      <p class="text-lg mb-6">
        We blend decades of enterprise IT expertise with personalized service, 
        delivering sophisticated technology solutions that simply work.
      </p>
      <div class="grid md:grid-cols-3 gap-6 mt-8">
        <div class="text-center">
          <div class="text-4xl font-bold mb-2">15+</div>
          <div class="text-sm uppercase tracking-wide">Years Experience</div>
        </div>
        <div class="text-center">
          <div class="text-4xl font-bold mb-2">500+</div>
          <div class="text-sm uppercase tracking-wide">Projects Delivered</div>
        </div>
        <div class="text-center">
          <div class="text-4xl font-bold mb-2">$25M+</div>
          <div class="text-sm uppercase tracking-wide">Technology Managed</div>
        </div>
      </div>
    </div>
  </div>

  <!-- Core Services Grid -->
  <div class="mb-12">
    <h2 class="text-3xl font-bold text-center mb-8 text-gray-900">Our Expertise</h2>
    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
      <!-- Home Automation -->
      <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition">
        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
          <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
          </svg>
        </div>
        <h3 class="font-bold text-lg mb-2 text-gray-900">Home Automation</h3>
        <p class="text-gray-600 text-sm">
          Premium smart home solutions for Melbourne's finest properties. 
          Control4, Lutron, Sonos, and custom integrations.
        </p>
      </div>

      <!-- Enterprise IT -->
      <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition">
        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-4">
          <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
          </svg>
        </div>
        <h3 class="font-bold text-lg mb-2 text-gray-900">Enterprise IT</h3>
        <p class="text-gray-600 text-sm">
          Cloud architecture, cybersecurity, and managed services 
          for businesses requiring excellence.
        </p>
      </div>

      <!-- Networking -->
      <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition">
        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-4">
          <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"/>
          </svg>
        </div>
        <h3 class="font-bold text-lg mb-2 text-gray-900">Networking</h3>
        <p class="text-gray-600 text-sm">
          UniFi, Meraki, and enterprise-grade networking. 
          Seamless WiFi coverage for any space.
        </p>
      </div>

      <!-- Security -->
      <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition">
        <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mb-4">
          <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
          </svg>
        </div>
        <h3 class="font-bold text-lg mb-2 text-gray-900">Security</h3>
        <p class="text-gray-600 text-sm">
          Zero-trust architecture, compliance, and 24/7 monitoring. 
          Protecting what matters most.
        </p>
      </div>
    </div>
  </div>

  <!-- Client Focus -->
  <div class="grid md:grid-cols-2 gap-8 mb-12">
    <div class="bg-gray-50 rounded-xl p-8">
      <h3 class="text-2xl font-bold mb-4 text-gray-900">Our Clients</h3>
      <p class="text-gray-600 mb-4">
        We serve Melbourne's most discerning clients who demand excellence:
      </p>
      <ul class="space-y-2 text-gray-700">
        <li class="flex items-start">
          <svg class="w-5 h-5 text-blue-600 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
          </svg>
          <span>Luxury homeowners in Toorak, Brighton, and Armadale</span>
        </li>
        <li class="flex items-start">
          <svg class="w-5 h-5 text-blue-600 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
          </svg>
          <span>Professional services firms and financial institutions</span>
        </li>
        <li class="flex items-start">
          <svg class="w-5 h-5 text-blue-600 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
          </svg>
          <span>High-growth technology companies</span>
        </li>
        <li class="flex items-start">
          <svg class="w-5 h-5 text-blue-600 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
          </svg>
          <span>Property developers and architects</span>
        </li>
      </ul>
    </div>

    <div class="bg-gray-50 rounded-xl p-8">
      <h3 class="text-2xl font-bold mb-4 text-gray-900">Our Promise</h3>
      <p class="text-gray-600 mb-4">
        Every engagement reflects our commitment to excellence:
      </p>
      <ul class="space-y-2 text-gray-700">
        <li class="flex items-start">
          <svg class="w-5 h-5 text-green-600 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
          </svg>
          <span>White glove service from consultation to completion</span>
        </li>
        <li class="flex items-start">
          <svg class="w-5 h-5 text-green-600 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
          </svg>
          <span>Transparent pricing with no hidden costs</span>
        </li>
        <li class="flex items-start">
          <svg class="w-5 h-5 text-green-600 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
          </svg>
          <span>24/7 support for critical systems</span>
        </li>
        <li class="flex items-start">
          <svg class="w-5 h-5 text-green-600 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
          </svg>
          <span>Local Melbourne team, always</span>
        </li>
      </ul>
    </div>
  </div>

  <!-- Technology Partners -->
  <div class="text-center mb-12">
    <h3 class="text-2xl font-bold mb-6 text-gray-900">Trusted Technology Partners</h3>
    <div class="flex flex-wrap justify-center gap-8 items-center opacity-70">
      <span class="text-gray-600 font-semibold">Microsoft</span>
      <span class="text-gray-600 font-semibold">UniFi</span>
      <span class="text-gray-600 font-semibold">Tesla</span>
      <span class="text-gray-600 font-semibold">Sonos</span>
      <span class="text-gray-600 font-semibold">Control4</span>
      <span class="text-gray-600 font-semibold">Apple</span>
      <span class="text-gray-600 font-semibold">Google</span>
    </div>
  </div>

  <!-- CTA Section -->
  <div class="bg-gradient-to-r from-blue-600 to-cyan-600 rounded-2xl p-8 text-center text-white">
    <h2 class="text-3xl font-bold mb-4">Ready to Experience Excellence?</h2>
    <p class="text-lg mb-6 max-w-2xl mx-auto">
      Join Melbourne's elite who trust KTP Digital for their technology needs.
    </p>
    <div class="flex flex-col sm:flex-row gap-4 justify-center">
      <a href="/contact.php" class="inline-block bg-white text-blue-600 hover:bg-gray-100 px-8 py-3 rounded-lg font-bold transition">
        Schedule Consultation
      </a>
      <a href="/premium-landing.php" class="inline-block bg-blue-800 text-white hover:bg-blue-900 px-8 py-3 rounded-lg font-bold transition">
        View Our Services
      </a>
    </div>
  </div>
</div>
HTML;

renderLayout($page_title, $content, '', $page_desc);
?>