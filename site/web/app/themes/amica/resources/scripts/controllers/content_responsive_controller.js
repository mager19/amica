import { Controller } from 'stimulus';
import Swiper, { Pagination, EffectFade, Mousewheel, Navigation, A11y, Controller as SwiperController, Autoplay } from 'swiper';

class ContentResponsive extends Controller {
  initialize() {
    if (this.hasVesselTarget && this.hasContentTarget ){
      window.addEventListener('resize', this.resizeContent.bind(this))
      this.resizeContent();
    }
  }
  resizeContent() {
    this.contentTargets.forEach((element, key) => {
      element.style.fontSize = null;
      let elWidth = element.getBoundingClientRect().width;
      let liWidth = this.vesselTargets[key].getBoundingClientRect().width;
      if (elWidth > liWidth) {
        let elFontSize = parseInt(window.getComputedStyle(element, null).getPropertyValue('font-size'));
        do {
          elFontSize -= .5;
          element.style.fontSize = elFontSize + "px";
          elWidth = element.getBoundingClientRect().width;
          liWidth = this.vesselTargets[key].getBoundingClientRect().width;
        } while (elWidth > liWidth);
      }
    });
  } 
}

ContentResponsive.targets = ['vessel', 'content'];

export default ContentResponsive;