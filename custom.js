// Return anchor tags to their unfocused state.
document.querySelectorAll('.wp-block-button__link').forEach(button => {
  button.addEventListener('click', function() {    
    this.blur();
  });
});

// Hide the nav's search icon container when the search form is open.
document.querySelectorAll('.wp-block-search__button').forEach(button => {
  button.addEventListener('click', function() {
    const searchIconContainer = document.querySelector('.wp-block-navigation__responsive-container');
    if (searchIconContainer) {
      searchIconContainer.style.display = 'none';
    }
  });
}
);

// Hide the nav's search icon container when the mobile menu is toggled open.
document.querySelectorAll('.menu-toggle').forEach(button => {
  button.addEventListener('click', function() {
    const searchIconContainer = document.querySelector('.responsive-header-search');

    if (searchIconContainer) {      
      if (searchIconContainer.style.display === 'none') 
        searchIconContainer.style.display = 'block';
      else
        searchIconContainer.style.display = 'none';
    }
  });
});

// Ensure that all the submenus close when the x is clicked in the mobile menu.
document.addEventListener('DOMContentLoaded', function () {
  const toggleBtn = document.querySelector('.menu-toggle');

  if (toggleBtn) {
    toggleBtn.addEventListener('click', function () {
      const nav = document.getElementById('site-navigation');
      const isMenuOpen = nav.classList.contains('toggled');

      if (!isMenuOpen) {
        // Menu was just closed
        document.querySelectorAll('#header-menu li.focus').forEach(item => {
          item.classList.remove('focus');
          const submenu = item.querySelector(':scope > ul.sub-menu');
          if (submenu) submenu.style.display = 'none';
        });
      }
    });
  }
});

// Reliably add the "focus" class to the parent <li> of the clicked caret in the header menu.
document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('#header-menu .menu-item-has-children .res-iconify').forEach(icon => {
    const parentLi = icon.closest('li.menu-item-has-children');
    const link = parentLi.querySelector(':scope > a');

    const toggleSubmenu = e => {
      e.preventDefault();
      e.stopPropagation();

      if (!parentLi) return;

      const isFocused = parentLi.classList.contains('focus');

      parentLi.parentElement.querySelectorAll(':scope > li.focus').forEach(li => {
        if (li !== parentLi) li.classList.remove('focus');
      });

      parentLi.classList.toggle('focus', !isFocused);
      const submenu = parentLi.querySelector(':scope > ul.sub-menu');
      if (submenu) {
        submenu.style.display = !isFocused ? 'block' : 'none';
      }
    };

    // Support mobile and desktop interactions reliably
    ['touchstart', 'mousedown', 'keydown'].forEach(eventType => {
      icon.addEventListener(eventType, toggleSubmenu, { passive: false });
    });

    // Prevent accidental triggering of the link
    icon.addEventListener('click', e => {
      e.preventDefault();
      e.stopPropagation();
    }, { passive: false });
  });
});

// Remove the "focus" class before the link triggers page load, so that the submenu isn't rendered when the page link is clicked.
document.querySelectorAll('.menu-item-has-children > a').forEach(link => {
  link.addEventListener('click', e => {
    const parent = link.closest('.menu-item-has-children');
    parent.classList.remove('focus');
  });
});