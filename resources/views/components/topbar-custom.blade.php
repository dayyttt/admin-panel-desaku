<!-- Custom Topbar Icon -->
<script>
(function() {
    'use strict';
    
    function replaceToggleIcon() {
        // Find all sidebar toggle buttons
        const toggleButtons = document.querySelectorAll(
            '.fi-sidebar-open-button, .fi-sidebar-close-button, button[x-on\\:click*="sidebar"]'
        );
        
        if (toggleButtons.length === 0) {
            setTimeout(replaceToggleIcon, 300);
            return;
        }
        
        toggleButtons.forEach(button => {
            // Check if already replaced
            if (button.hasAttribute('data-icon-replaced')) {
                return;
            }
            
            // Find existing SVG
            const existingSvg = button.querySelector('svg');
            if (!existingSvg) return;
            
            // Create hamburger menu icon (3 horizontal lines)
            const hamburgerIcon = `
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            `;
            
            // Replace the icon
            existingSvg.outerHTML = hamburgerIcon;
            button.setAttribute('data-icon-replaced', 'true');
            
            // console.log('SGC Topbar: Replaced toggle icon with hamburger menu');
        });
    }
    
    // Initialize
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', replaceToggleIcon);
    } else {
        replaceToggleIcon();
    }
    
    // Re-run after Livewire navigation
    document.addEventListener('livewire:navigated', replaceToggleIcon);
})();
</script>
