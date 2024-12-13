import { Controller } from 'stimulus';

class Header extends Controller {

  initialize() {
    this.alert = this.hasAlertTarget ? this.alertTarget : document.createElement("div");
    this.navbar = this.headerTarget;
    this.nav = this.navTarget;
    this.getHeights();
    /**
     * Get classlist, isolate bg-.... check that bg- isn't bg-white
     */
    // 
    const firstSection = document.querySelector('main > section');
    if (firstSection) {
      const firstSectionBg = Array.from(firstSection.classList).filter((a) => a.includes('bg'))[0];
      if (firstSectionBg !== 'bg-white') {
        this.element.classList.add('alt-hover')
      }
    }
    if (this.typeValue === 'shy') {
      this.state = {
        lastScroll: document.documentElement.scrollTop,
        scrollUpAmount: 0,
        scrollUpPosition: 0,
        scrollDownAmount: 0,
        scrollDownPosition: 0,
        scrollTop: document.documentElement.scrollTop,
      };
      this.scroll = window.addEventListener('scroll', this.shyNavScroll.bind(this), false);
    }

    this.resize = window.addEventListener('resize', this.resizeTasks.bind(this), false);

    // recalculate height after font load
    setTimeout(() => {
      this.getHeights();
    }, 300);
  }

  getHeights() {
    this.headerH  = this.element.offsetHeight;
    this.alertH = this.alert.offsetHeight;
    this.navH = this.navbar.querySelector('.site-brand').offsetHeight;

    document.body.style.setProperty('--header-height', this.headerH + 'px');
    document.body.style.setProperty('--alert-height', this.alertH + 'px');
    document.body.style.setProperty('--nav-height', this.navH + 'px');
  } 

  hideNav() {
    this.element.classList.remove('is-active');
    this.togglerTarget.classList.remove('is-active');
    if (this.hasNavTarget) {
      this.nav.classList.remove('show-nav');
      this.alert.classList.remove('hidden');

      this.nav.classList.add('hide-nav');
      this.element.classList.add('-top-alert');
      document.body.classList.remove('lock-body-for-mobile-menu');
    }
  }

  isMobile() {
    return this.hasTogglerTarget ? this.togglerTarget.offsetWidth > 0 : false;
  }

  resizeTasks() {
    if (!this.isMobile() && this.element.classList.contains('is-active')) this.hideNav();
  }

  showNav() {
    this.element.classList.add('is-active');
    this.togglerTarget.classList.add('is-active');
    document.addEventListener('keydown', (e) => e.key === 'Escape' && this.hideNav(), false)

    if (this.hasNavTarget) {
      this.nav.classList.add('show-nav');
      this.alert.classList.add('hidden');
      document.body.classList.add('lock-body-for-mobile-menu');

      this.nav.classList.remove('hide-nav');
      this.element.classList.remove('-top-alert');
    }
  }

  shyNavScroll(e) {
    this.state.scrollTop = document.documentElement.scrollTop;

    if (this.state.scrollTop > this.state.lastScroll) {

      this.state.scrollUpAmount = 0;
      this.state.scrollDownPosition = this.state.scrollTop;
      this.state.scrollDownAmount = this.state.scrollTop - this.state.scrollUpPosition;

      if (this.state.scrollTop > (this.headerH + this.alertH) && this.state.scrollDownAmount > 100 && this.state.scrollUpPosition > 0) {
        this.element.dataset.state = 'hide';
      }

    } else if (this.state.scrollTop < this.state.lastScroll) {

      this.state.scrollDownAmount = 0;
      this.state.scrollUpPosition = this.state.scrollTop;
      this.state.scrollUpAmount = this.state.scrollDownPosition - this.state.scrollTop;

      if (this.state.scrollTop === 0 || this.state.lastScroll <= this.alertH) {
        this.element.dataset.state = 'top';
      } else if (this.state.scrollUpAmount > 100 && this.state.scrollTop > this.headerH) {
        this.element.dataset.state = 'peek';
      }
    }
    this.state.lastScroll = this.state.scrollTop <= 0 ? 0 : this.state.scrollTop;
  }

  /**
   * Click action
   */
  toggleNav() {
    if (this.element.classList.contains('is-active')) this.hideNav();
      else this.showNav();
  }
}

Header.targets = ['toggler', 'nav', 'logo', 'logoSvg', 'alert', 'header'];
Header.values = {
  type: String,
}
export default Header;