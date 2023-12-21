jQuery(document).ready(function () {
    customBannerHeaderText()
    setUpSideBarPhone()
    changeTextRelatedPost()
    setUpLoginCheckout()
    jQuery(window).on('resize', function () {
        setUpSideBarPhone()
    })
    customSearchInputPlaceholder()
    customCartAndCheckOutDefault()
    addCheckBoxCheckAge()
})

function customCartAndCheckOutDefault() {
    if (jQuery('body').attr('class').includes('woocommerce-checkout')) {
        jQuery('.woocommerce-input-wrapper label.checkbox').trigger('click')
    }
}
function addCheckBoxCheckAge() {
    var billingEmailField = jQuery('#billing_email_field');
    if (billingEmailField) {
        var customCheckboxHTML = `
        <p class="form-row kl_newsletter_checkbox_field woocommerce-validated" id="kl_newsletter_checkbox_field" data-priority="">
    <span class="woocommerce-input-wrapper">
        <label class="checkbox check-age">
            <input type="checkbox" class="input-checkbox" name="checkAge" id="check_age" value="1">
            <abbr class="required" title="required">*</abbr>
            <label class="check-age-label">
                <label>年齢確認が必要です。<br>
                お客様の年齢確認をさせていただいております。20歳未満のお客様には販売しておりません。お客様が20歳以上の場合は、このチェックボックスをクリックしてから注文を確定してください。<br>
                ※20歳未満のお客様の酒類の購入、飲酒は日本の法律により固く禁じられております。<br>
                ※当ストアでは、酒類に限らず全ての商品の販売を20歳以上の者のみに限定しております。
                </label>
            </label>
        </label>
    </span>
</p>

    `;
        billingEmailField.after(customCheckboxHTML);

        var form = billingEmailField.closest('form');
        if (form) {
            form.on('submit', function () {
                var checkAgeCheckbox = jQuery('#check_age');
                var checkAgeHiddenInput = form.find('input[name="checkAge"]');

                if (checkAgeCheckbox.is(':checked')) {
                    checkAgeHiddenInput.val('1');
                } else {
                    checkAgeHiddenInput.val('0');
                }
            });
        }
    }
}
function customBannerHeaderText() {
    if (jQuery('body').attr('class').includes('post-type-archive-cbd-education') || jQuery('body').attr('class').includes('post-type-archive-latest-buzz')
        || jQuery('body').attr('class').includes('post-type-archive-coa') || jQuery('body').attr('class').includes('post-type-archive-store-locations')
        || jQuery('body').attr('class').includes('single-cbd-education') || jQuery('body').attr('class').includes('single-latest-buzz')
        || jQuery('body').attr('class').includes('single-store-locations') || jQuery('body').attr('class').includes('single-coa')
        || jQuery('body').attr('class').includes('tax-cbd_education_cat') || jQuery('body').attr('class').includes('tax-latest_buzz_cat')
        || jQuery('body').attr('class').includes('tax-coa_cat') || jQuery('body').attr('class').includes('tax-store_locations_cat')
        || jQuery('body').attr('class').includes('post-type-archive-customer-review') || jQuery('body').attr('class').includes('tax-customer_review_cat') || jQuery('body').attr('class').includes('single-customer-review')
    ) {
        let label = ''
        const oldLabel = jQuery('.ast-advanced-headers-title').text()
        label = oldLabel.replace('アーカイブ: ', '')
        if (jQuery('body').attr('class').includes('tax-cbd_education_cat') || jQuery('body').attr('class').includes('tax-latest_buzz_cat')
            || jQuery('body').attr('class').includes('tax-coa_cat') || jQuery('body').attr('class').includes('tax-store_locations_cat')
            || jQuery('body').attr('class').includes('post-type-archive-customer-review') || jQuery('body').attr('class').includes('tax-customer_review_cat')
            || jQuery('body').attr('class').includes('single-customer-review')) {
            if (jQuery('body').attr('class').includes('tax-cbd_education_cat')) {
                label = 'CBD EDUCATION'
            } else if (jQuery('body').attr('class').includes('tax-latest_buzz_cat')) {
                label = 'LATEST BUZZ'
            } else if (jQuery('body').attr('class').includes('tax-latest_buzz_cat')) {
                label = 'CERTIFICATE OF ASSURANCE'
            } else if (jQuery('body').attr('class').includes('tax-store_locations_cat')) {
                label = 'STORE LOCATIONS'
            } else if (jQuery('body').attr('class').includes('tax-customer_review_cat') || jQuery('body').attr('class').includes('post-type-archive-customer-review')) {
                label = 'CUSTOMER REVIEWS'
            }
        }
        if (!label) return
        if (jQuery('body').attr('class').includes('post-type-archive-latest-buzz')) {
            label = 'LATEST BUZZ';
        }
        let html = '<h1 class="banner__heading title">' + label
        if (oldLabel.includes('アーカイブ:') || jQuery('body').attr('class').includes('tax-cbd_education_cat') || jQuery('body').attr('class').includes('tax-latest_buzz_cat')
            || jQuery('body').attr('class').includes('tax-coa_cat') || jQuery('body').attr('class').includes('tax-store_locations_cat') || jQuery('body').attr('class').includes('tax-customer_review_cat')) {
            html += '</h1><p class="banner__subheading subtitle">最新アップデート</p>'
        }
        jQuery('.ast-advanced-headers-title').replaceWith(html)
    } else if (jQuery('body').attr('class').includes('tax-product_cat') || jQuery('body').attr('class').includes('tax-product_tag')
        || jQuery('body').attr('class').includes('tax-pwb-brand') || jQuery('body').attr('class').includes('post-type-archive-product')) {
        jQuery('.ast-inside-advanced-header-content .ast-advanced-headers-wrap h1').addClass('banner__heading title')
        jQuery('.ast-inside-advanced-header-content .ast-advanced-headers-wrap').append('<p class="banner__subheading subtitle">チラクシー・オンラインストア</p>')
        if (jQuery('.term-description').length) {
            jQuery('#text-7 span').html(jQuery('.term-description p').html())
        } else {
            jQuery('#text-7 span').html('3点以上のお買い上げで、10%オフ。<br>※原料は対象外です。')

        }

        const htmlBreadCumbs = jQuery('.ast-breadcrumbs').prop('outerHTML')
        jQuery('#content .ast-container').prepend(htmlBreadCumbs);
        jQuery('#content .ast-container').append(jQuery('form.woocommerce-ordering').prop('outerHTML'));
        jQuery('#content .ast-container').append(htmlBreadCumbs);
        jQuery('#content .ast-container .ast-breadcrumbs:first-child').addClass('ast-breadcrumbs-shop-pc')
        jQuery('#content .ast-container > div:last-child').addClass('ast-breadcrumbs-shop-sp')
        jQuery('#content .ast-container > form.woocommerce-ordering').addClass('woocommerce-ordering-sp-custom')
        jQuery('#primary').after(jQuery('#text-7').prop('outerHTML'))
        jQuery('#content .ast-container > #text-7').addClass('discount-text-custom')

        customFilterShop()
    }


    jQuery('.ast-inside-advanced-header-content .ast-advanced-headers-wrap').css('display', 'initial');
}

