<?php
require __DIR__ . '/layout.php';

$page_title = "Real Home Assistant Stories | KTP Digital";
$page_description = "See real-world examples of Home Assistant installations by KTP Digital—showcasing total integration, legacy upgrades, and automation that truly works for families.";
$page_keywords = "Home Assistant, customer stories, case studies, automation, KTP Digital, C-Bus, integration, smart home, security, QNAP, Ubiquiti";

// Begin Stories Page Content
$content = <<<HTML
<section class="max-w-4xl mx-auto text-center pt-6 pb-8">
    <img src="/images/icons/home-assistant.svg" alt="Home Assistant Logo" class="mx-auto w-16 h-16 mb-4" loading="lazy">
    <h1 class="text-3xl sm:text-5xl font-bold mb-3">Home Assistant in Real Homes</h1>
    <p class="text-lg sm:text-2xl text-gray-700 mb-4">
        Real automation. Real families. No more app fatigue or tech chaos—just solutions that work.
    </p>
</section>

<section class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8 pb-12">
    <!-- Story 1 -->
    <div class="bg-white rounded-xl shadow p-7 flex flex-col text-left border border-gray-100">
        <div class="flex flex-col items-start mb-3">
            <span class="mb-2">
                <svg width="36" height="36" viewBox="0 0 24 24" fill="none">
                    <path d="M12 3C7.58 3 4 6.58 4 11c0 2.39 1.19 4.47 3 5.74V18a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1.26C18.81 15.47 20 13.39 20 11c0-4.42-3.58-8-8-8zm2 15h-4v-1h4v1zm0-3h-4v-1h4v1z" fill="#FFC107"/>
                </svg>
            </span>
            <h2 class="font-semibold text-xl">Customer Story #1: From App Fatigue to Effortless Living</h2>
        </div>
        <div class="text-gray-800 text-lg mb-6 leading-relaxed">
            On an initial assessment with the client, their home was a showcase for every kind of smart tech—hundreds of smart lights, smart appliances in the kitchen, laundry, air purifiers, robot vacuums, smart gates, garage doors, security cameras, smart solar with battery system, smart alarm system, smart blinds, and a complete home cinema.<br><br>
            Everything was generally “working” but all with separate applications that didn’t talk to one another. One app to open the garage door, another for a vacuum, etc. The client’s phone had nearly 25 different smart home apps, each with its own quirks, logins, and limitations.<br><br>
            <span class="font-semibold text-gray-700">Step one:</span> We put in several upgrades to the core network. Almost all home automation requires a strong local network. Without this in place you are destined for problems.<br>
            <span class="font-semibold text-gray-700">Step two:</span> We set up Home Assistant with both Z-Wave and Zigbee radios. A key element here is that Zigbee and WiFi need to be configured properly or they will conflict with one another in large systems.<br>
            <span class="font-semibold text-gray-700">Step three:</span> We integrated all the devices in one system with dashboards for specific rooms and functions and voice control across over 1300 entities—all running smoothly from one application both at home or remotely. New automations can be constructed across everything in the system.<br><br>
            We have constructed scenes that are run by geolocation and time of day that manage the heating, cooling, lighting, and blinds. When there is no one at home the robots clean; when someone returns, they stop and go back to base. There are specific controls in CarPlay and on the Apple Watch for things like garage doors.
        </div>
        <div class="bg-blue-50 rounded p-3 mt-auto text-base text-gray-700 font-semibold border border-blue-100">
            <span class="text-blue-700">Result:</span> The family enjoys real automation that “just works.” They feel secure, every device is visible and connected, and they have peace of mind—no drama, no endless app-switching. It’s smart home living, finally delivered.
        </div>
    </div>
    <!-- Story 2 -->
    <div class="bg-white rounded-xl shadow p-7 flex flex-col text-left border border-gray-100">
        <div class="flex flex-col items-start mb-3">
            <span class="mb-2">
                <svg width="36" height="36" viewBox="0 0 24 24" fill="none">
                    <path d="M12 3C7.58 3 4 6.58 4 11c0 2.39 1.19 4.47 3 5.74V18a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1.26C18.81 15.47 20 13.39 20 11c0-4.42-3.58-8-8-8zm2 15h-4v-1h4v1zm0-3h-4v-1h4v1z" fill="#FFC107"/>
                </svg>
            </span>
            <h2 class="font-semibold text-xl">Customer Story #2: Legacy Unlocked—C-Bus and Modern Smart Control</h2>
        </div>
        <div class="text-gray-800 text-lg mb-6 leading-relaxed">
            In another real world example, the client had invested in a premium C-Bus lighting system nearly 20 years ago, but without a true controller or usable access. Making changes meant calling a specialist at \$600 an hour. Smart, but stuck in the past.<br><br>
            KTP Digital put Home Assistant in front of their C-Bus system—unlocking full control and automation through a simple app and dashboard. We replaced their expensive alarm panel with a new one for just \$400, then implemented Ubiquiti AI-powered security cameras and Ubiquiti Access on the doors and gates. All camera footage is securely backed up to a fully managed QNAP NAS, so nothing is ever lost. Air conditioning and heating now work right from the app. We added new Z-Wave sensors for motion, lighting, and water leaks. If a leak is detected in a critical area, an alert is sent and the mains water is automatically disabled—no more flood risk.<br><br>
            The customer can finally use their C-Bus lighting investment to the fullest, managed directly through the Home Assistant app and UI. Their favourite new feature? Remote unlocking of the front door via facial recognition. Now, with an armful of groceries, they simply walk up and nudge the door open—no keys, no fuss. And for visitors or family who might be confused at the door, our system detects when someone is “lingering” at the front entrance and provides an audio announcement with instructions to ring the doorbell.<br><br>
            Any new hardware or automation that is required is integrated with Home Assistant with little to no sparky work and much lower costs than the legacy C-Bus system.<br><br>
            We have yet to find a smart home integration challenge we couldn't solve with Home Assistant. It works seamlessly with HomeKit, Google Home, and Alexa—often as subcomponents that Home Assistant polishes and controls. Our only limit is your imagination.
        </div>
        <div class="bg-blue-50 rounded p-3 mt-auto text-base text-gray-700 font-semibold border border-blue-100">
            <span class="text-blue-700">Result:</span> A legacy investment is now a modern, flexible smart home—trusted, supported, and evolving for years to come.
        </div>
    </div>
    <!-- Story 3 -->
    <div class="bg-white rounded-xl shadow p-7 flex flex-col text-left border border-gray-100">
        <div class="flex flex-col items-start mb-3">
            <span class="mb-2">
                <svg width="36" height="36" viewBox="0 0 24 24" fill="none">
                    <path d="M12 3C7.58 3 4 6.58 4 11c0 2.39 1.19 4.47 3 5.74V18a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1.26C18.81 15.47 20 13.39 20 11c0-4.42-3.58-8-8-8zm2 15h-4v-1h4v1zm0-3h-4v-1h4v1z" fill="#FFC107"/>
                </svg>
            </span>
            <h2 class="font-semibold text-xl">Customer Story #3: Full-Scope, Large Property, Modern Automation</h2>
        </div>
        <div class="text-gray-800 text-lg mb-6 leading-relaxed">
            This client previously contacted Control4, who quoted thousands for a simple lighting system. They wanted something open source, flexible, and highly integrated.<br><br>
            The property is large—about 15 acres—adding unique complexity.<br><br>
            <span class="font-semibold text-gray-700">First:</span> Upgraded from NBN FTTN to FTTP, going from 100 megabit to 1000 megabit (soon 2500), moving to our preferred ISP. This involved trenching and pulling 300 meters of fibre to the house (plus more to the gate), for fast, stable connectivity for cameras and controllers.<br><br>
            <span class="font-semibold text-gray-700">Next:</span> We implemented a full Ubiquiti stack—27 devices, including Dream Machine Pro SE, 4 switches, 10 gigabit fibre backbone, 5 WiFi 7 APs with meshing to outbuildings, 8 AI cameras, Ubiquiti Access at the gate and doors. License plate recognition at the gate and facial recognition at the doors provide automated, secure access. All systems are battery-backed, remotely monitored, and managed 24/7.<br><br>
            <span class="font-semibold text-gray-700">Then:</span> Complete Home Assistant design: 35 colour downlights outside, 20 indoors, Z-Wave dimmers for chandeliers/shutters, fully motion-driven hallways and bathrooms. All Sonos, Google Home, and Alexa devices are fully integrated with Music Assistant; dashboards are room-specific and tailored. TVs, vacuums, humidifiers, heating—completely integrated.<br><br>
            The system is built so automations override physical switches. With lots of wildlife, simple motion detection isn't enough, but Ubiquiti AI cams control entryway lighting based on actual people/cars and light levels. When someone arrives at night, the right lights come on automatically.<br><br>
            <span class="font-semibold text-gray-700">Next steps:</span> Irrigation, more access controls, and a smart pool.
        </div>
        <div class="bg-blue-50 rounded p-3 mt-auto text-base text-gray-700 font-semibold border border-blue-100">
            <span class="text-blue-700">Result:</span> A state-of-the-art, open, resilient automation platform, tailored for a large, complex property, ready to evolve for years to come.
        </div>
    </div>
</section>

<section class="max-w-3xl mx-auto text-center mt-8 mb-8">
    <a href="contact.php" class="inline-block px-8 py-3 bg-blue-700 text-white font-semibold rounded-lg shadow hover:bg-blue-800 transition mb-2">
        Book Your Home Automation Consult
    </a>
    <div class="text-gray-500 text-sm mt-2">Real stories. Real automation. Real support.</div>
</section>
HTML;
// End Stories Page Content

$canonical = "https://www.ktp.digital/ha-stories.php";
renderLayout($page_title, $content, '', $page_description, $canonical);
?>
