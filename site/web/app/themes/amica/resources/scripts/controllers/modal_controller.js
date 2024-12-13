import { Controller } from 'stimulus';

class Modal extends Controller {
  static values = {
    type: String,
  }

  initialize() {
    // this.openModalButton = document.querySelector(`[data-open-modal="${this.element.id}"]`).addEventListener('click', this.openModal.bind(this), false);
    this.isOpen = false;
    const not_government = window.localStorage.getItem('not_government');
    console.log(not_government);
    if (this.typeValue === 'onload' && !not_government) {
      console.log('why am I here');
      this.openModal();
      document.body.classList.add('lock-body-for-mobile-menu');
    } else if(not_government) this.closeModal();
    
    this.closeTarget.addEventListener('click', this.closeModal.bind(this), false)
  }

  openModal() {
    // console.log('open modal');
    document.addEventListener('click', this.backgroundClick.bind(this), false)
    this.element.classList.remove('closed');
    this.element.setAttribute('tabindex', 0)
    this.isOpen = true;
  }

  confirm() {
    window.localStorage.setItem('not_government', true);
    console.log('confirmed')
    this.closeModal();
  }

  closeModal() {
    // console.log('close modal');
    this.element.classList.add('closed');
    this.element.setAttribute('tabindex', -1)
    this.isOpen = false;
    document.removeEventListener('click', this.backgroundClick.bind(this), false)
    document.body.classList.remove('lock-body-for-mobile-menu');
  }
  
  backgroundClick(e) {
    if (e.target.closest('.modal-dialog')) return;
    this.closeModal();
  }
}

Modal.targets = ['close'];

export default Modal;