function changeTextRelatedPost() {
    if (jQuery('.related-post .headline').length && jQuery('.related-post .headline').text() == 'Related Posts') {
        jQuery('.related-post .headline').text('関連ブログポスト')
    }
}

function setUpSideBarPhone() {
    if (jQuery('#ast-mobile-header .ast-mobile-popup-inner').length) return
    if (!jQuery('.ast-mobile-popup-inner .ast-header-account-wrap').length) {
        jQuery('.ast-mobile-popup-inner').append(jQuery('.ast-header-account-wrap').prop('outerHTML'))
        jQuery('.ast-mobile-popup-inner .ast-header-account-wrap a').append('<span class="icon-caption">ログイン</span>')
    }
    if (!jQuery('#ast-mobile-header .ast-mobile-popup-inner').length) {
        jQuery('#ast-mobile-header').append(jQuery('.ast-mobile-popup-inner').prop('outerHTML'))
    }

    jQuery('.ast-header-break-point header .ast-mobile-popup-header').remove()
    jQuery('.ast-header-break-point header .ast-desktop-popup-content').css('display', 'none')
    jQuery('.ast-header-break-point .main-header-menu-toggle').click(function () {
        if (jQuery(this).hasClass('show-menu')) {
            jQuery(this).removeClass('show-menu')
            jQuery('header .ast-mobile-popup-inner').removeClass('show')
        } else {
            jQuery(this).addClass('show-menu')
            jQuery('header .ast-mobile-popup-inner').addClass('show')
        }
        jQuery(window).scrollTop(0);
    })
    jQuery('.ast-header-break-point .ast-menu-toggle').click(function () {
        if (jQuery(this).parent().hasClass('show-submenu')) {
            jQuery(this).parent().removeClass('show-submenu')
        } else {
            jQuery(this).parent().addClass('show-submenu')
        }
    })
}

