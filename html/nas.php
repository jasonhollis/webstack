<?php
require 'layout.php';

$page_title = "Business Data Safety & NAS Solutions | KTP Digital";
$page_desc = "Worried about data loss, failed backups, or ransomware? KTP Digital sets up business-class NAS and backup systems so you can stop stressing and get back to work. 24/7 recovery, real support.";
$canonical = "https://www.ktp.digital/nas.php";
$og_image = "/images/icons/nas-white.svg";
$meta = <<<HTML
<meta name="description" content="Are your backups working? Business-class NAS & data safety—stop worrying about lost files or ransomware. Get peace of mind with KTP Digital." />
<meta property="og:title" content="Business Data Safety & NAS Solutions | KTP Digital" />
<meta property="og:description" content="Worried about losing your business data? We set up NAS, backups, and recovery for true peace of mind. No IT headaches—just safe data." />
<meta property="og:image" content="/images/icons/nas-white.svg" />
<link rel="canonical" href="https://www.ktp.digital/nas.php" />
HTML;

ob_start();
?>

<div class="max-w-3xl mx-auto py-12 px-4">
  <div class="flex items-center mb-6">
    <img src="/images/icons/nas-white-inverted.png" alt="NAS & Storage" class="w-12 h-12 mr-4">
    <h1 class="text-3xl md:text-4xl font-extrabold">Is Your Business Data Really Safe?</h1>
  </div>
  <p class="text-lg mb-5">
    <strong>What would happen if your main computer died right now? Would you lose weeks of work? Would you be able to get your files back? Would your business survive ransomware, fire, or a simple accidental deletion?</strong>
  </p>
  <div class="mb-8 bg-slate-800/90 p-6 rounded-xl">
    <p class="mb-2">
      Most small businesses <strong>don’t know if their backups are working</strong>. Many have no backup at all—just hope. We’ve seen businesses lose everything due to a faulty USB drive, cloud sync glitch, or just plain bad luck.
    </p>
    <p>
      That pain is avoidable. We design, install, and support <strong>business-class NAS & backup solutions</strong> (QNAP, Synology, and more) so you can stop worrying and focus on your work.
    </p>
  </div>
  <ul class="grid md:grid-cols-2 gap-5 mb-8 text-base">
    <li class="bg-slate-900/90 p-5 rounded-xl flex items-start">
      <span class="font-bold mr-2 text-green-400">&#10003;</span>
      <div>
        <span class="font-bold">Automatic backups that really work</span><br>
        Daily, hourly, and versioned—so you can always get your files back.
      </div>
    </li>
    <li class="bg-slate-900/90 p-5 rounded-xl flex items-start">
      <span class="font-bold mr-2 text-green-400">&#10003;</span>
      <div>
        <span class="font-bold">Ransomware and disaster recovery</span><br>
        Recover in minutes from any attack, hardware failure, or accident.
      </div>
    </li>
    <li class="bg-slate-900/90 p-5 rounded-xl flex items-start">
      <span class="font-bold mr-2 text-green-400">&#10003;</span>
      <div>
        <span class="font-bold">Access your files from anywhere</span><br>
        Secure remote access for your team—no more emailing yourself files.
      </div>
    </li>
    <li class="bg-slate-900/90 p-5 rounded-xl flex items-start">
      <span class="font-bold mr-2 text-green-400">&#10003;</span>
      <div>
        <span class="font-bold">Real support when it matters</span><br>
        We monitor your backups, test your recovery, and are on call when you need us.
      </div>
    </li>
  </ul>
  <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
    <a href="/contact.php" class="bg-green-700 hover:bg-green-800 text-white text-lg font-semibold px-8 py-3 rounded-lg shadow-lg transition">Stop Worrying—Talk to Us</a>
    <a href="/about.php" class="text-green-400 hover:underline text-lg font-semibold">Why KTP Digital?</a>
  </div>
  <div class="mt-8 text-base text-slate-400">
    <strong>Real stories, real recovery:</strong> We’ve rescued years of business data for clients who lost everything—because they called us before it was too late. <a href="/contact.php" class="text-green-400 underline hover:text-green-600">Find your peace of mind now</a>.
  </div>

  <!-- Technical comparison appendix -->
  <div class="mt-14">
    <h2 class="text-2xl font-semibold mt-12 mb-4 flex items-center">
      <span class="text-2xl">🔍</span> QNAP vs Synology: What’s the Difference?
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
</div>

<?php
$content = ob_get_clean();
renderLayout($page_title, $content, $meta, $page_desc, $canonical, $og_image);
