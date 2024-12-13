import { Controller } from 'stimulus';
import Swiper, { Pagination, EffectFade, Navigation, Controller as SwiperController } from 'swiper';

class CardSlider extends Controller {

  connect() {
    // Cards carousel
    Swiper.use([Pagination, EffectFade, Navigation, SwiperController]);

    const _this = this;
    _this.swiper = new Swiper('.swiper-card-slider', {
      grabCursor: true,
      loop: false,
      spaceBetween: 16,
      autoHeight: false,
      slidesPerView: 'auto',
      slidesPerGroup: 1,
      slideVisibleClass: 'swiper-slide-visible',
      slidePrevClass: 'swiper-slide-prev',
      slideNextClass: 'swiper-slide-next',
      navigation: {
        nextEl: '.custom-button-next',
        prevEl: '.custom-button-prev',
      },
      breakpoints: {
        768: {
          slidesPerGroup: 2,
          spaceBetween: 32,
        },

        920: {
          slidesPerView: 2,
          slidesPerGroup: 2,
        },
        1280: {
          slidesPerView: 3,
          slidesPerGroup: 3,
        },
      },
      on: {
        init: function() {
          _this.arrowWidth();
        },
        resize: function() {
          _this.arrowWidth();
        }
      }
    }); // swiper close
  }

  arrowWidth() {
    const controllerW = this.element.offsetWidth,
          sliderW     = this.sliderTarget.offsetWidth,
          diff        = (controllerW - sliderW) / 2;

    const minW = 16 * 4;

    let arrowW      = diff;
    let arrowOffset = 0;

    if(minW > diff) {
      arrowW = minW;
      arrowOffset = minW - diff;
    }

    this.element.style.setProperty('--arrow-width', arrowW + 'px');
    this.element.style.setProperty('--arrow-offset', arrowOffset + 'px');
  }
}

CardSlider.targets = ['slider'];

export default CardSlider;