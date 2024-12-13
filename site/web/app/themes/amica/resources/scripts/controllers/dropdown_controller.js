import { Controller } from 'stimulus';

class Dropdown extends Controller {

  initialize() {
    this.nav = document.getElementById('navigation');
    this.subnav = this.element.querySelector('ul');
    this.togglerTarget.addEventListener('keydown', this.menuNavigation.bind(this), false);
    this.subnav.addEventListener('keydown', this.menuNavigation.bind(this), false);
    this.firstLink = this.linkTargets[0];
    this.lastLink = this.linkTargets[this.linkTargets.length - 1];
  }

  menuNavigation(e) {
    const current = e.target.parentElement;
    let next;
    let nextMenu; 
    switch (e.key) {
      case "Space":
        if (e.target == this.togglerTarget) {
          e.preventDefault();
          this.open();
        }
        break;
      case "ArrowDown":
        e.preventDefault();
        if (e.target == this.togglerTarget) {
          this.open();
          next = this.firstLink;
        } else if (current.nextElementSibling) {
          next = current.nextElementSibling.firstElementChild;
        } else {
          next = this.togglerTarget;
        }
        break;
      case "ArrowUp":
        e.preventDefault();
        if (e.target == this.togglerTarget) {
          next = this.lastLink;
        } else if (current.previousElementSibling && current.previousElementSibling.firstElementChild != this.overviewTarget) {
          next = current.previousElementSibling.firstElementChild
        } else {
          next = this.togglerTarget;
        }
        break;
      case "ArrowLeft":
        if (e.target == this.togglerTarget) {
          nextMenu = current.previousElementSibling;
        } else {
          nextMenu = current.parentElement.closest(".menu-item").previousElementSibling;
        }
        if (!nextMenu) break;

        this.switchMenu(nextMenu);
        break;
      case "ArrowRight":
        if (e.target == this.togglerTarget) {
          nextMenu = current.nextElementSibling;
        } else {
          nextMenu = current.parentElement.closest(".menu-item").nextElementSibling;
        }
        if (window.getComputedStyle(nextMenu).display === 'none') break;

        this.switchMenu(nextMenu);
        break;
      case "Tab":
        if (e.shiftKey) { 
          if (e.target == this.togglerTarget) {
            this.close();
          }
          break;
        } else if (!current.nextElementSibling && current.parentElement.closest(".menu-item")) {
          e.preventDefault();
          this.switchMenu(current.parentElement.closest(".menu-item").nextElementSibling);
          break;
        }
        break;
      case "Enter":
        if (this.element.classList.contains('wpml-ls-current-language')) {
          e.preventDefault();
          if (this.element.classList.contains('open')) this.close();
          else this.open();
        }
    }
    if (next) next.focus();
  }
  switchMenu(menu) {
    if (!menu) return false; 
    const firstLink = menu.firstElementChild;
    let submenu = menu.querySelector('.sub-menu');
    if (submenu) submenu = Array.from(submenu.children).map((li) => li.firstElementChild)
    
    this.close();
    this.open(menu, submenu);

    if (firstLink) firstLink.focus()
  }

  open(menu = this.element, links = this.linkTargets) {
    if (links) {
      document.addEventListener('keydown', (e) => e.key === 'Escape' && this.close(), false)
      menu.classList.add('open');
      links.forEach((link) => {
        if (link.getAttribute('data-dropdown-target') !== 'overview')
        link.setAttribute('tabindex', 0);
      })
    }
  }

  close(menu = this.element) {
    menu.classList.remove('open');
    this.linkTargets.forEach((link) => { 
      link.setAttribute('tabindex', -1);
    })
  }
}

Dropdown.targets = ['toggler', 'menu', 'link', 'overview'];

export default Dropdown;