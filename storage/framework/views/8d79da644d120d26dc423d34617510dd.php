<?php
    use App\Helpers\TranslationHelper;
    $currentLocale = app()->getLocale();
    $currentLanguage = TranslationHelper::getCurrentLanguage();
    $availableLanguages = TranslationHelper::getAvailableLanguages();
?>

<div class="language-switcher dropdown">
    <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="languageDropdown" data-bs-toggle="dropdown" aria-expanded="false">
        <span class="language-flag">
            <?php if($currentLanguage && $currentLanguage->flag_image): ?>
                <img src="<?php echo e(asset($currentLanguage->flag_image)); ?>" alt="<?php echo e($currentLanguage->name); ?> Flag" 
                     style="max-width: 20px; max-height: 15px; vertical-align: middle;">
            <?php else: ?>
                <?php if($currentLocale == 'en'): ?> 🇺🇸
                <?php elseif($currentLocale == 'es'): ?> 🇪🇸
                <?php elseif($currentLocale == 'ar'): ?> 🇸🇦
                <?php else: ?> 🇺🇸
                <?php endif; ?>
            <?php endif; ?>
        </span>
        <span class="language-name"><?php echo e($currentLanguage ? $currentLanguage->name : 'Language'); ?></span>
    </button>
    
    <ul class="dropdown-menu" aria-labelledby="languageDropdown">
        <?php $__currentLoopData = $availableLanguages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li>
                <a class="dropdown-item <?php echo e(TranslationHelper::isCurrentLanguage($language->code) ? 'active' : ''); ?>" 
                   href="<?php echo e(route('language.switch', $language->code)); ?>"
                   data-rtl="<?php echo e($language->is_rtl ? 'true' : 'false'); ?>">
                    <span class="language-flag me-2">
                        <?php if($language->flag_image): ?>
                            <img src="<?php echo e(asset($language->flag_image)); ?>" alt="<?php echo e($language->name); ?> Flag" 
                                 style="max-width: 20px; max-height: 15px; vertical-align: middle;">
                        <?php else: ?>
                            <?php echo e($language->flag ?: '🌐'); ?>

                        <?php endif; ?>
                    </span>
                    <?php echo e($language->name); ?>

                    <?php if(TranslationHelper::isCurrentLanguage($language->code)): ?>
                        <i class="fas fa-check ms-auto"></i>
                    <?php endif; ?>
                </a>
            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
</div>

<style>
.language-switcher .dropdown-toggle {
    display: flex;
    align-items: center;
    gap: 8px;
    justify-content: space-between;
    border-color:#eee;
    font-size: 15px;
}

.language-flag {
    font-size: 1.2rem;
}

.language-name {
    font-weight: 500;
}

.dropdown-item.active {
    background-color: #e9ecef;
    color: #495057;
}

.dropdown-item:hover {
    background-color: #f8f9fa;
}
.language-switcher .dropdown-menu{padding:5px;}
.header-wrap .navbar .dropdown-menu li{padding:0;}
.header-wrap .navbar .dropdown-menu li a{padding:6px 15px; display: flex; align-items: center;}

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
            link.href = '<?php echo e(asset("css/rtlstyle.css")); ?>';
            document.head.appendChild(link);
        } else if (!isRTL && existingRTLCSS) {
            // Remove RTL CSS
            existingRTLCSS.remove();
        }
    }
});
</script>
<?php /**PATH /home/u394640813/domains/nomalytravel.com/public_html/resources/views/components/language-switcher.blade.php ENDPATH**/ ?>