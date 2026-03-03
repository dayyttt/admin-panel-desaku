<!-- Sidebar Search Component -->
<div id="sgc-sidebar-search" class="sgc-search-container" style="display: none;">
    <div class="sgc-search-wrapper">
        <svg class="sgc-search-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
        </svg>
        <input 
            type="text" 
            id="sgc-menu-search" 
            class="sgc-search-input" 
            placeholder="Cari menu... (Ctrl+K)"
            autocomplete="off"
        />
        <button id="sgc-search-clear" class="sgc-search-clear" style="display: none;">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
    <div id="sgc-search-results" class="sgc-search-results" style="display: none;"></div>
</div>

<style>
/* Search Container */
.sgc-search-container {
    padding: 0.75rem;
    border-bottom: 1px solid rgba(148, 163, 184, 0.15);
}

.sgc-search-wrapper {
    position: relative;
    display: flex;
    align-items: center;
}

.sgc-search-icon {
    position: absolute;
    left: 0.75rem;
    width: 1.25rem;
    height: 1.25rem;
    color: #94a3b8;
    pointer-events: none;
}

.sgc-search-input {
    width: 100%;
    padding: 0.625rem 2.5rem 0.625rem 2.5rem;
    background: rgba(15, 23, 42, 0.4);
    border: 1px solid rgba(148, 163, 184, 0.2);
    border-radius: 0.5rem;
    color: #f1f5f9;
    font-size: 0.875rem;
    transition: all 0.2s ease;
}

