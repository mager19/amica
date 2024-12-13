import { Controller } from 'stimulus';

class Accordion extends Controller {
  initialize() {
    if (this.openFirstValue) {
      this.openPanel(0);
    };
  }

  togglePanel(e) {
    e.currentTarget.parentElement.classList.toggle('active');
    const panel_index = e.currentTarget.dataset.panelIndex;
    const panel = this.panelTargets[panel_index];
    if (panel.style.maxHeight === '0px') {
      this.openPanel(panel_index);
    } else {
      this.closePanel(panel_index);
    }
  }

  openPanel(panel_index) {
    const button = this.buttonTargets[panel_index];
    const panel = this.panelTargets[panel_index];
    const icon = this.iconTargets[panel_index];
    const turn = icon.dataset.turn ?? 180;
    panel.classList.add('mb-half');
    panel.classList.add('mt-min');
    panel.style.visibility = 'visible';
    panel.style.maxHeight = `${panel.scrollHeight + 100}px`;
    button.setAttribute('aria-expanded', true);
    icon.style.transform = `rotate(-${turn}deg)`;
  }

  closePanel(panel_index) {
    const button = this.buttonTargets[panel_index];
    const panel = this.panelTargets[panel_index];
    const icon = this.iconTargets[panel_index];
    panel.classList.remove('mb-half');
    panel.classList.remove('mt-min');
    panel.style.visibility = 'hidden';
    panel.style.maxHeight = 0;
    button.setAttribute('aria-expanded', false);
    icon.style.transform = '';
  }
}


Accordion.targets = ['panel', 'icon', 'button'];
Accordion.values = {
  openFirst: {
    type: Boolean,
    default: true
  }
}

export default Accordion;