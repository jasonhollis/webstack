<?php
require_once __DIR__.'/layout.php';
$page_title = "NAS & Storage Solutions";
$page_desc  = "QNAP & Synology NAS setup, Time Machine, backup, on-premises storage, hybrid cloud, surveillance, and Docker services for Mac and business.";
$canonical = "https://www.ktp.digital/nas.php";
$og_image = "/images/nas/qnap-banner.jpg";
ob_start();
?>

<div class="p-2 sm:p-8 max-w-5xl mx-auto">
  <img src="/images/nas/qnap-banner.jpg" alt="QNAP TS-h1290FX" class="rounded shadow mb-8 w-full max-h-96 object-contain">

  <h1 class="text-3xl font-bold mb-6">NAS & Storage Solutions</h1>

  <p class="text-lg leading-relaxed mb-6">
    <strong>KTP Digital</strong> has delivered <strong>QNAP</strong> and <strong>Synology</strong> systems since 2008, building robust, secure, and scalable on-premise storage for creative, business, and regulated industries. We specialize in keeping your data <b>under your control</b>—with compliance, resilience, and full visibility.
  </p>

  <div class="space-y-8">
    <div>
      <div class="flex items-center gap-3 mb-2 text-xl font-semibold">
        <span class="text-2xl">🖥️</span> Designed for Apple & Creative Workflows
      </div>
      <div class="pl-7 text-base text-slate-100/90">
        Time Machine support for seamless Mac backups.<br>
        AFP & SMB for shared drives across Mac and PC.<br>
        Direct iCloud offload or sync-to-NAS strategies.
      </div>
    </div>

    <div>
      <div class="flex items-center gap-3 mb-2 text-xl font-semibold">
        <span class="text-2xl">🎥</span> Expand Storage for Surveillance
      </div>
      <div class="pl-7 text-base text-slate-100/90">
        Store video securely onsite for <a href="https://ui.com/camera-security" target="_blank" class="text-blue-400 underline">UniFi Protect</a>.<br>
        RAID, SSD caching, hot-swappable expansion.<br>
        Seamless integration into Ubiquiti-based infrastructure.
      </div>
    </div>

    <div>
      <div class="flex items-center gap-3 mb-2 text-xl font-semibold">
        <span class="text-2xl">🗄️</span> Centralized File Server
      </div>
      <div class="pl-7 text-base text-slate-100/90">
        Granular permissions and access control.<br>
        Secure sync and remote access without public cloud.<br>
        Automated backups to cloud or external disks.
      </div>
    </div>

    <div>
      <div class="flex items-center gap-3 mb-2 text-xl font-semibold">
        <span class="text-2xl">🔧</span> Docker & Proxy Services
      </div>
      <div class="pl-7 text-base text-slate-100/90">
        Full Docker support on QNAP for custom containers and apps.<br>
        Reverse proxy configuration for clean public URLs.<br>
        Private services like Home Assistant, analytics, and monitoring.<br>
        <span class="font-bold text-green-600">Rapid deployment:</span> We can spin up production-ready stacks in minutes.
      </div>
    </div>
  </div>

  <h2 class="text-2xl font-semibold mt-12 mb-4 flex items-center gap-2">
    <span class="text-2xl">🔍</span> QNAP vs Synology
  </h2>
  <div class="overflow-x-auto mb-6 max-w-3xl mx-auto">
    <table class="w-full text-base rounded-xl shadow bg-white text-black">
      <thead>
        <tr>
          <th class="p-4 font-bold bg-gray-200 text-black rounded-tl-xl text-left">Feature</th>
          <th class="p-4 font-bold bg-gray-200 text-black text-center">QNAP</th>
          <th class="p-4 font-bold bg-gray-200 text-black text-center rounded-tr-xl">Synology</th>
        </tr>
      </thead>
      <tbody>
        <tr class="even:bg-gray-50 odd:bg-white">
          <td class="p-4 text-left">Virtualization</td>
          <td class="p-4 text-center">
            <span class="inline-block align-middle text-green-600 mr-1">✔️</span>
            Native VM Manager
          </td>
          <td class="p-4 text-center">
            <span class="inline-block align-middle text-yellow-500 mr-1">⚠️</span>
            Docker only
          </td>
        </tr>
        <tr class="even:bg-gray-50 odd:bg-white">
          <td class="p-4 text-left">Surveillance</td>
          <td class="p-4 text-center">
            <span class="inline-block align-middle text-green-600 mr-1">✔️</span>
            High camera limits
          </td>
          <td class="p-4 text-center">
            <span class="inline-block align-middle text-green-600 mr-1">✔️</span>
            Polished interface
          </td>
        </tr>
        <tr class="even:bg-gray-50 odd:bg-white">
          <td class="p-4 text-left">Mac Support</td>
          <td class="p-4 text-center">
            <span class="inline-block align-middle text-green-600 mr-1">✔️</span>
            Time Machine, AFP, SMB
          </td>
          <td class="p-4 text-center">
            <span class="inline-block align-middle text-green-600 mr-1">✔️</span>
            Time Machine, SMB
          </td>
        </tr>
        <tr class="even:bg-gray-50 odd:bg-white">
          <td class="p-4 text-left">Ease of Use</td>
          <td class="p-4 text-center">
            <span class="inline-block align-middle text-yellow-500 mr-1">⚠️</span>
            Advanced users
          </td>
          <td class="p-4 text-center">
            <span class="inline-block align-middle text-green-600 mr-1">✔️</span>
            Beginner-friendly
          </td>
        </tr>
      </tbody>
    </table>
  </div>

  <div class="mt-8 text-base text-blue-500 flex items-center gap-2">
    <svg class="inline-block h-5 w-5 mr-1 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
      <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
    </svg>
    <span>
      Also see our
      <a href="mac.php" class="underline">Mac expertise</a>,
      <a href="smallbiz.php" class="underline">Small Business solutions</a>,
      and <a href="tailscale.php" class="underline">Tailscale networking</a>.
    </span>
  </div>
</div>

<?php
$content = ob_get_clean();
renderLayout($page_title, $content, '', $page_desc, $canonical, $og_image);