function setUpLoginCheckout() {
    if (jQuery('.woocommerce-form-login-toggle').length) {
        jQuery('div.woocommerce-info').remove()
        let url = ''
        if (window.location.href.includes('/wp/')) {
            url = '/wp/my-account/?wcm_redirect_to=page&wcm_redirect_id=332'
        } else {
            url = '/my-account/?wcm_redirect_to=page&wcm_redirect_id=332'
        }
        html = '<div class="woocommerce-info">すでにこちらにアカウントをお持ちですか？<a style="text-decoration-line: underline;" href="' + url + '">ログイン</a></div>'
        jQuery('.woocommerce-form-login-toggle').before(html)
        jQuery('div.woocommerce-info').css('display', 'block')
    }
}

function customFilterShop() {
    if (window.location.href.includes('/collections/all-collections')) {
        let tags = [];
        jQuery('#woocommerce_product_tag_cloud-5 .tagcloud a').each(function () {
            const tagText = jQuery(this).text().trim();
            tags.push(tagText);
        });

        const urlParams = new URLSearchParams(window.location.search);
        const orderby = urlParams.get('orderby');
        const tagSelect = urlParams.get('product_tag');
        const baseUri = (location.protocol + '//' + location.host + location.pathname) + (orderby ? `?orderby=${orderby}&product_tag=` : '?product_tag=');

        let html = `<select class="filter-tag-custom" onchange="location = this.value;">`;
        html += `<option value="${baseUri}">すべての全商品<option/>`;
        let filter_sidebar = '';

        for (let i = 0; i < tags.length; i++) {
            const link = baseUri + tags[i];
            const selected = (tagSelect == tags[i]) ? 'selected="selected"' : '';
            html += `<option value="${link}" ${selected}>${tags[i]}<option/>`;

            const extra_class = selected ? 'active-filter' : '';
            filter_sidebar += `<a href="${link}" class="tag-cloud-link ${extra_class}" style="font-size: 15px;">${tags[i]}</a>`;
        }

        html += '</select>';
        jQuery('.ast-shop-toolbar-container .ast-shop-toolbar-aside-wrap:last').prepend(html);
        jQuery('.woocommerce-ordering-sp-custom').after(html);
        jQuery('#woocommerce_product_tag_cloud-5 .tagcloud').html(filter_sidebar);

        jQuery('select.filter-tag-custom option').each(function () {
            if (!jQuery(this).text()) {
                jQuery(this).remove();
            }
        });

        return
    }
    if (jQuery('.widget_product_tag_cloud').length & !jQuery('body').attr('class').includes('tax-product_tag')) {
        let tags = []
        jQuery('#yith-woocommerce-ajax-navigation-filters-2 option').each(function () {
            if (jQuery(this).text() != 'All') {
                tags.push(jQuery(this).text().trim())
            }
        })

        const urlParams = new URLSearchParams(window.location.search)
        const orderby = urlParams.get('orderby');
        const tagSelect = urlParams.get('product_tag');
        const baseUri = (location.protocol + '//' + location.host + location.pathname) + (orderby ? `?orderby=${orderby}&product_tag=` : '?product_tag=')
        html = `<select class="filter-tag-custom" onchange="location = this.value;">`
        html += `<option value="${baseUri}">すべての全商品<option/>`
        let filter_sidebar = ''
        for (let i = 0; i < tags.length; i++) {
            const link = baseUri + tags[i]
            const selected = (tagSelect == tags[i]) ? 'selected="selected"' : ''
            html += `<option value="${link}" ${selected}>` + tags[i] + '<option/>'

            const extra_class = selected ? 'active-filter' : ''
            filter_sidebar += `<a href="${link}" class="tag-cloud-link ${extra_class}" style="font-size: 15px;">${tags[i]}</a>`
        }
        html += '</select>'
        jQuery('.ast-shop-toolbar-container .ast-shop-toolbar-aside-wrap:last').prepend(html)
        jQuery('.woocommerce-ordering-sp-custom').after(html)
        jQuery('#woocommerce_product_tag_cloud-5 .tagcloud').html(filter_sidebar)
        jQuery('select.filter-tag-custom option').each(function () {
            if (!jQuery(this).text()) {
                jQuery(this).remove()
            }
        })
    }
}



function customSearchInputPlaceholder() {
    jQuery('.widget_search input.search-field').attr("placeholder", "検索する")
}
