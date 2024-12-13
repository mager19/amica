import { Controller } from 'stimulus';

class Forms extends Controller {
  initialize() {
    this.getHeights();
    this.containerEl = this.labelTarget.parentNode;
  }

  getHeights() {
    this.labelHeight = this.labelTarget.offsetHeight;
    document.body.style.setProperty('--label-height', this.labelHeight + 'px');
  }

  toggleLabelMove(e) {
    const emptyField = !this.inputTarget.value || this.inputTarget.value.includes('_');
    
    if (emptyField && e.type == 'blur') {
        this.containerEl.classList.add('empty');
    } else {
      this.containerEl.classList.remove('empty');
      this.containerEl.classList.remove('untouched');
      this.containerEl.classList.add('touched');
    }
  }
}

Forms.targets = ['input', 'label'];

export default Forms;


