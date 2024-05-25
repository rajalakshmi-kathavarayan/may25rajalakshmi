// ===================== script for side bar =====================//

$(document).ready(function() {
    var sidebar = $(".sidebar");
    var sidebarBtn = $(".sidebarBtn");

    sidebarBtn.click(function() {
      sidebar.toggleClass("active");

      if (sidebar.hasClass("active")) {
        sidebarBtn.removeClass("bx-menu").addClass("bx-menu-alt-right");
      } else {
        sidebarBtn.removeClass("bx-menu-alt-right").addClass("bx-menu");
      }
    });

    var path = window.location.pathname;

    $('.nav-links li').each(function() {
        var href = $(this).find('a').attr('href');
        if (path === href) {
            $(this).addClass('act');
        }
    });
  });

