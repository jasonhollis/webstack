(function(){
  function setCookie(name, value, days) {
    var d = new Date();
    d.setTime(d.getTime() + days*24*60*60*1000);
    document.cookie = name + "=" + value + ";path=/;expires=" + d.toUTCString();
  }
  function getCookie(name) {
    var v = document.cookie.match('(^|;)\\s*' + name + '\\s*=\\s*([^;]+)');
    return v ? v.pop() : '';
  }
  function loadAnalytics(){
    var s = document.createElement('script');
    s.src = 'https://www.google-analytics.com/analytics.js';
    document.head.appendChild(s);
    window.ga = window.ga || function(){ (ga.q = ga.q || []).push(arguments); };
    ga('create', 'UA-XXXXXX-Y', 'auto');
    ga('send', 'pageview');
  }
  window.addEventListener('DOMContentLoaded', function(){
    var consent = getCookie('cookie_consent');
    if (consent === 'yes') {
      loadAnalytics();
    } else if (consent !== 'no') {
      var banner = document.createElement('div');
      banner.id = 'cookie-banner';
      banner.innerHTML = '<p>We use cookies for analytics and to enhance your experience. Do you accept?</p>' +
                         '<div>' +
                         '<button class="accept">Accept</button>' +
                         '<button class="decline">Decline</button>' +
                         '</div>';
      document.body.appendChild(banner);
      banner.querySelector('.accept').onclick = function(){
        setCookie('cookie_consent', 'yes', 365);
        loadAnalytics();
        banner.remove();
      };
      banner.querySelector('.decline').onclick = function(){
        setCookie('cookie_consent', 'no', 365);
        banner.remove();
      };
    }
  });
})();