.sgc-search-input:focus {
    outline: none;
    border-color: rgba(59, 130, 246, 0.5);
    background: rgba(15, 23, 42, 0.6);
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.sgc-search-input::placeholder {
    color: #64748b;
}

.sgc-search-clear {
    position: absolute;
    right: 0.5rem;
    padding: 0.25rem;
    background: transparent;
    border: none;
    border-radius: 0.25rem;
    color: #94a3b8;
    cursor: pointer;
    transition: all 0.2s ease;
}

.sgc-search-clear:hover {
    background: rgba(148, 163, 184, 0.2);
    color: #f1f5f9;
}

.sgc-search-clear svg {
    width: 1rem;
    height: 1rem;
}

/* Search Results */
.sgc-search-results {
    margin-top: 0.5rem;
    max-height: 400px;
    overflow-y: auto;
    background: rgba(15, 23, 42, 0.6);
    border: 1px solid rgba(148, 163, 184, 0.2);
    border-radius: 0.5rem;
    padding: 0.5rem;
}

.sgc-search-result-item {
    padding: 0.625rem 0.75rem;
    margin-bottom: 0.25rem;
    border-radius: 0.375rem;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.sgc-search-result-item:hover,
.sgc-search-result-item.active {
    background: rgba(59, 130, 246, 0.2);
}

.sgc-search-result-item:active {
    transform: scale(0.98);
    background: rgba(59, 130, 246, 0.3);
}

.sgc-search-result-icon {
    width: 1.25rem;
    height: 1.25rem;
    color: #94a3b8;
    flex-shrink: 0;
}

.sgc-search-result-content {
    flex: 1;
    min-width: 0;
}

.sgc-search-result-title {
    font-size: 0.875rem;
    color: #f1f5f9;
    font-weight: 500;
}

.sgc-search-result-path {
    font-size: 0.75rem;
    color: #94a3b8;
    margin-top: 0.125rem;
}

.sgc-search-highlight {
    background: rgba(34, 197, 94, 0.3);
    color: #4ade80;
    padding: 0 0.125rem;
    border-radius: 0.125rem;
}

.sgc-search-no-results {
    padding: 1.5rem;
    text-align: center;
    color: #94a3b8;
    font-size: 0.875rem;
}

/* Light Mode */
html:not(.dark) .sgc-search-input {
    background: rgba(241, 245, 249, 0.8);
    border-color: rgba(148, 163, 184, 0.3);
    color: #0f172a;
}

html:not(.dark) .sgc-search-input:focus {
    background: rgba(255, 255, 255, 0.9);
    border-color: rgba(59, 130, 246, 0.5);
}

html:not(.dark) .sgc-search-input::placeholder {
    color: #94a3b8;
}

html:not(.dark) .sgc-search-results {
    background: rgba(255, 255, 255, 0.95);
    border-color: rgba(148, 163, 184, 0.3);
}

html:not(.dark) .sgc-search-result-title {
    color: #0f172a;
}

html:not(.dark) .sgc-search-result-path {
    color: #64748b;
}

html:not(.dark) .sgc-search-icon,
html:not(.dark) .sgc-search-clear {
    color: #64748b;
}

html:not(.dark) .sgc-search-clear:hover {
    background: rgba(148, 163, 184, 0.2);
    color: #0f172a;
}

/* Scrollbar */
.sgc-search-results::-webkit-scrollbar {
    width: 6px;
}

.sgc-search-results::-webkit-scrollbar-track {
    background: transparent;
}

.sgc-search-results::-webkit-scrollbar-thumb {
    background: rgba(148, 163, 184, 0.3);
    border-radius: 3px;
}

.sgc-search-results::-webkit-scrollbar-thumb:hover {
    background: rgba(148, 163, 184, 0.5);
}
</style>

<script>
(function() {
    'use strict';
    
    // Levenshtein Distance for fuzzy matching
    function levenshteinDistance(str1, str2) {
        const len1 = str1.length;
        const len2 = str2.length;
        const matrix = [];
        
        for (let i = 0; i <= len1; i++) {
            matrix[i] = [i];
        }
        
        for (let j = 0; j <= len2; j++) {
            matrix[0][j] = j;
        }
        
        for (let i = 1; i <= len1; i++) {
            for (let j = 1; j <= len2; j++) {
                const cost = str1[i - 1] === str2[j - 1] ? 0 : 1;
                matrix[i][j] = Math.min(
                    matrix[i - 1][j] + 1,
                    matrix[i][j - 1] + 1,
                    matrix[i - 1][j - 1] + cost
                );
            }
        }
        
        return matrix[len1][len2];
    }
    
    // Fuzzy search score
    function fuzzyScore(query, text) {
        query = query.toLowerCase();
        text = text.toLowerCase();
        
        // Exact match
        if (text.includes(query)) {
            return 100;
        }
        
        // Calculate distance
        const distance = levenshteinDistance(query, text);
        const maxLen = Math.max(query.length, text.length);
        const score = Math.max(0, 100 - (distance / maxLen) * 100);
        
        return score;
    }
    
    // Initialize search
    function initSidebarSearch() {
        // Find sidebar navigation
        const sidebar = document.querySelector('.fi-sidebar-nav');
        
        if (!sidebar) {
            setTimeout(initSidebarSearch, 500);
            return;
        }
        
        // Check if already injected
        const existingSearch = sidebar.parentElement.querySelector('#sgc-sidebar-search');
        if (existingSearch && existingSearch.style.display !== 'none') {
            console.log('SGC Search: Already initialized');
            return;
        }
        
        // Get search container
        const searchContainer = document.getElementById('sgc-sidebar-search');
        if (!searchContainer) {
            setTimeout(initSidebarSearch, 500);
            return;
        }
        
        // Inject search box at the top of sidebar nav
        if (sidebar.parentElement) {
            sidebar.parentElement.insertBefore(searchContainer, sidebar);
            searchContainer.style.display = 'block';
            console.log('SGC Search: Injected into sidebar');
        }
        
        const searchInput = document.getElementById('sgc-menu-search');
        const searchClear = document.getElementById('sgc-search-clear');
        const searchResults = document.getElementById('sgc-search-results');
        
        if (!searchInput) {
            setTimeout(initSidebarSearch, 500);
            return;
        }
        
        let menuItems = [];
        let selectedIndex = -1;
        
        // Collect all menu items
        function collectMenuItems() {
            menuItems = [];
            
            // Standalone menu items (like Dashboard)
            document.querySelectorAll('.fi-sidebar-nav > .fi-sidebar-item .fi-sidebar-item-button').forEach(item => {
                const label = item.querySelector('.fi-sidebar-item-label');
                const icon = item.querySelector('.fi-sidebar-item-icon');
                const href = item.getAttribute('href');
                
                if (label && href) {
                    menuItems.push({
                        title: label.textContent.trim(),
                        path: '',
                        href: href,
                        icon: icon ? icon.outerHTML : '',
                        element: item,
                        parentGroup: null
                    });
                }
            });
            
            // Group menu items with parent context
            document.querySelectorAll('.fi-sidebar-group').forEach(group => {
                const groupButton = group.querySelector(':scope > button');
                const groupLabel = groupButton ? groupButton.querySelector('.fi-sidebar-item-label') : null;
                const groupName = groupLabel ? groupLabel.textContent.trim() : '';
                
                // Get submenu items
                group.querySelectorAll('.fi-sidebar-group-items .fi-sidebar-item-button').forEach(item => {
                    const label = item.querySelector('.fi-sidebar-item-label');
                    const icon = item.querySelector('.fi-sidebar-item-icon');
                    const href = item.getAttribute('href');
                    
                    if (label && href) {
                        menuItems.push({
                            title: label.textContent.trim(),
                            path: groupName,
                            href: href,
                            icon: icon ? icon.outerHTML : '',
                            element: item,
                            parentGroup: group,
                            parentButton: groupButton
                        });
                    }
                });
            });
            
            console.log('SGC Search: Collected', menuItems.length, 'menu items');
        }
        
        // Search and display results
        function performSearch(query) {
            if (!query || query.length < 2) {
                searchResults.style.display = 'none';
                return;
            }
            
            const results = menuItems
                .map(item => {
                    // Score both title and path (group name)
                    const titleScore = fuzzyScore(query, item.title);
                    const pathScore = item.path ? fuzzyScore(query, item.path) : 0;
                    // Use the higher score
                    const score = Math.max(titleScore, pathScore);
                    
                    return {
                        ...item,
                        score: score
                    };
                })
                .filter(item => item.score > 30)
                .sort((a, b) => b.score - a.score)
                .slice(0, 10);
            
            if (results.length === 0) {
                searchResults.innerHTML = '<div class="sgc-search-no-results">Tidak ada hasil ditemukan</div>';
                searchResults.style.display = 'block';
                return;
            }
            
            const html = results.map((item, index) => {
                const highlightedTitle = highlightMatch(item.title, query);
                const highlightedPath = item.path ? highlightMatch(item.path, query) : '';
                
                return `
                    <div class="sgc-search-result-item ${index === 0 ? 'active' : ''}" 
                         data-href="${item.href}" 
                         data-index="${index}"
                         data-has-parent="${item.parentGroup ? 'true' : 'false'}">
                        ${item.icon}
                        <div class="sgc-search-result-content">
                            <div class="sgc-search-result-title">${highlightedTitle}</div>
                            ${item.path ? `<div class="sgc-search-result-path">${highlightedPath}</div>` : ''}
                        </div>
                    </div>
                `;
            }).join('');
            
            searchResults.innerHTML = html;
            searchResults.style.display = 'block';
            selectedIndex = 0;
            
            // Add click handlers
            searchResults.querySelectorAll('.sgc-search-result-item').forEach((resultItem, idx) => {
                resultItem.addEventListener('click', function() {
                    const href = this.getAttribute('data-href');
                    const hasParent = this.getAttribute('data-has-parent') === 'true';
                    
                    // Store expand state if submenu
                    if (hasParent) {
                        storeExpandState(href);
                    }
                    
                    // If submenu, expand parent group first
                    if (hasParent && results[idx].parentButton) {
                        expandParentGroup(results[idx].parentButton);
                    }
                    
                    // Close search
                    searchInput.value = '';
                    searchClear.style.display = 'none';
                    searchResults.style.display = 'none';
                    
                    // Navigate
                    window.location.href = href;
                });
            });
        }
        
        // Highlight matched text
        function highlightMatch(text, query) {
            const lowerText = text.toLowerCase();
            const lowerQuery = query.toLowerCase();
            const index = lowerText.indexOf(lowerQuery);
            
            if (index !== -1) {
                return text.substring(0, index) +
                    '<span class="sgc-search-highlight">' +
                    text.substring(index, index + query.length) +
                    '</span>' +
                    text.substring(index + query.length);
            }
            
            return text;
        }
        
        // Expand parent group dropdown
        function expandParentGroup(groupButton) {
            if (!groupButton) return;
            
            // Check if group is collapsed
            const isCollapsed = groupButton.getAttribute('aria-expanded') === 'false';
            
            if (isCollapsed) {
                // Click to expand
                groupButton.click();
                console.log('SGC Search: Expanded parent group');
            }
        }
        
        // Store expand state before navigation
        function storeExpandState(href) {
            try {
                localStorage.setItem('sgc_expand_for_url', href);
                console.log('SGC Search: Stored expand state for', href);
            } catch (e) {
                console.error('SGC Search: Failed to store expand state', e);
            }
        }
        
        // Check and expand on page load
        function checkExpandState() {
            try {
                const targetUrl = localStorage.getItem('sgc_expand_for_url');
                if (!targetUrl) return;
                
                const currentPath = window.location.pathname;
                const targetPath = new URL(targetUrl, window.location.origin).pathname;
                
                if (currentPath === targetPath) {
                    // Find the menu item and expand its parent
                    setTimeout(() => {
                        const menuButton = document.querySelector(`a.fi-sidebar-item-button[href="${targetUrl}"]`);
                        if (menuButton) {
                            const parentGroup = menuButton.closest('.fi-sidebar-group');
                            if (parentGroup) {
                                const groupButton = parentGroup.querySelector(':scope > button');
                                if (groupButton && groupButton.getAttribute('aria-expanded') === 'false') {
                                    groupButton.click();
                                    console.log('SGC Search: Auto-expanded parent on page load');
                                }
                            }
                        }
                        // Clear the stored state
                        localStorage.removeItem('sgc_expand_for_url');
                    }, 100);
                }
            } catch (e) {
                console.error('SGC Search: Failed to check expand state', e);
            }
        }
        
        // Event listeners
        searchInput.addEventListener('input', function() {
            const query = this.value.trim();
            searchClear.style.display = query ? 'block' : 'none';
            performSearch(query);
        });
        
        searchClear.addEventListener('click', function() {
            searchInput.value = '';
            searchClear.style.display = 'none';
            searchResults.style.display = 'none';
            searchInput.focus();
        });
        
        // Keyboard navigation
        searchInput.addEventListener('keydown', function(e) {
            const items = searchResults.querySelectorAll('.sgc-search-result-item');
            
            if (e.key === 'ArrowDown') {
                e.preventDefault();
                selectedIndex = Math.min(selectedIndex + 1, items.length - 1);
                updateSelection(items);
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                selectedIndex = Math.max(selectedIndex - 1, 0);
                updateSelection(items);
            } else if (e.key === 'Enter' && selectedIndex >= 0 && items[selectedIndex]) {
                e.preventDefault();
                const href = items[selectedIndex].getAttribute('data-href');
                const hasParent = items[selectedIndex].getAttribute('data-has-parent') === 'true';
                
                // Get current results to find parent button
                const currentResults = menuItems
                    .map(item => {
                        const titleScore = fuzzyScore(searchInput.value.trim(), item.title);
                        const pathScore = item.path ? fuzzyScore(searchInput.value.trim(), item.path) : 0;
                        return { ...item, score: Math.max(titleScore, pathScore) };
                    })
                    .filter(item => item.score > 30)
                    .sort((a, b) => b.score - a.score)
                    .slice(0, 10);
                
                // Store expand state if submenu
                if (hasParent) {
                    storeExpandState(href);
                }
                
                // If submenu, expand parent group first
                if (hasParent && currentResults[selectedIndex] && currentResults[selectedIndex].parentButton) {
                    expandParentGroup(currentResults[selectedIndex].parentButton);
                }
                
                // Close search
                searchInput.value = '';
                searchClear.style.display = 'none';
                searchResults.style.display = 'none';
                
                // Navigate
                window.location.href = href;
            } else if (e.key === 'Escape') {
                searchInput.value = '';
                searchClear.style.display = 'none';
                searchResults.style.display = 'none';
                searchInput.blur();
            }
        });
        
        function updateSelection(items) {
            items.forEach((item, index) => {
                item.classList.toggle('active', index === selectedIndex);
            });
            
            if (items[selectedIndex]) {
                items[selectedIndex].scrollIntoView({ block: 'nearest' });
            }
        }
        
        // Ctrl+K shortcut
        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                e.preventDefault();
                searchInput.focus();
            }
        });
        
        // Click outside to close
        document.addEventListener('click', function(e) {
            const searchContainer = document.getElementById('sgc-sidebar-search');
            if (searchContainer && !searchContainer.contains(e.target)) {
                searchResults.style.display = 'none';
            }
        });
        
        // Re-collect menu items after Livewire navigation
        document.addEventListener('livewire:navigated', function() {
            setTimeout(collectMenuItems, 300);
        });
        
        // Initialize
        collectMenuItems();
        checkExpandState(); // Check if we need to expand parent on page load
        
        console.log('SGC Search: Initialized');
    }
    
    // Start
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initSidebarSearch);
    } else {
        initSidebarSearch();
    }
})();
</script>
