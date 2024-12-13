import { Controller } from 'stimulus';

class Filters extends Controller {

  initialize() {
    const urlParams = new URLSearchParams(window.location.search);
    this.startingParams = urlParams.get('categories');

    this.buttons = this.hasButtonTarget ? this.buttonTargets : [];
    this.allItems = this.hasItemTarget ? this.itemTargets : [];
    this.hiddenItems = [];
    this.activeFilters = new Set();
    if (this.hasButtonTarget) {
      if (this.startingParams) {
        this.element.scrollIntoView();
        this.buttonTargets
          .forEach((button) => {
            const slug = button.getAttribute('data-filters-slug-param');
            if (this.startingParams.split(',').includes(slug)) {
              this.activateButton(button)
              this.filterItems(slug);
            }
          })
      } else this.filterItems();
    };
  }

  toggle(e) {
    e.preventDefault();
    if (this.element.classList.contains('open')) {
      this.close();
    } else this.open();
  }

  buttonPress(e) {
    e.preventDefault();
    if (e.target.getAttribute('active')) {
      this.clearButton(e.target);
    } else {
      this.activateButton(e.target)
    }

    this.filterItems(e.params.slug)
  }

  activateButton(button) {
    const slug = button.getAttribute('data-filters-slug-param');
    button.setAttribute('active', "true");
    button.classList.remove('button-border');
    if (slug) this.activeFilters.add(slug);
      else this.activeFilters.clear();
  }

  clearButton(button) {
    const slug = button.getAttribute('data-filters-slug-param');
    button.removeAttribute('active');
    button.classList.add('button-border');
    if (slug) this.activeFilters.delete(slug);
  }

  filterItems(buttonSlug) {
    if (buttonSlug instanceof Event) buttonSlug.preventDefault();
    const urlParams = new URLSearchParams(window.location.search);
    
    if (!buttonSlug || buttonSlug instanceof Event || this.activeFilters.size == 0 ) {
      this.buttons.forEach((button) => {
        this.clearButton(button);
      });
      this.activateButton(this.resetTarget);

      this.hiddenItems.forEach((item) => {
        this.showItem(item);
      });
      this.hiddenItems = [];

      urlParams.delete('categories')

    } else if (this.activeFilters.size > 1) {
      this.hiddenItems = this.allItems.filter((item) => {
        const tags = item.dataset.tags.split(',');
        if (tags.filter((value) => this.activeFilters.has(value)).length) {
          this.showItem(item);
          return false;
        } else {
          this.hideItem(item);
          return true
        }
      })

      urlParams.set('categories', Array.from(this.activeFilters).join(','));
    } else {
      const activeValue = this.activeFilters.values().next().value;
      this.clearButton(this.resetTarget);
      this.hiddenItems = [];
      this.allItems.forEach((item) => {
        if (!item.dataset.tags.includes(activeValue)) {
          this.hideItem(item);
          this.hiddenItems.push(item);
        }
      })

      urlParams.set('categories', activeValue);

    }

    window.history.replaceState({}, "", decodeURIComponent(`${window.location.pathname}${urlParams.size != 0 ? '?' : ''}${urlParams}`));
  }

  showItem(item) {
    item.classList.remove('hidden');
  }

  hideItem(item) {
    item.classList.add('hidden');
  }
}

Filters.targets = ['button', 'item', 'reset'];

export default Filters;


/**
 * TO DO:
 * 1. multiple filters doesn't work
 * 
 */