import domReady from '@roots/sage/client/dom-ready';

import { gsap } from "gsap";
import { ScrollTrigger } from 'gsap/ScrollTrigger.js';
import { library, dom } from '@fortawesome/fontawesome-svg-core';
import { 
  faArrowLeft, faArrowRight, faEnvelope,
} from '@fortawesome/free-solid-svg-icons';
import { 
  faFacebook,faFacebookF,
  faXTwitter,faInstagram,faYoutube,
  faYoutubeSquare,faLinkedin,
  faTiktok, faThreads, faTwitter
} from '@fortawesome/free-brands-svg-icons';

gsap.registerPlugin(ScrollTrigger);

/**
 * External Dependencies
 */
import { Application } from "@hotwired/stimulus";

import AccordionController from "./controllers/accordion_controller.js";
import CardSliderController from './controllers/card_slider_controller.js';
import CarouselController from './controllers/carousel_controller.js';
import CasesController from './controllers/cases_controller.js';
import ContentResponsiveController from './controllers/content_responsive_controller.js';
import DropdownController from "./controllers/dropdown_controller.js";
import FiltersController from "./controllers/filters_controller.js";
import HeaderController from "./controllers/header_controller.js";
import ModalController from "./controllers/modal_controller.js";
import PlyrController from "./controllers/plyr_controller.js";
import SelectController from "./controllers/select_controller.js";


window.Stimulus = Application.start()
Stimulus.register("accordion", AccordionController)
Stimulus.register("card-slider", CardSliderController)
Stimulus.register("carousel", CarouselController)
Stimulus.register("cases", CasesController)
Stimulus.register("content-responsive", ContentResponsiveController)
Stimulus.register("dropdown", DropdownController)
Stimulus.register("filters", FiltersController)
Stimulus.register("header", HeaderController)
Stimulus.register("modal", ModalController)
Stimulus.register("plyr", PlyrController)
Stimulus.register("select", SelectController)

// Stimulus.debug = true;

// add the imported icons to the library
library.add(
  faArrowLeft, faArrowRight, faEnvelope,
  faFacebook, faFacebookF,
  faTwitter, faXTwitter, faInstagram, faYoutube,
  faYoutubeSquare, faLinkedin,
  faTiktok, faThreads
  
);

const camelize = (s) => s.replace(/-./g, x=>x[1].toUpperCase()).charAt(0).toUpperCase()+s.slice(1);

const customSocials = document.querySelectorAll('.custom-social');

Array.from(customSocials).forEach((social) => {
  let icon_name = '';
  let icon_type = '';
  social.classList.forEach(cl => {
    if(cl.includes('fas')) icon_type = 'solid';
      else if(cl.includes('fab')) icon_type = 'brand';
      else if(cl.includes('fa-')) {
        icon_name = cl.substring(3, cl.length);
      }
  })

  if(icon_type === 'solid') {
    import('@fortawesome/free-solid-svg-icons').then((icons) => {
      library.add(icons[`fa${camelize(icon_name)}`]);
      dom.watch();
    });
  } else {
    import('@fortawesome/free-brands-svg-icons').then((icons) => {
      library.add(icons[`fa${camelize(icon_name)}`]);
    });
  }
  
});

dom.watch();

/**
 * Application entrypoint
 */
domReady(async () => {
  // ...
});

/**
 * @see {@link https://webpack.js.org/api/hot-module-replacement/}
 */
import.meta.webpackHot?.accept(console.error);
