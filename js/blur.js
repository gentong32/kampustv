var modal = document.getElementById("myModal");
var body = document.getElementsByTagName("body");
var	container = document.getElementById("myContainer");
var btnOpen = document.getElementById("myBtn");
var	btnClose = document.getElementById("closeModal");

bukamodal = function () {
	modal.className = "Modal is-visuallyHidden", setTimeout(function () {
		container.className = "MainContainer is-blurred", modal.className = "Modal"
	}, 100), container.parentElement.className = "ModalOpen"
};

btnClose.onclick = function () {
	tutupmodal();
	//alert ("h");
};

bukamodal = function () {
	modal.className = "Modal is-visuallyHidden", setTimeout(function () {
		container.className = "MainContainer is-blurred", modal.className = "Modal"
	}, 100), container.parentElement.className = "ModalOpen"
};

function tutupmodal() {
	modal.className = "Modal is-hidden is-visuallyHidden",
		body.className = "", container.className = "MainContainer",
		container.parentElement.className = ""
}

window.onclick = function (e) {

	//tutupmodal();
 	//e.target == modal && (modal.className = "Modal is-hidden", body.className = "", container.className = "MainContainer", container.parentElement.className = "")
};
