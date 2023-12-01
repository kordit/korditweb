document.addEventListener("DOMContentLoaded", function(event) {

	const allAccordions = document.querySelectorAll('.et_accordion');

	allAccordions.forEach(accordionWrapper => {
		let allCollapsable = accordionWrapper.querySelectorAll('.et_accordion__single-wrapper');
		allCollapsable.forEach(accordionElement => {
			accordionElement.addEventListener('click', function(){
				let maxHeightVal = accordionElement.lastElementChild.scrollHeight;
				accordionElement.lastElementChild.style.maxHeight = maxHeightVal + "px";
				if (!accordionElement.classList.contains('is-contracted')) {
					accordionElement.classList.add('is-contracted')
				} else {					
					allCollapsable.forEach(accordionElement => {
						accordionElement.classList.add('is-contracted');
					});
					accordionElement.classList.remove('is-contracted');
				}
			});
		});
		allCollapsable[0].classList.remove('is-contracted');
	});
	
});