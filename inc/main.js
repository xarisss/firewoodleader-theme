document.addEventListener('DOMContentLoaded', function () {
	var burger = document.querySelector('.fl-burger');
	var nav = document.querySelector('.fl-nav-mobile');
	if (!burger || !nav) {
		return;
	}

	var menuIcon = burger.innerHTML;
	var closeIcon = '<svg viewBox="0 0 24 24"><path d="M6.4 5 5 6.4 10.6 12 5 17.6 6.4 19 12 13.4 17.6 19 19 17.6 13.4 12 19 6.4 17.6 5 12 10.6Z"/></svg>';

	burger.addEventListener('click', function () {
		var isOpen = nav.classList.toggle('is-open');
		burger.classList.toggle('is-active', isOpen);
		burger.innerHTML = isOpen ? closeIcon : menuIcon;
		burger.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
	});

	// ---------- Gallery lightbox ----------
	var triggers = Array.prototype.slice.call(document.querySelectorAll('.fl-lightbox-trigger'));
	var lightbox = document.getElementById('fl-lightbox');
	if (!triggers.length || !lightbox) {
		return;
	}

	var lbImg = lightbox.querySelector('img');
	var lbCaption = lightbox.querySelector('figcaption');
	var closeBtn = lightbox.querySelector('.fl-lightbox-close');
	var prevBtn = lightbox.querySelector('.fl-lightbox-prev');
	var nextBtn = lightbox.querySelector('.fl-lightbox-next');
	var currentIndex = 0;

	function showImage(index) {
		currentIndex = (index + triggers.length) % triggers.length;
		var trigger = triggers[currentIndex];
		lbImg.src = trigger.getAttribute('href');
		lbImg.alt = trigger.getAttribute('data-caption') || '';
		lbCaption.textContent = trigger.getAttribute('data-caption') || '';
	}

	function openLightbox(index) {
		showImage(index);
		lightbox.classList.add('is-open');
		document.body.style.overflow = 'hidden';
	}

	function closeLightbox() {
		lightbox.classList.remove('is-open');
		document.body.style.overflow = '';
	}

	triggers.forEach(function (trigger, index) {
		trigger.addEventListener('click', function (e) {
			e.preventDefault();
			openLightbox(index);
		});
	});

	closeBtn.addEventListener('click', closeLightbox);
	prevBtn.addEventListener('click', function () { showImage(currentIndex - 1); });
	nextBtn.addEventListener('click', function () { showImage(currentIndex + 1); });

	lightbox.addEventListener('click', function (e) {
		if (e.target === lightbox) {
			closeLightbox();
		}
	});

	document.addEventListener('keydown', function (e) {
		if (!lightbox.classList.contains('is-open')) {
			return;
		}
		if (e.key === 'Escape') { closeLightbox(); }
		if (e.key === 'ArrowLeft') { showImage(currentIndex - 1); }
		if (e.key === 'ArrowRight') { showImage(currentIndex + 1); }
	});
});

// ---------- Carousel (Προϊόντα / Υπηρεσίες στην αρχική) ----------
document.addEventListener('DOMContentLoaded', function () {
	document.querySelectorAll('.fl-carousel').forEach(function (carousel) {
		var track = carousel.querySelector('.fl-products, .fl-services, .fl-testimonials');
		var prev = carousel.querySelector('.fl-carousel-prev');
		var next = carousel.querySelector('.fl-carousel-next');
		if (!track) {
			return;
		}

		function step() {
			var card = track.querySelector(':scope > *');
			if (!card) {
				return 300;
			}
			var style = window.getComputedStyle(track);
			var gap = parseFloat(style.columnGap || style.gap) || 0;
			return card.getBoundingClientRect().width + gap;
		}

		if (prev) {
			prev.addEventListener('click', function () {
				track.scrollBy({ left: -step(), behavior: 'smooth' });
			});
		}
		if (next) {
			next.addEventListener('click', function () {
				track.scrollBy({ left: step(), behavior: 'smooth' });
			});
		}
	});

	// ---------- "Διάβασε περισσότερα" popup (σελίδα Προϊόντα) ----------
	var readmoreModal = document.getElementById('fl-readmore-modal');
	if (readmoreModal) {
		var modalBody = readmoreModal.querySelector('.fl-modal-body');

		document.querySelectorAll('.fl-readmore-btn').forEach(function (btn) {
			btn.addEventListener('click', function () {
				var source = document.getElementById(btn.getAttribute('data-modal-target'));
				if (!source) {
					return;
				}
				modalBody.innerHTML = source.innerHTML;
				readmoreModal.classList.add('is-open');
				document.body.style.overflow = 'hidden';
			});
		});

		readmoreModal.querySelectorAll('[data-modal-close]').forEach(function (el) {
			el.addEventListener('click', function () {
				readmoreModal.classList.remove('is-open');
				document.body.style.overflow = '';
			});
		});

		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape' && readmoreModal.classList.contains('is-open')) {
				readmoreModal.classList.remove('is-open');
				document.body.style.overflow = '';
			}
		});
	}
});
