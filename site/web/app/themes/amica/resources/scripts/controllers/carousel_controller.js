import { Controller } from 'stimulus';
import Swiper, { Pagination, EffectFade, Mousewheel, Navigation, A11y, Controller as SwiperController, Autoplay } from 'swiper';

class Carousel extends Controller {

  static values = {
    type: String,
  }

  connect() {
    // Quote carousel
    Swiper.use([Pagination, Navigation, EffectFade, Mousewheel, A11y, SwiperController, Autoplay]);
    this.uniqueId = Math.round(Math.random() * 1000);
    const slides = this.carouselTarget;
    if (slides.dataset.initialized) return;
    else slides.dataset.initialized = true;

    slides.classList.add(`swiper-carousel__${this.uniqueId}`);

    const sliderFunction = (settings = {}) => {
      settings = {
        autoplay: false, //{ delay: 5000, },
        autoHeight: false,
        grabCursor: true,
        loop: true,
        navigation: {
          nextEl: this.nextTarget,
          prevEl: this.prevTarget,
        },
        slideVisibleClass: 'swiper-slide-visible',
        slidePrevClass: 'swiper-slide-prev',
        slideNextClass: 'swiper-slide-next',
        
        pagination: {
          type: "fraction",
          el: this.fractionTarget,
        },
        a11y: true,
        keyboard: true,
        mousewheel: {
          thresholdDelta: 70,
          forceToAxis: true,      //added
        },
      };
      return settings;
    }
    /*** Unused Options  **/
    // const fadeOption = {
    //   effect: 'fade',
    //   fadeEffect: {
    //     crossFade: true
    //   }
    // };
    // const bulletOption = {
    //   pagination: {
    //     clickable: true,
    //     el: this.bulletsTarget,
    //   }
    // };
    this.slides_slider = new Swiper(`.swiper-carousel__${this.uniqueId}`, sliderFunction());

    if (this.hasBackgroundTarget) {
      this.setBackgrounds(this.slides_slider);
      this.slides_slider.on('slideChange', this.setBackgrounds.bind(this));
    }


  }

  setBackgrounds(el) {
    const slider = el ?? this;

    const index = slider.activeIndex;
    const slide = slider.slides[index];

    const activeBackground = slide.dataset.background;
    this.backgroundTarget.style.setProperty('--background-image', `url('${activeBackground}')`);
  }
  removeClasses(oldClasses, searchstring) {
    return Array.from(oldClasses).filter((cl) => cl.includes(searchstring));
  }
}

Carousel.targets = ['carousel', 'next', 'prev', 'fraction', 'bullets', 'background'];

export default Carousel;