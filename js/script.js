// Acts of Kindness Pakistan - Enhanced JavaScript

// ===== MOBILE MENU TOGGLE =====
const menuButton = document.getElementById('menu-button');
const mobileMenu = document.getElementById('mobile-menu');
const navLinks = mobileMenu ? mobileMenu.querySelectorAll('a') : [];

if (menuButton) {
    menuButton.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
    });
}

// Close mobile menu when a link is clicked
navLinks.forEach(link => {
    link.addEventListener('click', () => {
        mobileMenu.classList.add('hidden');
    });
});

// ===== HERO SECTION ANIMATIONS =====
function initHeroAnimations() {
    if (typeof gsap !== 'undefined') {
        const tl = gsap.timeline();

        // Hero content animation
        tl.from('.hero-content > div:nth-child(1)', {
            duration: 0.8,
            y: 30,
            opacity: 0,
            ease: 'power3.out'
        })
        .from('.hero-content > h1', {
            duration: 0.8,
            y: 30,
            opacity: 0,
            ease: 'power3.out'
        }, '-=0.4')
        .from('.hero-content > p', {
            duration: 0.6,
            y: 20,
            opacity: 0,
            ease: 'power3.out'
        }, '-=0.6')
        .from('.hero-content .flex', {
            duration: 0.6,
            y: 20,
            opacity: 0,
            ease: 'power3.out'
        }, '-=0.4')
        .from('.hero-content > .mt-12', {
            duration: 0.6,
            y: 20,
            opacity: 0,
            ease: 'power3.out'
        }, '-=0.4')
        .from('.hero-image', {
            duration: 0.8,
            x: 50,
            opacity: 0,
            ease: 'power3.out'
        }, '-=1.6');
    }
}

// ===== SCROLL TRIGGER ANIMATIONS =====
function initScrollAnimations() {
    if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
        gsap.registerPlugin(ScrollTrigger);

        // Animate mission and vision cards
        gsap.to('.mission-card, .vision-card', {
            scrollTrigger: {
                trigger: '#about',
                start: 'top center+=100px',
                toggleActions: 'play none none none'
            },
            duration: 0.8,
            y: 0,
            opacity: 1,
            stagger: 0.2,
            ease: 'power3.out'
        });

        // Animate program cards
        gsap.to('.program-card', {
            scrollTrigger: {
                trigger: '#programs',
                start: 'top center+=100px',
                toggleActions: 'play none none none'
            },
            duration: 0.6,
            y: 0,
            opacity: 1,
            stagger: 0.1,
            ease: 'power3.out'
        });

        // Animate team cards
        gsap.to('.team-card', {
            scrollTrigger: {
                trigger: '#team',
                start: 'top center+=100px',
                toggleActions: 'play none none none'
            },
            duration: 0.6,
            y: 0,
            opacity: 1,
            stagger: 0.15,
            ease: 'power3.out'
        });

        // Animate membership form
        gsap.to('#membership-form', {
            scrollTrigger: {
                trigger: '#membership',
                start: 'top center+=100px',
                toggleActions: 'play none none none'
            },
            duration: 0.8,
            y: 0,
            opacity: 1,
            ease: 'power3.out'
        });
    }
}

// ===== FORM HANDLING =====
const membershipForm = document.getElementById('membership-form');

if (membershipForm) {
    membershipForm.addEventListener('submit', function(e) {
        e.preventDefault();

        // Collect form data
        const formData = {
            fullname: document.getElementById('fullname').value,
            email: document.getElementById('email').value,
            phone: document.getElementById('phone').value,
            city: document.getElementById('city').value,
            profession: document.getElementById('profession').value,
            category: document.getElementById('category').value,
            message: document.getElementById('message').value
        };

        // Validate required fields
        if (!formData.fullname || !formData.email || !formData.phone || !formData.city || !formData.profession || !formData.category) {
            alert('Please fill in all required fields.');
            return;
        }

        // Log the form data
        console.log('Form submitted with data:', formData);

        // Submit form
        submitForm(formData);
    });
}

