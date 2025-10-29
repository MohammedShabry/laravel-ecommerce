/**
 * Modern Admin Dashboard - Custom JavaScript
 * Enhanced interactions and animations
 */

(function($) {
    'use strict';

    // Sidebar submenu toggle
    $('.menu-item.has-submenu > .menu-link').on('click', function(e) {
        e.preventDefault();
        var $parent = $(this).parent();
        var $submenu = $parent.find('.submenu');
        
        // Close other submenus
        $('.menu-item.has-submenu').not($parent).removeClass('active').find('.submenu').slideUp(300);
        
        // Toggle current submenu
        $parent.toggleClass('active');
        $submenu.slideToggle(300);
    });

    // Sidebar minimize/expand
    $('.btn-aside-minimize').on('click', function() {
        $('body').toggleClass('aside-mini');
        $('.navbar-aside').toggleClass('minimized');
    });

    // Mobile sidebar toggle
    $('[data-trigger="#offcanvas_aside"]').on('click', function() {
        $('.navbar-aside').toggleClass('show');
        $('.screen-overlay').toggleClass('show');
    });

    // Close sidebar when clicking overlay
    $('.screen-overlay').on('click', function() {
        $('.navbar-aside').removeClass('show');
        $(this).removeClass('show');
    });

    // Smooth scroll for anchor links
    $('a[href^="#"]').on('click', function(e) {
        var target = $(this.getAttribute('href'));
        if (target.length) {
            e.preventDefault();
            $('html, body').stop().animate({
                scrollTop: target.offset().top - 100
            }, 500);
        }
    });

    // Card hover effects enhancement
    $('.card').hover(
        function() {
            $(this).addClass('shadow-lg');
        },
        function() {
            $(this).removeClass('shadow-lg');
        }
    );

    // Animate stat cards on page load
    $(window).on('load', function() {
        $('.icontext').each(function(index) {
            $(this).css({
                'opacity': '0',
                'transform': 'translateY(20px)'
            }).delay(100 * index).animate({
                'opacity': '1'
            }, {
                duration: 600,
                step: function(now) {
                    $(this).css('transform', 'translateY(' + (20 - now * 20) + 'px)');
                }
            });
        });
    });

    // Enhanced dropdown behavior
    $('.dropdown-toggle').on('click', function(e) {
        e.stopPropagation();
    });

    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        $('.alert:not(.alert-permanent)').fadeOut('slow');
    }, 5000);

    // Initialize tooltips if Bootstrap tooltips are available
    if (typeof $.fn.tooltip !== 'undefined') {
        $('[data-bs-toggle="tooltip"]').tooltip();
    }

    // Initialize popovers if Bootstrap popovers are available
    if (typeof $.fn.popover !== 'undefined') {
        $('[data-bs-toggle="popover"]').popover();
    }

    // Table row click to navigate
    $('.table tbody tr[data-href]').on('click', function() {
        window.location = $(this).data('href');
    }).css('cursor', 'pointer');

    // Search form enhancement
    $('.searchform input[type="text"]').on('focus', function() {
        $(this).parent().addClass('focused');
    }).on('blur', function() {
        if ($(this).val() === '') {
            $(this).parent().removeClass('focused');
        }
    });

    // Confirm delete actions
    $('.btn-delete, .delete-action').on('click', function(e) {
        if (!confirm('Are you sure you want to delete this item?')) {
            e.preventDefault();
            return false;
        }
    });

    // Number counter animation for stats
    function animateValue(element, start, end, duration) {
        let startTimestamp = null;
        const step = (timestamp) => {
            if (!startTimestamp) startTimestamp = timestamp;
            const progress = Math.min((timestamp - startTimestamp) / duration, 1);
            element.textContent = Math.floor(progress * (end - start) + start).toLocaleString();
            if (progress < 1) {
                window.requestAnimationFrame(step);
            }
        };
        window.requestAnimationFrame(step);
    }

    // Trigger counter animation on scroll
    let animated = false;
    $(window).on('scroll', function() {
        if (!animated && $('.icontext').length) {
            const scrollTop = $(window).scrollTop();
            const elementOffset = $('.icontext').first().offset().top;
            if (scrollTop + $(window).height() > elementOffset) {
                animated = true;
                // Add your counter animation here if needed
            }
        }
    });

    // Dark mode toggle
    $('.darkmode').on('click', function(e) {
        e.preventDefault();
        $('body').toggleClass('dark-mode');
        
        // Save preference to localStorage
        if ($('body').hasClass('dark-mode')) {
            localStorage.setItem('adminDarkMode', 'enabled');
        } else {
            localStorage.removeItem('adminDarkMode');
        }
    });

    // Check for saved dark mode preference
    if (localStorage.getItem('adminDarkMode') === 'enabled') {
        $('body').addClass('dark-mode');
    }

    // Form validation enhancement
    $('form[data-validate="true"]').on('submit', function(e) {
        var isValid = true;
        $(this).find('[required]').each(function() {
            if ($(this).val() === '') {
                isValid = false;
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            alert('Please fill in all required fields.');
            return false;
        }
    });

    // Clear invalid class on input
    $('input, select, textarea').on('change input', function() {
        if ($(this).val() !== '') {
            $(this).removeClass('is-invalid');
        }
    });

})(jQuery);

// Vanilla JS for elements that don't need jQuery
document.addEventListener('DOMContentLoaded', function() {
    
    // Add active class to current menu item based on URL
    const currentLocation = window.location.pathname;
    const menuLinks = document.querySelectorAll('.menu-link');
    
    menuLinks.forEach(link => {
        if (link.getAttribute('href') === currentLocation) {
            link.classList.add('active');
            const parent = link.closest('.menu-item');
            if (parent) {
                parent.classList.add('active');
            }
        }
    });

    // Lazy loading for images
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.remove('lazy');
                    imageObserver.unobserve(img);
                }
            });
        });

        document.querySelectorAll('img[data-src]').forEach(img => {
            imageObserver.observe(img);
        });
    }

    // Add loading state to buttons with data-loading attribute
    document.querySelectorAll('[data-loading="true"]').forEach(button => {
        button.addEventListener('click', function() {
            this.classList.add('loading');
            this.disabled = true;
        });
    });

});
