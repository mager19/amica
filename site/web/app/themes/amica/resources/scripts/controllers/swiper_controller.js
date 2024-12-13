import Swiper from "swiper";
import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
  connect() {
    this.swiper = new Swiper(this.element, {
      slidesPerView: 3,
      spaceBetween: 16,
    });
  }
}
