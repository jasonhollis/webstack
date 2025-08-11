<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Project Objectives – KTP Digital</title>
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <link rel="stylesheet" href="/assets/tailwind.min.css">
</head>
<body class="bg-white text-gray-900  ">
<?php include 'admin_nav.php'; ?>
<?php include 'admin_auth.php'; ?>
<div class="max-w-3xl mx-auto mt-14 mb-20 p-8 bg-white  rounded-2xl shadow-2xl text-base leading-relaxed font-sans">
  <h1 class="text-4xl font-bold mb-10 flex items-center gap-4">
    <span class="inline-block">KTP Website: Project Objectives</span>
      </h1>

  <div class="mb-8">
    <div class="font-bold text-lg mb-3">1. Remote-First, CLI-Focused Workflow</div>
    <ul class="list-disc list-inside space-y-2 text-gray-800 ">
      <li>All code, admin, and maintenance must be operable from a remote shell (SSH) and file editor (BBEdit/vim/nano) on Mac.</li>
      <li>Never rely on a GUI or local desktop uploads; everything is managed via secure shell, SFTP/SCP, or direct code entry.</li>
      <li>Scripts are patched using EOF blocks — <span class="font-mono bg-gray-100  px-2 py-1 rounded">cat &lt;&lt; 'EOF' &gt; file</span> — for zero ambiguity and maximum repeatability.</li>
    </ul>
  </div>

  <div class="mb-8">
    <div class="font-bold text-lg mb-3">2. Versioned, Auditable, and Automated</div>
    <ul class="list-disc list-inside space-y-2 text-gray-800 ">
      <li>Every change is tracked: objectives, changelogs, and admin scripts are versioned with clear timestamps and version numbers.</li>
      <li>Use version bump scripts and ZIP snapshot tooling for instant rollback and deployment (<span class="font-mono">update_version.sh</span>, <span class="font-mono">snapshot_webstack.sh</span>, etc).</li>
      <li>Objectives and change logs are always up-to-date, readable, and downloadable from the admin panel.</li>
    </ul>
  </div>

  <div class="mb-8">
    <div class="font-bold text-lg mb-3">3. Security, Simplicity, and Portability</div>
    <ul class="list-disc list-inside space-y-2 text-gray-800 ">
      <li>All navigation, assets, and code paths are kept relative/configurable for easy migration between environments (<span class="font-mono">ww2</span> → <span class="font-mono">www</span>).</li>
      <li>Admin tools, analytics, and maintenance are centralized under <span class="font-mono">/admin</span>, with progressive hardening (future SSO/OIDC).</li>
      <li>Headless operation is non-negotiable: No steps can require local GUI or non-scripted file actions.</li>
    </ul>
  </div>

  <div class="mb-8">
    <div class="font-bold text-lg mb-3">4. Rapid, Direct Iteration</div>
    <ul class="list-disc list-inside space-y-2 text-gray-800 ">
      <li>All feature patches and fixes delivered as full file EOF blocks, ready for immediate SSH/vim paste or remote deployment.</li>
      <li>No onboarding, no verbose explanations, no “setup” boilerplate: every instruction should assume project familiarity and get straight to the objective.</li>
      <li>Next-step recommendations and summary resume lines help move quickly between chats and version bumps.</li>
    </ul>
  </div>

  <div class="mb-2">
    <div class="font-bold text-lg mb-3">5. Analytical, Metrics-Driven Improvements</div>
    <ul class="list-disc list-inside space-y-2 text-gray-800 ">
      <li>Traffic, logs, and analytics (IPs, referers, user-agents) are crucial. Everything must be both logged and visualizable for future SEO/marketing insights.</li>
      <li>Admin features (health checks, download links, analytics) must be practical, pixel-perfect, and accessible via the web admin, with quick iteration if broken.</li>
    </ul>
  </div>
</div>
</body>
</html>
