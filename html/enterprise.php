<?php include __DIR__."/analytics_logger.php"; ?>
<?php
require 'layout.php';

$page_title = "Enterprise Consulting & IT Strategy – KTP Digital";
$page_desc  = "Vendor-agnostic enterprise consulting for Zero Trust, IAM, Windows 10 migration, API security, and hybrid cloud. Proven delivery across government, finance, and global business.";
$canonical = "https://www.ktp.digital/enterprise.php";
$og_image = "/images/icons/enterprise-hierarchy-white.svg";
$meta = <<<HTML
<meta name="description" content="KTP Digital: Independent enterprise consulting for Zero Trust, IAM, Windows 10 end-of-life migration, API security, and hybrid cloud. Delivered for government, finance, and multinationals." />
<meta property="og:title" content="Enterprise Consulting & IT Strategy – KTP Digital" />
<meta property="og:description" content="Strategic IT consulting for enterprise: Zero Trust, identity management, Windows 10 EOL, API security, and cloud. KTP Digital delivers real results for global business and government." />
<meta property="og:image" content="/images/icons/enterprise-hierarchy-white.svg" />
<link rel="canonical" href="https://www.ktp.digital/enterprise.php" />
HTML;

$content = <<<HTML
<section class="max-w-6xl mx-auto p-6">
  <h1 class="text-4xl font-bold mb-4 flex items-center">
    <img src="/images/icons/enterprise-hierarchy-white.svg" alt="Enterprise Consulting" class="h-10 w-10 mr-3">
    Enterprise Consulting & IT Strategy
  </h1>
  <p class="mb-6 text-lg">
    Decades of leadership across APJ, EMEA, and the US. KTP Digital brings an independent, vendor-agnostic, and outcome-driven approach to complex enterprise IT challenges—including urgent Windows 10 end-of-life and digital transformation programs.
  </p>
  <ul class="list-disc list-inside text-left text-lg space-y-2 mb-6">
    <li><strong>Identity Management (IAM) & Zero Trust Architecture</strong></li>
    <li>Windows 10 end-of-life migration strategy & workforce transformation</li>
    <li>API security, governance, and hybrid integration</li>
    <li>Endpoint, data, and infrastructure protection</li>
    <li>PAM, CMDB, and ITSM strategy—hands-on or advisory</li>
    <li>Cloud migration, SaaS security, and regulatory compliance</li>
    <li>Vendor-neutral RFP support, architecture, and due diligence</li>
  </ul>
  <p class="mt-6 text-lg">
    Trusted by governments, financial institutions, healthcare, and global multinationals for secure, modern, and compliant delivery.
  </p>
  <div class="flex justify-center mt-10">
    <a href="/contact.php" class="inline-block px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow transition">
      Book an Enterprise Discovery Call
    </a>
  </div>
</section>
HTML;

renderLayout($page_title, $content, $meta, $page_desc, $canonical, $og_image);
