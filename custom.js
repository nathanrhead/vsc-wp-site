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
  if (!document.body.classList.contains('touch-nav')) return;

  document.querySelectorAll('#header-menu .menu-item-has-children .res-iconify').forEach(icon => {
    const parentLi = icon.closest('li.menu-item-has-children');
    const toggleSubmenu = e => {
      if (!parentLi) return;

      e.preventDefault();
      e.stopPropagation();

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

    ['touchstart', 'mousedown', 'keydown'].forEach(eventType => {
      icon.addEventListener(eventType, toggleSubmenu, { passive: false });
    });

    icon.addEventListener('click', e => {
      e.preventDefault();
      e.stopPropagation();
    }, { passive: false });
  });
});

// Prevent submenu from flashing on touch-nav when a parent link is tapped.
document.querySelectorAll('.menu-item-has-children > a').forEach(link => {
  link.addEventListener('click', e => {
    if (document.body.classList.contains('touch-nav')) {
      const parent = link.closest('.menu-item-has-children');
      if (parent) {
        parent.classList.remove('focus');
        const submenu = parent.querySelector(':scope > ul.sub-menu');
        if (submenu) submenu.style.display = 'none';
      }
    }
  });
});

// Prevent theme from adding 'focus' on caret click in hover-nav.
document.addEventListener('DOMContentLoaded', () => {
  const observer = new MutationObserver(mutations => {
    for (const mutation of mutations) {
      if (
        mutation.type === 'attributes' &&
        mutation.attributeName === 'class' &&
        document.body.classList.contains('hover-nav')
      ) {
        const li = mutation.target;
        if (li.classList.contains('focus')) {
          li.classList.remove('focus');
        }
      }
    }
  });

  document.querySelectorAll('#header-menu .menu-item-has-children').forEach(li => {
    observer.observe(li, { attributes: true });
  });

  document.querySelectorAll('#header-menu .res-iconify').forEach(icon => {
    icon.addEventListener(
      'click',
      e => {
        if (document.body.classList.contains('hover-nav')) {
          e.preventDefault();
          e.stopPropagation();
        }
      },
      true // capture phase
    );
  });
});

// Render a blog post's remaining content on click.
document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.read-more-toggle').forEach(link => {
    link.addEventListener('click', e => {
      e.preventDefault();

      const preview = link.closest('.post-preview');
      const fullContent = preview.querySelector('.post-full-content');

      if (fullContent) {
        fullContent.style.display = 'block';
        link.style.display = 'none'; // Hide the link if you want
      }
    });
  });
});

// Hide embeded hero videos in iframes when the menu is toggled or hovered.
document.addEventListener('DOMContentLoaded', () => {
  const toggleButton = document.querySelector('.menu-toggle');

  // Helper to toggle visibility.
  function toggleIframeVisibility(hide) {
    const wrapper = document.querySelector('.wp-block-embed__wrapper');
    if (!wrapper) return;

    if (hide) {
      wrapper.classList.add('iframe-hidden');
    } else {
      wrapper.classList.remove('iframe-hidden');
    }
  }

  // Set initial state.
  const headerMenu = document.getElementById('header-menu');
  toggleIframeVisibility(headerMenu && headerMenu.getAttribute('aria-expanded') === 'true');

  toggleButton.addEventListener('click', () => {
    const isExpanded = headerMenu && headerMenu.getAttribute('aria-expanded') === 'true';
    toggleIframeVisibility(isExpanded);
  });

  // Desktop hover menu support.
  if (document.body.classList.contains('hover-nav')) {
    document.querySelectorAll('#header-menu .menu-item-has-children').forEach(item => {
      item.addEventListener('mouseover', () => toggleIframeVisibility(true));
  
      item.addEventListener('mouseout', e => {
        // Only show video again if the mouse really left the whole <li>, not into its submenu
        if (!item.contains(e.relatedTarget)) {
          toggleIframeVisibility(false);
        }
      });
    });
  }
  
  // Also hide iframe when submenu expands via "focus" class.
  const observer = new MutationObserver(mutations => {
    mutations.forEach(mutation => {
      if (
        mutation.type === 'attributes' &&
        mutation.attributeName === 'class' &&
        mutation.target.classList.contains('menu-item-has-children')
      ) {
        const anyFocused = document.querySelector('#header-menu li.menu-item-has-children.focus') !== null;
        toggleIframeVisibility(anyFocused);
      }
    });
  });

  document.querySelectorAll('#header-menu .menu-item-has-children').forEach(item => {
    observer.observe(item, { attributes: true });
  });
});

// Add classes to the body tag to toggle hover- and click-nav on and off.
function updateNavMode() {
  if (window.innerWidth >= 1367) {
    document.body.classList.add('hover-nav');
    document.body.classList.remove('touch-nav');
  } else {
    document.body.classList.add('touch-nav');
    document.body.classList.remove('hover-nav');
  }
}
updateNavMode();
window.addEventListener('resize', updateNavMode);

// Replace the about URL with the site's about page URL.
document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('a[href="https://about"]').forEach(link => {
    link.href = window.location.origin + '/about/';
    link.removeAttribute('target');
  });
});
