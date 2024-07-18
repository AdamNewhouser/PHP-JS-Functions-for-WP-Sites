<?php
require_once __DIR__ . "/phone-swap-dictionary/phone-swap-dictionary.php";
$phone_swap_dictionary = get_phone_swap_dictionary();
?>
<script>
	var phoneSwapDictionary = <?php echo $phone_swap_dictionary ?>;
	jQuery(document).ready(function($) {
		/* *********************
		 * COOKIES
		 ******************** */
		$.urlParam = function(name) {
			var results = new RegExp('[\\?&]' + name + '=([^&#]*)').exec(window.location.href);
			if (results == null) {
				return null;
			} else {
				return results[1] || 0;
			}
		}

		const params = [
			'utm_source',
			'utm_medium',
			'utm_campaign', 
			'utm_term',
			'utm_content',
			'utm_adgroup',
			'source',
			'referer'
		];

		params.forEach(param => {
			if ($.urlParam(param)) {
				$.cookie(param, $.urlParam(param), {
					path: '/',
					domain: '',
					expires: 30
				});
			}
		});

		const paramCookies = params.map(utmParam => {
			return {
				[`${utmParam}`]: $.cookie(utmParam)
			}
		}).reduce((acc, curr) => Object.assign(acc, curr), {});

		var ppcPhone;

		if (paramCookies['source']) {
			if ($('.ppc-source').length) {
				$('.ppc-source').val(paramCookies['source']);
			}

			ppcPhone = phoneSwapDictionary['ppc'][paramCookies['source']];
		}

		if(paramCookies['utm_source'] && paramCookies['utm_medium'] && !paramCookies['utm_campaign']) {
			ppcPhone = phoneSwapDictionary['utm']['source'][paramCookies['utm_source']]['medium'][paramCookies['utm_medium']];
		}

		if(paramCookies['utm_source'] && paramCookies['utm_medium'] && paramCookies['utm_campaign']){
			ppcPhone = phoneSwapDictionary['utm']['source'][paramCookies['utm_source']]['medium'][paramCookies['utm_medium']]['campaign'][paramCookies['utm_campaign']];
		}

		if (ppcPhone) {
			var ppcPhoneStripped = ppcPhone.replace(/[^\d]/g, '');
			$('.phone-dropdown-container .phone-location-number').text(ppcPhone);
			$('.phone-dropdown-container .location-phone').attr('href', `tel:${ppcPhoneStripped}`);

			$('.contact1-header_contact-list .contact-phone a').text(ppcPhone);
			$('.contact1-header_contact-list .contact-phone a').attr('href', `tel:${ppcPhoneStripped}`);
		}

		// Set Referer. Override with ?referer=
		if (!paramCookies['referer']) {
			<?php if (isset($_SERVER['HTTP_REFERER'])) : ?>
				$.cookie('referer', "<?php echo $_SERVER['HTTP_REFERER']; ?>", {
					path: '/',
					domain: '',
					expires: 30
				});
				paramCookies['referer'] = $.cookie('referer');
			<?php endif; ?>
		}

		var refererSrc = paramCookies['referer'];

		if (refererSrc) {
			if ($('.referer').length) {
				$('.referer').val(refererSrc);
			}
		}

	});
</script>