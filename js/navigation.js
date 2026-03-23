
const navigation = document.getElementById("site-navigation");
const menubtn = navigation.querySelector('.menu-toggle');
const submenubtn = navigation.querySelectorAll('.menu-item-has-children');

const responsive = (navigation) => {
	if (navigation.className === "topnav") {
		navigation.className += " responsive";
		document.querySelector('body').style.overflow = 'hidden';
	} else {
		navigation.className = "topnav";
		document.querySelector('body').style.overflow = 'auto';
	}
}
const desactive = () =>{
	submenubtn.forEach(e => {
		const ul = e.querySelector('ul');
		ul.classList.remove('active', 'align-right');
	})
}
const active = (submenu) => {
	if (submenu.classList.contains('active')) {
		submenu.classList.remove('active', 'align-right');
	}
	else {
		desactive();
		submenu.classList.add('active');

		// En desktop, vérifier si le sous-menu déborde à droite
		if (window.innerWidth > 1200) {
			requestAnimationFrame(() => {
				const rect = submenu.getBoundingClientRect();
				if (rect.right > window.innerWidth - 10) {
					submenu.classList.add('align-right');
				}
			});
		}
	} 
}
window.onload = () => {
	submenubtn.forEach(e => {
		e.querySelector('a').addEventListener('click', (e) => {
			e.preventDefault();
			active(e.target.nextElementSibling);
		});
	});
	menubtn.addEventListener('click', () => {
		responsive(navigation);
	});
  };
