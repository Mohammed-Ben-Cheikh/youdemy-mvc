document.addEventListener('DOMContentLoaded', () => {
    // Get DOM elements
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const content = document.querySelector('.flex-1');

    // Toggle sidebar on mobile
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', (e) => {
            e.stopPropagation();
            sidebar.classList.toggle('-translate-x-full');
        });
    }

    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', (e) => {
        if (window.innerWidth < 768 &&
            !sidebar.contains(e.target) &&
            !sidebarToggle.contains(e.target)) {
            sidebar.classList.add('-translate-x-full');
        }
    });

    // Handle resize events
    let resizeTimeout;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(() => {
            if (window.innerWidth >= 768) {
                sidebar.classList.remove('-translate-x-full');
            }
        }, 250);
    });
});

document.addEventListener('DOMContentLoaded', () => {
    const dropdownButton = document.getElementById('dropdownButton');
    const dropdownMenu = document.getElementById('dropdownMenu');
    const chevronIcon = dropdownButton.querySelector('.fa-chevron-down');
    let isOpen = false;

    // Function to toggle dropdown
    const toggleDropdown = () => {
        isOpen = !isOpen;
        dropdownMenu.classList.toggle('hidden');
        chevronIcon.style.transform = isOpen ? 'rotate(180deg)' : 'rotate(0)';
    };

    // Toggle on button click
    dropdownButton.addEventListener('click', (e) => {
        e.stopPropagation();
        toggleDropdown();
    });

    // Close when clicking outside
    document.addEventListener('click', (e) => {
        if (!dropdownButton.contains(e.target) && !dropdownMenu.contains(e.target)) {
            isOpen = false;
            dropdownMenu.classList.add('hidden');
            chevronIcon.style.transform = 'rotate(0)';
        }
    });

    // Close on escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !dropdownMenu.classList.contains('hidden')) {
            isOpen = false;
            dropdownMenu.classList.add('hidden');
            chevronIcon.style.transform = 'rotate(0)';
        }
    });

    // Prevent menu from closing when clicking inside it
    dropdownMenu.addEventListener('click', (e) => {
        e.stopPropagation();
    });
});