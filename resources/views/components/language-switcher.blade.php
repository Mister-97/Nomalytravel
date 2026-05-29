@php
    use App\Helpers\TranslationHelper;
    $currentLocale = app()->getLocale();
    $currentLanguage = TranslationHelper::getCurrentLanguage();
    $availableLanguages = TranslationHelper::getAvailableLanguages();
@endphp

<div class="language-switcher dropdown">
    <button class="btn lang-flag-btn dropdown-toggle" type="button" id="languageDropdown" data-bs-toggle="dropdown" aria-expanded="false">
        @if($currentLanguage && $currentLanguage->flag_image)
            <img src="{{ asset($currentLanguage->flag_image) }}" alt="{{ $currentLanguage->name }}">
        @else
            <span class="lang-flag-emoji">
                @if($currentLocale == 'en') 🇺🇸
                @elseif($currentLocale == 'es') 🇪🇸
                @elseif($currentLocale == 'ar') 🇸🇦
                @else 🇺🇸
                @endif
            </span>
        @endif
    </button>
    
    <ul class="dropdown-menu" aria-labelledby="languageDropdown">
        @foreach($availableLanguages as $language)
            <li>
                <a class="dropdown-item {{ TranslationHelper::isCurrentLanguage($language->code) ? 'active' : '' }}" 
                   href="{{ route('language.switch', $language->code) }}"
                   data-rtl="{{ $language->is_rtl ? 'true' : 'false' }}">
                    <span class="language-flag me-2">
                        @if($language->flag_image)
                            <img src="{{ asset($language->flag_image) }}" alt="{{ $language->name }} Flag" 
                                 style="max-width: 20px; max-height: 15px; vertical-align: middle;">
                        @else
                            {{ $language->flag ?: '🌐' }}
                        @endif
                    </span>
                    {{ $language->name }}
                    @if(TranslationHelper::isCurrentLanguage($language->code))
                        <i class="fas fa-check ms-auto"></i>
                    @endif
                </a>
            </li>
        @endforeach
    </ul>
</div>

<style>
.lang-flag-btn {
    width: 34px;
    height: 34px;
    border-radius: 50% !important;
    padding: 0 !important;
    border: 2px solid #e0e0e0 !important;
    background: #fff !important;
    overflow: hidden;
    display: flex !important;
    align-items: center;
    justify-content: center;
    box-shadow: none !important;
}
.lang-flag-btn::after { display: none !important; }
.lang-flag-btn img { width: 100%; height: 100%; object-fit: cover; border-radius: 50%; }
.lang-flag-btn .lang-flag-emoji { font-size: 20px; line-height: 1; }
.language-switcher .dropdown-menu { min-width: 130px; padding: 5px; }
.dropdown-item.active { background-color: #e9ecef; color: #495057; }
.dropdown-item:hover { background-color: #f8f9fa; }
.header-wrap .navbar .dropdown-menu li { padding: 0; }
.header-wrap .navbar .dropdown-menu li a { padding: 6px 15px; display: flex; align-items: center; }

/* RTL Support */
body[dir="rtl"] {
    direction: rtl;
    text-align: right;
}

body[dir="rtl"] .language-switcher .dropdown-toggle {
    flex-direction: row-reverse;
}

body[dir="rtl"] .dropdown-item .language-flag {
    margin-left: 0.5rem !important;
    margin-right: 0 !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle language switching and RTL/LTR
    const languageLinks = document.querySelectorAll('.language-switcher .dropdown-item');
    
    languageLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const isRTL = this.getAttribute('data-rtl') === 'true';
            
            // Set body direction
            document.body.setAttribute('dir', isRTL ? 'rtl' : 'ltr');
            
            // Store preference in localStorage
            localStorage.setItem('language_direction', isRTL ? 'rtl' : 'ltr');
            
            // Load RTL CSS dynamically if needed
            loadRTLCSS(isRTL);
        });
    });
    
    // Restore direction preference on page load
    const savedDirection = localStorage.getItem('language_direction');
    if (savedDirection) {
        document.body.setAttribute('dir', savedDirection);
        loadRTLCSS(savedDirection === 'rtl');
    }
    
    // Function to load RTL CSS dynamically
    function loadRTLCSS(isRTL) {
        const existingRTLCSS = document.querySelector('link[href*="rtlstyle.css"]');
        
        if (isRTL && !existingRTLCSS) {
            // Add RTL CSS
            const link = document.createElement('link');
            link.rel = 'stylesheet';
            link.href = '{{ asset("css/rtlstyle.css") }}';
            document.head.appendChild(link);
        } else if (!isRTL && existingRTLCSS) {
            // Remove RTL CSS
            existingRTLCSS.remove();
        }
    }
});
</script>
