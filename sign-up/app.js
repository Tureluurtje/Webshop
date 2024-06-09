const signUpButton = document.getElementById('signUp');
const signInButton = document.getElementById('signIn');
const containerr = document.getElementById('containerr');

signUpButton.addEventListener('click', () => {
	containerr.classList.add("right-panel-active");
});

signInButton.addEventListener('click', () => {
	containerr.classList.remove("right-panel-active");
});