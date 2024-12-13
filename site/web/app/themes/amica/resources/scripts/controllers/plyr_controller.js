import { ApplicationController, useIntersection } from 'stimulus-use';
import Plyr from 'plyr';

export default class extends ApplicationController {
  static targets = ['poster', 'button'];
  static values = {
    settings: { type: Object, default: {} },
  };
  static classes = ['animateIn'];

  connect() {
    useIntersection(this);
    this.plyrIsReady = false;
    this.plyrElement = Array.from(this.element.childNodes).find((el) =>
      ['IFRAME', 'VIDEO'].includes(el.nodeName)
    );
    this.plyrType = this.plyrElement.nodeName;
    this.plyrContainer =
      this.plyrType == 'IFRAME' ? this.element : this.plyrElement;

    this.plyr = new Plyr(this.plyrContainer, {
      ...this.settingsValue,
      poster: this.element.dataset.poster,
    });

    this.plyr.on('ready', this.onReady.bind(this));
    this.plyr.on('playing', this.onPlaying.bind(this));
    document.addEventListener('turbo:before-cache', this.teardown.bind(this));
  }

  onReady() {
    this.plyrIsReady = true;

    if (this.settingsValue?.autoplay) this.plyr.muted = true;
  }

  appear(entry) {
    if (!this.plyrIsReady) {
      setTimeout(() => this.appear(entry), 500);
    }

    if (this.settingsValue?.autoplay) this.plyr.play();
  }

  onPlaying() {
    if (this.hasPosterTarget) this.posterTarget.style.display = 'none';
    if (this.hasAnimateInClass) this.element.classList.add(this.animateInClass);
  }

  unmute() {
    this.plyr.muted = false;
    this.buttonTarget.style.display = 'none';
  }

  teardown() {
    // rebuild the original state if it's an iframe
    if (this.plyrType === 'IFRAME') {
      this.element.innerHTML = '';
      if (this.hasPosterTarget) this.element.appendChild(poster);
      this.element.appendChild(this.plyrElement);

      // set poster back to display block if present
      if (this.hasPosterTarget) poster.style.display = 'block';
    }

    // destroy plyr instance
    this.plyr.destroy();
  }
}
