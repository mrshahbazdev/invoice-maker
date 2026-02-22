// Common JavaScript Functions

// Hamburger Menu Toggle
function toggleHamburger() {
  const hamburger = document.querySelector('.hamburger');
  const mobileMenu = document.querySelector('.mobile-menu');
  const body = document.body;
  
  if (hamburger && mobileMenu) {
    hamburger.classList.toggle('active');
    mobileMenu.classList.toggle('active');
    body.style.overflow = mobileMenu.classList.contains('active') ? 'hidden' : '';
  }
}

// Accordion Toggle
function toggleAccordion(element) {
  const item = element.closest('.accordion-item');
  const content = item.querySelector('.accordion-content');
  const icon = item.querySelector('.accordion-icon');
  
  // Close all other items (optional - remove for multiple open)
  const allItems = document.querySelectorAll('.accordion-item');
  allItems.forEach(otherItem => {
    if (otherItem !== item && otherItem.classList.contains('active')) {
      otherItem.classList.remove('active');
      otherItem.querySelector('.accordion-content').style.maxHeight = null;
    }
  });
  
  // Toggle current item
  item.classList.toggle('active');
  
  if (item.classList.contains('active')) {
    content.style.maxHeight = content.scrollHeight + 'px';
  } else {
    content.style.maxHeight = null;
  }
}

// Fullscreen Overlay Toggle
function toggleFullscreenMenu() {
  const overlay = document.querySelector('.fullscreen-overlay');
  const body = document.body;
  
  if (overlay) {
    overlay.classList.toggle('active');
    body.style.overflow = overlay.classList.contains('active') ? 'hidden' : '';
  }
}

// Sticky Menu on Scroll
function initStickyMenu() {
  const navbar = document.querySelector('.sticky-navbar');
  if (!navbar) return;
  
  const sticky = navbar.offsetTop;
  
  function handleScroll() {
    if (window.pageYOffset > sticky) {
      navbar.classList.add('stuck');
    } else {
      navbar.classList.remove('stuck');
    }
  }
  
  window.addEventListener('scroll', handleScroll);
}

// Dropdown Toggle (for click-based dropdowns)
function toggleDropdown(event) {
  event.preventDefault();
  const dropdown = event.currentTarget.closest('.has-dropdown');
  dropdown.classList.toggle('active');
  
  // Close other dropdowns
  const allDropdowns = document.querySelectorAll('.has-dropdown');
  allDropdowns.forEach(item => {
    if (item !== dropdown) {
      item.classList.remove('active');
    }
  });
}

// Close dropdowns when clicking outside
document.addEventListener('click', function(event) {
  if (!event.target.closest('.has-dropdown')) {
    document.querySelectorAll('.has-dropdown').forEach(item => {
      item.classList.remove('active');
    });
  }
});

// Floating Menu Toggle
function toggleFloatingMenu() {
  const fab = document.querySelector('.fab-menu');
  if (fab) {
    fab.classList.toggle('active');
  }
}

// Circle Menu Toggle
function toggleCircleMenu() {
  const circleMenu = document.querySelector('.circle-menu');
  if (circleMenu) {
    circleMenu.classList.toggle('active');
  }
}

// Tab Navigation
function switchTab(event, tabId) {
  event.preventDefault();
  
  // Remove active class from all tabs and contents
  document.querySelectorAll('.tab-link').forEach(tab => {
    tab.classList.remove('active');
  });
  
  document.querySelectorAll('.tab-content').forEach(content => {
    content.classList.remove('active');
  });
  
  // Add active class to clicked tab
  event.currentTarget.classList.add('active');
  
  // Show corresponding content
  const targetContent = document.getElementById(tabId);
  if (targetContent) {
    targetContent.classList.add('active');
  }
}

// Initialize all interactive features on page load
document.addEventListener('DOMContentLoaded', function() {
  // Initialize sticky menu
  initStickyMenu();
  
  // Add click handlers for hamburger menu
  const hamburgerBtn = document.querySelector('.hamburger');
  if (hamburgerBtn) {
    hamburgerBtn.addEventListener('click', toggleHamburger);
  }
  
  // Add click handlers for fullscreen overlay
  const fullscreenToggle = document.querySelector('.fullscreen-toggle');
  const fullscreenClose = document.querySelector('.fullscreen-close');
  if (fullscreenToggle) {
    fullscreenToggle.addEventListener('click', toggleFullscreenMenu);
  }
  if (fullscreenClose) {
    fullscreenClose.addEventListener('click', toggleFullscreenMenu);
  }
  
  // Close fullscreen menu on ESC key
  document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
      const overlay = document.querySelector('.fullscreen-overlay');
      if (overlay && overlay.classList.contains('active')) {
        toggleFullscreenMenu();
      }
    }
  });
  
  // Add click handlers for accordion items
  const accordionHeaders = document.querySelectorAll('.accordion-header');
  accordionHeaders.forEach(header => {
    header.addEventListener('click', function() {
      toggleAccordion(this);
    });
  });
  
  // Add click handlers for floating menu
  const fabButton = document.querySelector('.fab-button');
  if (fabButton) {
    fabButton.addEventListener('click', toggleFloatingMenu);
  }
  
  // Add click handlers for circle menu
  const circleToggle = document.querySelector('.circle-toggle');
  if (circleToggle) {
    circleToggle.addEventListener('click', toggleCircleMenu);
  }
  
  // Close mobile menu when clicking outside
  document.addEventListener('click', function(event) {
    const mobileMenu = document.querySelector('.mobile-menu');
    const hamburger = document.querySelector('.hamburger');
    
    if (mobileMenu && hamburger) {
      if (mobileMenu.classList.contains('active') && 
          !mobileMenu.contains(event.target) && 
          !hamburger.contains(event.target)) {
        toggleHamburger();
      }
    }
  });
});

// Utility function for smooth scroll
function smoothScroll(target) {
  document.querySelector(target).scrollIntoView({
    behavior: 'smooth'
  });
}
