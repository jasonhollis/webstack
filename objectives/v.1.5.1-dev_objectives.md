---
#### [2025-05-23 16:18:47 AEST][v.1.5.1-dev]
I'm very concerned or focused on getting some page hits and I want to optimise search as soon as we can but I'm conscious of the fact that we need to add a lot of content and make some changes.  What should we work on first?

---
#### [2025-05-23 16:20:40 AEST][v.1.5.1-dev]
**1\. Baseline: Analytics & Crawlability******

  * Confirm analytics capture is robust:  
Ensure all main/landing/service pages call your analytics logger—no gaps.
  * Verify robots.txt and sitemap.xml exist:
    * robots.txt should permit crawling (but block admin, snapshots, etc.).
    * sitemap.xml should be up-to-date and linked in robots.txt and <head>.
  * Meta tags for search engines:
    * Ensure <title>, <meta name="description">, and canonical URLs are unique and relevant per page.
    * Use Open Graph tags for better social visibility.

  


**2\. Content Strategy******

  * Add core content pages ASAP:
    * Expand service pages (Small Business, Enterprise, Automation, Mac, NAS, Tailscale, NextDNS).
    * Each should have at least a solid paragraph and 3-5 key service/feature callouts.
    * Internal links between related services (e.g., from Small Business → Tailscale, Mac, NextDNS).
  * Polish About, Contact, and Home:
    * Update About to tell your story and why clients choose you.
    * Prominent CTA (“Contact Us”, “Book a Call”, etc.) on every page.

  


**3\. Technical SEO Quick Wins******

  * Speed:  
Make sure Tailwind is optimized (minified, loaded from assets, not CDN for production).
  * Accessibility:  
Use semantic headings, alt tags for all images, ARIA labels as needed.
  * Mobile:  
Confirm all pages look clean and usable on mobile—fix any layout glitches.

  


**4\. Future-Focused (Phase 2, after above):******

  * Schema markup:  
Add JSON-LD for business info, products/services, articles, etc.
  * Blog/News section:  
Even one post per month massively helps SEO and gives visitors fresh content.
  * FAQ page:  
Targeting your real-world questions boosts long-tail search.

  


**Immediate Actions (if you want to move fast):******

  1. Update meta and head tags on every page  
(title, description, canonical, Open Graph)
  2. Build and deploy sitemap.xml, link it in robots.txt
  3. Draft and publish expanded content for at least two more service pages

---
#### [2025-05-23 16:33:33 AEST][v.1.5.1-dev]
PageHas `<title>`?Has `<meta desc>`?To Do

about.php
❌
❌
Add both

automation.php
❌
❌
Add both

contact.php
❌
❌
Add both

enterprise.php
❌
❌
Add both

index.php
✅
❌
Add meta desc

mac.php
✅
❌
Add meta desc

nas.php
✅
❌
Add meta desc

nextdns.php
✅
✅
(Looks good)

smallbiz.php
❌
❌
Add both

tailscale.php
✅
✅
(Looks good)


---
#### [2025-05-23 16:36:56 AEST][v.1.5.1-dev]
![](/admin/objectives/images/Screenshot-2025-05-23-at-16.36.44.png)

