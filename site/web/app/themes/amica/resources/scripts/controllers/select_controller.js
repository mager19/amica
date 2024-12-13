import { Controller } from 'stimulus';


class Select extends Controller {

  initialize() {
    this.SPACEBAR_KEY_CODE = [0, 32];
    this.ENTER_KEY_CODE = 13;
    this.DOWN_ARROW_KEY_CODE = 40;
    this.UP_ARROW_KEY_CODE = 38;
    this.ESCAPE_KEY_CODE = 27;

    this.optionsTargetItemIds = [];
  }

  toggleListVisibility(e) {
    let openDropDown =
        this.SPACEBAR_KEY_CODE.includes(e.keyCode) || e.keyCode === this.ENTER_KEY_CODE;

    if (e.keyCode === this.ESCAPE_KEY_CODE) {
      this.closeList();
    }

    if (e.type === "click" || openDropDown) {
      if (this.optionsTarget.classList.contains('open')) this.closeList();
        else {
          this.optionsTarget.classList.add('open');
          this.optionsTarget.closest('fieldset').classList.add("open");
        }
      this.optionsContainerTarget.setAttribute(
        "aria-expanded",
        this.optionsTarget.classList.contains("open")
      );
    }

    if (e.keyCode === this.DOWN_ARROW_KEY_CODE) {
      focusNextListItem(DOWN_ARROW_KEY_CODE);
    }

    if (e.keyCode === this.UP_ARROW_KEY_CODE) {
      focusNextListItem(this.UP_ARROW_KEY_CODE);
    }
  }

  setSelectedListItem(e) {
    const hiddenLineItem = e.target.closest('ul').querySelector('li.hidden'); 
    if (hiddenLineItem) hiddenLineItem.classList.remove('hidden');
    e.target.closest('li').classList.add('hidden');
    let selectedTextToAppend = e.target.closest('label').innerHTML;
    this.buttonTarget.innerHTML = selectedTextToAppend;
  }

  closeList() {
    const closeFieldset = (event) => {
      if (event.propertyName === 'opacity') {
        this.optionsTarget.closest('fieldset').classList.remove("open");
        this.optionsTarget.removeEventListener("transitionend", closeFieldset, false);
      }
    }
    this.optionsTarget.classList.remove("open");
    this.optionsTarget.addEventListener("transitionend", closeFieldset, false);
    this.optionsContainerTarget.setAttribute("aria-expanded", false);
  }

  

  keySwitch(e) {
    switch (e.keyCode) {
      case this.ENTER_KEY_CODE:
        this.setSelectedListItem(e);
        this.closeList();
        return;

      case this.DOWN_ARROW_KEY_CODE:
        this.focusNextListItem(this.DOWN_ARROW_KEY_CODE);
        return;

      case this.UP_ARROW_KEY_CODE:
        this.focusNextListItem(this.UP_ARROW_KEY_CODE);
        return;

      case this.ESCAPE_KEY_CODE:
        this.closeList();
        return;

      default:
        return;
    }
  }

  focusNextListItem(direction) {
    const activeElementId = document.activeElement.id;
    if (activeElementId === `dropdown__selected-${this.slugValue}`) {
      document.querySelector(`#${this.optionsTargetItemIds[0]}`).focus();
    } else {
      const currentActiveElementIndex = this.optionsTargetItemIds.indexOf(
        activeElementId
      );
      if (direction === DOWN_ARROW_KEY_CODE) {
        const currentActiveElementIsNotLastItem =
              currentActiveElementIndex < this.optionsTargetItemIds.length - 1;
        if (currentActiveElementIsNotLastItem) {
          const nextListItemId = this.optionsTargetItemIds[currentActiveElementIndex + 1];
          document.querySelector(`#${nextListItemId}`).focus();
        }
      } else if (direction === UP_ARROW_KEY_CODE) {
        const currentActiveElementIsNotFirstItem =
              currentActiveElementIndex > 0;
        if (currentActiveElementIsNotFirstItem) {
          const nextListItemId = this.optionsTargetItemIds[currentActiveElementIndex - 1];
          document.querySelector(`#${nextListItemId}`).focus();
        }
      }
    }
  }

}

Select.targets = ['arrow', 'button', 'options', 'optionsContainer'];
Select.values = { slug: String }

export default Select;