/**
 * Australian Postcode/Suburb Autocomplete
 * Provides real-time suburb and postcode lookup
 */

(function() {
    'use strict';
    
    // Debounce function to limit API calls
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }
    
    // Create autocomplete dropdown
    function createAutocompleteDropdown(input) {
        const dropdown = document.createElement('div');
        dropdown.className = 'postcode-autocomplete-dropdown';
        dropdown.style.cssText = `
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            max-height: 200px;
            overflow-y: auto;
            background: white;
            border: 1px solid #ddd;
            border-top: none;
            border-radius: 0 0 6px 6px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            display: none;
            z-index: 1000;
        `;
        
        // Position dropdown relative to input
        const wrapper = document.createElement('div');
        wrapper.style.position = 'relative';
        input.parentNode.insertBefore(wrapper, input);
        wrapper.appendChild(input);
        wrapper.appendChild(dropdown);
        
        return dropdown;
    }
    
    // Handle suburb input
    function setupSuburbAutocomplete(suburbInput, postcodeInput) {
        const dropdown = createAutocompleteDropdown(suburbInput);
        
        const searchSuburb = debounce(async function(value) {
            if (value.length < 2) {
                dropdown.style.display = 'none';
                return;
            }
            
            try {
                const response = await fetch(`/api/postcode_lookup.php?suburb=${encodeURIComponent(value)}`);
                const data = await response.json();
                
                if (data.success && data.results.length > 0) {
                    dropdown.innerHTML = '';
                    
                    // Limit to first 10 results
                    data.results.slice(0, 10).forEach(item => {
                        const option = document.createElement('div');
                        option.style.cssText = `
                            padding: 8px 12px;
                            cursor: pointer;
                            border-bottom: 1px solid #f0f0f0;
                            transition: background 0.2s;
                        `;
                        option.innerHTML = `
                            <strong>${item.suburb}</strong>
                            <span style="color: #666; font-size: 0.9em;"> ${item.postcode} (${item.state})</span>
                        `;
                        
                        option.addEventListener('mouseenter', () => {
                            option.style.background = '#f0f0f0';
                        });
                        
                        option.addEventListener('mouseleave', () => {
                            option.style.background = 'white';
                        });
                        
                        option.addEventListener('click', () => {
                            suburbInput.value = item.suburb;
                            if (postcodeInput) {
                                postcodeInput.value = item.postcode;
                            }
                            dropdown.style.display = 'none';
                        });
                        
                        dropdown.appendChild(option);
                    });
                    
                    dropdown.style.display = 'block';
                } else {
                    dropdown.style.display = 'none';
                }
            } catch (error) {
                console.error('Postcode lookup error:', error);
                dropdown.style.display = 'none';
            }
        }, 300);
        
        // Event listeners
        suburbInput.addEventListener('input', (e) => {
            searchSuburb(e.target.value);
        });
        
        suburbInput.addEventListener('focus', (e) => {
            if (e.target.value.length >= 2) {
                searchSuburb(e.target.value);
            }
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', (e) => {
            if (!suburbInput.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.style.display = 'none';
            }
        });
    }
    
    // Handle postcode input
    function setupPostcodeAutocomplete(postcodeInput, suburbInput) {
        const searchPostcode = debounce(async function(value) {
            if (value.length !== 4 || !/^\d{4}$/.test(value)) {
                return;
            }
            
            try {
                const response = await fetch(`/api/postcode_lookup.php?postcode=${value}`);
                const data = await response.json();
                
                if (data.success && data.results.length > 0) {
                    // If only one suburb for this postcode, auto-fill
                    if (data.results.length === 1 && suburbInput) {
                        suburbInput.value = data.results[0].suburb;
                    } else if (data.results.length > 1 && suburbInput) {
                        // Create dropdown for suburb selection
                        const dropdown = createAutocompleteDropdown(suburbInput);
                        dropdown.innerHTML = '';
                        
                        const header = document.createElement('div');
                        header.style.cssText = `
                            padding: 8px 12px;
                            background: #f8f8f8;
                            font-weight: bold;
                            border-bottom: 1px solid #ddd;
                        `;
                        header.textContent = `Select suburb for postcode ${value}:`;
                        dropdown.appendChild(header);
                        
                        data.results.forEach(item => {
                            const option = document.createElement('div');
                            option.style.cssText = `
                                padding: 8px 12px;
                                cursor: pointer;
                                border-bottom: 1px solid #f0f0f0;
                                transition: background 0.2s;
                            `;
                            option.textContent = item.suburb;
                            
                            option.addEventListener('mouseenter', () => {
                                option.style.background = '#f0f0f0';
                            });
                            
                            option.addEventListener('mouseleave', () => {
                                option.style.background = 'white';
                            });
                            
                            option.addEventListener('click', () => {
                                suburbInput.value = item.suburb;
                                dropdown.style.display = 'none';
                            });
                            
                            dropdown.appendChild(option);
                        });
                        
                        dropdown.style.display = 'block';
                        suburbInput.focus();
                    }
                }
            } catch (error) {
                console.error('Postcode lookup error:', error);
            }
        }, 500);
        
        postcodeInput.addEventListener('input', (e) => {
            searchPostcode(e.target.value);
        });
    }
    
    // Initialize on DOM ready
    function init() {
        // Find suburb and postcode inputs
        const suburbInputs = document.querySelectorAll('input[name="suburb"]');
        const postcodeInputs = document.querySelectorAll('input[name="postcode"]');
        
        // Setup autocomplete for each form
        suburbInputs.forEach((suburbInput, index) => {
            const postcodeInput = postcodeInputs[index];
            if (suburbInput && postcodeInput) {
                setupSuburbAutocomplete(suburbInput, postcodeInput);
                setupPostcodeAutocomplete(postcodeInput, suburbInput);
            }
        });
    }
    
    // Run when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();