<script>
(function() {
    'use strict';
    
    // Check if search navigation requested expand
    function checkSearchExpandState() {
        try {
            const targetUrl = localStorage.getItem('sgc_expand_for_url');
            if (!targetUrl) return;
            
            const currentPath = window.location.pathname;
            const targetPath = new URL(targetUrl, window.location.origin).pathname;
            
            // console.log('SGC Sidebar: Checking search expand state');
            // console.log('SGC Sidebar: Target path:', targetPath);
            // console.log('SGC Sidebar: Current path:', currentPath);
            
            if (currentPath === targetPath) {
                // console.log('SGC Sidebar: ✓ Match! Will expand parent group');
                // Clear immediately to prevent re-expansion
                localStorage.removeItem('sgc_expand_for_url');
            }
        } catch (e) {
            console.error('SGC Sidebar: Failed to check search expand state', e);
        }
    }
    
    // Wait for DOM to be ready
    function initSidebarActiveFix() {
        // Check if we need to expand from search navigation
        checkSearchExpandState();
        
        // Find ONLY submenu items (inside group-items), NOT main menu items
        const submenuItems = document.querySelectorAll('.fi-sidebar-group-items .fi-sidebar-item-button');
        
        if (submenuItems.length === 0) {
            // Retry after a short delay if elements not found
            setTimeout(initSidebarActiveFix, 500);
            return;
        }
        
        // Get current URL path (without domain)
        const currentPath = window.location.pathname;
        
        // console.log('SGC Sidebar: Current path:', currentPath);
        // console.log('SGC Sidebar: Found', submenuItems.length, 'submenu items');
        
        // Remove all active classes first (from submenu and parent groups)
        submenuItems.forEach(item => {
            item.classList.remove('sgc-active');
            // Also remove from parent group
            const parentGroup = item.closest('.fi-sidebar-group');
            if (parentGroup) {
                parentGroup.classList.remove('sgc-group-active');
            }
        });
        
        // Check each submenu item
        submenuItems.forEach(item => {
            const href = item.getAttribute('href');
            
            // Extract pathname from href (remove domain if present)
            let hrefPath = href;
            try {
                if (href && href.startsWith('http')) {
                    hrefPath = new URL(href).pathname;
                }
            } catch (e) {
                // If URL parsing fails, use href as is
            }
            
            // Match if paths are equal (exact match)
            if (hrefPath && hrefPath === currentPath) {
                item.classList.add('sgc-active');
                // console.log('SGC Sidebar: ✓ MATCHED! Added active class');
                
                // Also add active class to parent group
                const parentGroup = item.closest('.fi-sidebar-group');
                if (parentGroup) {
                    parentGroup.classList.add('sgc-group-active');
                    // console.log('SGC Sidebar: ✓ Added active class to parent group');
                    
                    // AUTO-EXPAND: Open the parent group if collapsed
                    // Try multiple selectors to find the group button
                    let groupButton = parentGroup.querySelector(':scope > button');
                    if (!groupButton) {
                        groupButton = parentGroup.querySelector('button');
                    }
                    if (!groupButton) {
                        groupButton = parentGroup.querySelector('[role="button"]');
                    }
                    
                    // console.log('SGC Sidebar: Group button search result:', groupButton ? 'FOUND' : 'NOT FOUND');
                    
                    if (groupButton) {
                        const ariaExpanded = groupButton.getAttribute('aria-expanded');
                        // console.log('SGC Sidebar: aria-expanded:', ariaExpanded);
                        
                        if (ariaExpanded === 'false') {
                            // console.log('SGC Sidebar: ✓ Attempting to expand...');
                            
                            // Force expand immediately
                            groupButton.setAttribute('aria-expanded', 'true');
                            
                            // Find and show the group items
                            const groupItems = parentGroup.querySelector('.fi-sidebar-group-items');
                            if (groupItems) {
                                groupItems.style.display = 'block';
                                groupItems.style.height = 'auto';
                                groupItems.style.opacity = '1';
                                groupItems.style.visibility = 'visible';
                                // console.log('SGC Sidebar: ✓ Forced group items to display');
                            }
                            
                            // Also try clicking
                            setTimeout(() => {
                                groupButton.click();
                                // console.log('SGC Sidebar: ✓ Clicked group button');
                            }, 50);
                            
                        } else {
                            // console.log('SGC Sidebar: Parent group already expanded');
                        }
                    } else {
                        // console.log('SGC Sidebar: ⚠ Could not find group button with any selector');
                    }
                }
            }
        });
        
        // Also listen for clicks to update active state
        submenuItems.forEach(item => {
            // Remove old listeners by cloning
            const newItem = item.cloneNode(true);
            item.parentNode.replaceChild(newItem, item);
            
            newItem.addEventListener('click', function(e) {
                // console.log('SGC Sidebar: Clicked submenu');
                
                // Remove active class from all submenu items and parent groups
                document.querySelectorAll('.fi-sidebar-group-items .fi-sidebar-item-button').forEach(i => {
                    i.classList.remove('sgc-active');
                    const pg = i.closest('.fi-sidebar-group');
                    if (pg) pg.classList.remove('sgc-group-active');
                });
                
                // Add to clicked item
                this.classList.add('sgc-active');
                
                // Add to parent group
                const parentGroup = this.closest('.fi-sidebar-group');
                if (parentGroup) {
                    parentGroup.classList.add('sgc-group-active');
                }
            });
        });
    }
    
    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initSidebarActiveFix);
    } else {
        initSidebarActiveFix();
    }
    
    // Also re-run when Livewire navigates (for SPA-like navigation)
    document.addEventListener('livewire:navigated', initSidebarActiveFix);
    
    // Re-run after a delay to catch late-rendered elements
    setTimeout(initSidebarActiveFix, 1000);
})();
</script>
