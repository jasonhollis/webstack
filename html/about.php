<?php include __DIR__."/analytics_logger.php"; ?>
<?php include __DIR__."/analytics_logger.php"; ?>
<?php
require 'layout.php';

$page_title = "About KTP Digital | White Glove IT Experts";
$page_desc  = "White glove IT support and consulting for enterprise, SMB, and home. KTP Digital blends decades of experience with personal, secure, and reliable service.";

$content = <<<HTML
<h1 class="text-3xl sm:text-4xl font-bold">About KTP Digital</h1>
<p class="text-base sm:text-lg text-gray-300 mb-6">
  KTP Digital is an Australian team dedicated to delivering white glove IT consulting, automation, and secure networking solutions.<br>
  We serve enterprises, small businesses, and home automation enthusiasts who value expertise, transparency, and truly personal service.
</p>

<div class="grid gap-6 sm:grid-cols-2 text-left text-gray-200 mt-6 text-sm">
  <div>
    <h2 class="text-lg font-semibold text-green-400 mb-2">Our Approach</h2>
    <ul class="list-disc list-inside space-y-1">
      <li>White glove support at every stage—design, deployment, and beyond</li>
      <li>Modern, proven technologies with clear explanations</li>
      <li>Solutions tailored to each client’s needs and scale</li>
      <li>Focus on reliability, security, and ease of management</li>
    </ul>
  </div>
  <div>
    <h2 class="text-lg font-semibold text-blue-400 mb-2">Our Experience</h2>
    <ul class="list-disc list-inside space-y-1">
      <li>35+ years of combined IT leadership and technical expertise</li>
      <li>Serving banks, telcos, startups, and critical infrastructure</li>
      <li>Deep knowledge across enterprise, SMB, and home environments</li>
      <li>Expertise in cloud, security, and automation</li>
    </ul>
  </div>
  <div>
    <h2 class="text-lg font-semibold text-purple-400 mb-2">What We Deliver</h2>
    <ul class="list-disc list-inside space-y-1">
      <li>Zero Trust & Identity Architecture</li>
      <li>API Security, Compliance, & Governance</li>
      <li>Cloud migrations & hybrid IT deployments</li>
      <li>Smart networking and automation for homes & offices</li>
    </ul>
  </div>
  <div>
    <h2 class="text-lg font-semibold text-yellow-400 mb-2">Why Choose Us?</h2>
    <ul class="list-disc list-inside space-y-1">
      <li>Friendly, responsive, and honest advice</li>
      <li>Real-world references and a proven track record</li>
      <li>White glove service, every client, every time</li>
    </ul>
  </div>
</div>

<div class="mt-4">
  <a href="mailto:info@ktp.digital" class="inline-block bg-blue-500 hover:bg-blue-600 text-white px-5 py-2 sm:px-6 sm:py-3 rounded-lg text-sm font-semibold shadow">
    Contact Our Team
  </a>
</div>
HTML;

renderLayout($page_title, $content, '', $page_desc);