// Form submission handler - Sends to PHP backend
function submitForm(data) {
    const submitButton = membershipForm.querySelector('button[type="submit"]');
    const originalText = submitButton.textContent;
    submitButton.textContent = '⏳ Processing...';
    submitButton.disabled = true;

    // Send data to PHP backend
    fetch('api/send-email.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        const successMessage = document.getElementById('success-message');

        if (result.success) {
            // Show success message
            if (successMessage) {
                successMessage.innerHTML = '✅ ' + result.message;
                successMessage.classList.remove('hidden');
                successMessage.classList.add('bg-emerald-100', 'border-emerald-400', 'text-emerald-700');
            }

            // Reset form
            membershipForm.reset();

            // Log submission
            console.log('Form submitted successfully:', result.data);

            // Hide success message after 5 seconds
            setTimeout(() => {
                if (successMessage) {
                    successMessage.classList.add('hidden');
                }
            }, 5000);
        } else {
            // Show error message
            if (successMessage) {
                successMessage.innerHTML = '❌ ' + result.message;
                successMessage.classList.remove('hidden');
                successMessage.classList.add('bg-red-100', 'border-red-400', 'text-red-700');
            }
            console.error('Form submission error:', result.message);
        }

        // Restore button
        submitButton.textContent = originalText;
        submitButton.disabled = false;

        // Scroll to message
        if (successMessage) {
            successMessage.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    })
    .catch(error => {
        console.error('Network error:', error);
        const successMessage = document.getElementById('success-message');

        if (successMessage) {
            successMessage.innerHTML = '❌ Network error: Please check your connection and try again.';
            successMessage.classList.remove('hidden');
            successMessage.classList.add('bg-red-100', 'border-red-400', 'text-red-700');
        }

        // Restore button
        submitButton.textContent = originalText;
        submitButton.disabled = false;

        if (successMessage) {
            successMessage.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });
}

// ===== SMOOTH SCROLL FOR ANCHOR LINKS =====
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        const href = this.getAttribute('href');
        if (href === '#') return;

        e.preventDefault();
        const target = document.querySelector(href);
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// ===== HEADER BACKGROUND ON SCROLL =====
const header = document.querySelector('.navbar');
if (header) {
    window.addEventListener('scroll', () => {
        if (window.scrollY > 10) {
            header.style.boxShadow = '0 4px 20px rgba(0, 0, 0, 0.1)';
        } else {
            header.style.boxShadow = '0 1px 3px rgba(0, 0, 0, 0.05)';
        }
    });
}

// ===== PARALLAX EFFECT FOR HERO EMOJIS =====
window.addEventListener('scroll', () => {
    const floatingEmojis = document.querySelectorAll('.floating-emoji');
    if (floatingEmojis.length === 0) return; // Guard: no floating emojis exist

    const scrollY = window.scrollY;
    floatingEmojis.forEach((emoji, index) => {
        const speed = (index + 1) * 0.5;
        emoji.style.transform = `translateY(${scrollY * speed}px)`;
    });
});

// ===== INTERSECTION OBSERVER FOR ANIMATIONS =====
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -100px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('in-view');
            observer.unobserve(entry.target);
        }
    });
}, observerOptions);

// Observe cards for animation
document.querySelectorAll('.program-card, .team-card, .mission-card, .vision-card').forEach(el => {
    observer.observe(el);
});

// ===== KEYBOARD NAVIGATION =====
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && !mobileMenu.classList.contains('hidden')) {
        mobileMenu.classList.add('hidden');
    }
});

// ===== FORM ACCESSIBILITY =====
const formInputs = document.querySelectorAll('input, textarea, select');
formInputs.forEach(input => {
    input.addEventListener('focus', () => {
        input.parentElement.classList.add('focused');
    });

    input.addEventListener('blur', () => {
        input.parentElement.classList.remove('focused');
    });
});

// ===== NEWSLETTER SUBSCRIPTION =====
const newsletterForm = document.querySelector('footer .flex');
if (newsletterForm && newsletterForm.parentElement.tagName !== 'FORM') {
    newsletterForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const emailInput = newsletterForm.querySelector('input[type="email"]');
        if (emailInput && emailInput.value) {
            console.log('Newsletter subscription:', emailInput.value);
            alert('✅ Thank you for subscribing!');
            emailInput.value = '';
        }
    });
}

// ===== COUNTER ANIMATION (FOR FUTURE STATS) =====
function animateCounter(element, target, duration = 2000) {
    let current = 0;
    const increment = target / (duration / 16);
    const timer = setInterval(() => {
        current += increment;
        if (current >= target) {
            element.textContent = target;
            clearInterval(timer);
        } else {
            element.textContent = Math.floor(current);
        }
    }, 16);
}

// ===== DOCUMENT READY =====
document.addEventListener('DOMContentLoaded', () => {
    // Initialize hero animations
    initHeroAnimations();

    // Initialize scroll animations
    initScrollAnimations();

    // Animate counter elements if any exist
    const counters = document.querySelectorAll('[data-count]');
    counters.forEach(counter => {
        const target = parseInt(counter.getAttribute('data-count'));
        animateCounter(counter, target);
    });

    console.log('Acts of Kindness Pakistan website initialized ✨');
});

// ===== WINDOW LOAD =====
window.addEventListener('load', () => {
    // Add loaded state to body
    document.body.classList.add('loaded');
});

// ===== ACTIVE NAV LINK TRACKING =====
window.addEventListener('scroll', () => {
    let current = '';
    const sections = document.querySelectorAll('section[id]');

    sections.forEach(section => {
        const sectionTop = section.offsetTop;
        const sectionHeight = section.clientHeight;
        if (scrollY >= sectionTop - 200) {
            current = section.getAttribute('id');
        }
    });

    const navLinks = document.querySelectorAll('.nav-link');
    navLinks.forEach(link => {
        link.classList.remove('active');
        if (link.getAttribute('href').slice(1) === current) {
            link.classList.add('active');
        }
    });
});

// ===== PAGE VISIBILITY API =====
document.addEventListener('visibilitychange', () => {
    if (document.hidden) {
        console.log('User left the page');
    } else {
        console.log('User returned to the page');
    }
});

// ===== PREVENT MOBILE HOVER ISSUES =====
const isMobileDevice = () => {
    return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
};

if (isMobileDevice()) {
    document.body.classList.add('mobile-device');
}

// ===== CUSTOM EVENT FOR FORM SUBMISSION =====
membershipForm?.addEventListener('submit', () => {
    const event = new CustomEvent('membershipSubmitted', {
        detail: { timestamp: new Date() }
    });
    document.dispatchEvent(event);
});

// ===== LOG PAGE INITIALIZATION =====
console.log('%cActs of Kindness Pakistan', 'font-size: 24px; font-weight: bold; color: #10b981;');
console.log('%cA youth-centric volunteer movement since 2016', 'font-size: 14px; color: #0d9488;');
console.log('%cVersion: 1.0.0', 'font-size: 12px; color: #666;');
