import { Controller } from 'stimulus';

class Donate extends Controller {

  initialize() {
    this.isDown     = false;
    this.isHidden   = false;

    this.formH      = this.formInnerTarget.offsetHeight;
    this.donateH    = this.element.offsetHeight;

    this.scroll = window.addEventListener('scroll', this.checkPosition.bind(this), false);
    this.resize = window.addEventListener('resize', this.checkPosition.bind(this), false);

    this.getHeights();
  }

  // apply form height as css variable
  // to animate up / down the form element
  getHeights() {

    // inner form height
    this.formH    = this.formInnerTarget.offsetHeight;

    // donately floater height
    this.donateH  = this.element.offsetHeight - this.formTarget.offsetHeight;

    // css variables
    document.body.style.setProperty('--form-height', this.formH + 'px');
    document.body.style.setProperty('--donate-height', this.donateH + 'px');
  }

  toggleFloater() {

    if(this.isDown) {
      this.element.classList.add('up');
      this.element.classList.remove('down');
    } else {
      this.element.classList.remove('up');
      this.element.classList.add('down');
    }

    this.isDown = this.isDown ? false : true;
  }

  checkPosition() {

    // find the y coordinate of the footer
    const scrollY = window.scrollY,
          windowH = window.innerHeight,
          bottomY = scrollY + windowH;

    const footerY = document.getElementById('page-footer').offsetTop;
    // console.log(bottomY, footerY, this.element.offsetHeight);

    // if below the footer, fade out
    if(bottomY > footerY) {
      this.element.classList.add('off-screen');
      this.element.style.bottom = this.element.offsetHeight * -1 + 'px';

    // if above the footer, fade in
    } else {
      this.element.classList.remove('off-screen');
      this.element.style.bottom = 0;

    }
  }
}

Donate.targets = ['form', 'formInner'];

export default Donate;