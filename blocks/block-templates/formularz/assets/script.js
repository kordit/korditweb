/* eslint-disable no-unused-vars */
function initFormularz(element = document) {
	const fileInput = document.getElementById('file-upload');
	const fileListDiv = document.createElement('div');
	fileListDiv.id = 'file-list';
	fileInput.parentNode.insertBefore(fileListDiv, fileInput);

	fileInput.style.display = 'none';
	const uploadText = document.createElement('p');
	fileInput.parentNode.insertBefore(uploadText, fileListDiv);

	function updateFileList() {
		fileListDiv.innerHTML = '';

		for (let i = 0; i < fileInput.files.length; i++) {
			const fileWrapper = document.createElement('div');
			const fileName = document.createElement('span');
			fileName.textContent = fileInput.files[i].name;

			const removeButton = document.createElement('div');
			removeButton.textContent = '✕';
			removeButton.addEventListener('click', function() {
				const filesArray = Array.from(fileInput.files);
				filesArray.splice(i, 1);

				const newFileList = new DataTransfer();
				filesArray.forEach(file => newFileList.items.add(file));

				fileInput.files = newFileList.files;
				updateFileList();
			});

			fileWrapper.appendChild(fileName);
			fileWrapper.appendChild(removeButton);
			fileListDiv.appendChild(fileWrapper);
		}
	}
	fileInput.addEventListener('change', updateFileList);

	const customFileButton = document.createElement('div');
	customFileButton.classList.add('attach-file');
	customFileButton.textContent = 'Dodaj załącznik';
	customFileButton.addEventListener('click', function() {
		fileInput.click();
	});
	fileInput.parentNode.insertBefore(customFileButton, fileListDiv);
	fileInput.addEventListener('click', function(e) {
		e.stopPropagation();
	});
};

document.addEventListener("DOMContentLoaded", () => {
	initFormularz();
});

/* -- Admin JS START -- */
if(window.acf){
	window.acf.addAction("render_block_preview/type=formularz", (el) => {
		if(!!el[0].querySelector(".formularz") && !el[0].querySelector(".formularz").classList.contains("block-js-added")){
			initFormularz(el[0]);
			el[0].querySelector(".formularz").classList.add("block-js-added");
		}
	});
}
/* -- Admin JS END -- */
