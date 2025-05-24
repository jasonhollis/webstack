<?php include __DIR__."/analytics_logger.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Tailscale – KTP Digital</title>
  <meta name="description" content="Tailscale VPN solutions by KTP Digital – secure networking made simple.">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="https://cdn.tailwindcss.com/3.4.1"></script>
</head>
<body class="bg-white text-gray-800 dark:bg-gray-900 dark:text-white">
<?php include 'nav.php'; ?>
  <div class="max-w-5xl mx-auto p-6 pt-20">
    <h1 class="text-4xl font-bold mb-4">🔒 Tailscale VPN Solutions</h1>
    <p class="mb-6 text-lg">
      Tailscale is a mesh VPN that makes secure networking effortless for small teams, remote workers, and complex multi-site environments.
    </p>

    <div class="grid md:grid-cols-2 gap-6 mb-10">
      <div class="p-4 border rounded-lg dark:border-gray-700 shadow">
        <h2 class="text-2xl font-semibold mb-2">Zero Configuration</h2>
        <p>Connect all your devices without port forwarding, static IPs, or firewall headaches.</p>
      </div>
      <div class="p-4 border rounded-lg dark:border-gray-700 shadow">
        <h2 class="text-2xl font-semibold mb-2">Secure by Default</h2>
        <p>Built on WireGuard for fast, encrypted, peer-to-peer connections between your devices.</p>
      </div>
      <div class="p-4 border rounded-lg dark:border-gray-700 shadow">
        <h2 class="text-2xl font-semibold mb-2">Access From Anywhere</h2>
        <p>Access your home, office, NAS, or cloud services as if they were on the same network.</p>
      </div>
      <div class="p-4 border rounded-lg dark:border-gray-700 shadow">
        <h2 class="text-2xl font-semibold mb-2">Centralized Control</h2>
        <p>Manage ACLs, routes, and access from a simple web dashboard or via code.</p>
      </div>
    </div>

    <a href="https://tailscale.com" target="_blank" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">
      Visit tailscale.com →
    </a>
  </div>
  <footer class="mt-12 text-center text-sm text-gray-500 dark:text-gray-400">
    &copy; <?php echo date("Y"); ?> KTP Digital Pty Ltd. All rights reserved.
  </footer>
</body>
</html>
