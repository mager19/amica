import { Controller } from 'stimulus';

class Cases extends Controller {

  initialize() {
    const urlParams = new URLSearchParams(window.location.search);
    this.pillTemplate = document.getElementById('pill-template');

    this.dropdowns = this.hasDropdownTarget ? this.dropdownTargets : [];
    this.checkboxes = this.hasCheckboxTarget ? this.checkboxTargets : [];
    this.allItems = this.hasItemTarget ? this.itemTargets : [];

    this.hiddenItems = [];
    this.activeCases = {
      'judge': new Set(),
      'legal_category': new Set(),
    };

    this.taxonomies = [
      { slug: 'legal_category', param: 'case-categories', },
      { slug: 'judge', param: 'judges', }
    ];

    if (urlParams) {
      this.element.scrollIntoView();
      this.taxonomies.forEach((taxonomy) => {
        if (urlParams.get(taxonomy.param)) {
          this.checkboxes.forEach((checkbox) => {
            if (urlParams.get(taxonomy.param).includes(checkbox.value)) {
              checkbox.checked = true;
              this.toggleCheckbox(checkbox);
            }
          })
        }
      })
      this.filterItems();
    }

    this.keyboardListener = this.keyboardListener.bind(this);
    this.backgroundClick = this.backgroundClick.bind(this);
  }

  toggleDropdown(e) {
    e.preventDefault();
    const target = e.target.closest('button');
    if (target.classList.contains('open')) {
      this.close(target);
    } else this.open(target);
  }

  open(dropdown) {
    dropdown.classList.add('open');
    const checkboxes = Array.from(dropdown.parentElement.querySelectorAll('input[type=checkbox]'));
    checkboxes.forEach((checkbox) => checkbox.setAttribute('tabindex', 0));
    this.resetTargets.forEach((resetButton) => resetButton.setAttribute('tabindex', 0));
    document.addEventListener('click', this.backgroundClick, false)
    document.addEventListener('keydown', this.keyboardListener, false)
  }

  close(dropdown) {
    dropdown.classList.remove('open');
    const checkboxes = Array.from(dropdown.parentElement.querySelectorAll('input[type=checkbox]'));
    checkboxes.forEach((checkbox) => checkbox.setAttribute('tabindex', -1));
    this.resetTargets.forEach((resetButton) => resetButton.setAttribute('tabindex', -1));
  }

  keyboardListener(e) {
    return e.key === 'Escape' && this.closeAll();
  }

  closeAll() {
    this.dropdownTargets.forEach((dropdown) => this.close(dropdown));
    document.removeEventListener('keydown', this.keyboardListener, false);
    document.removeEventListener('click', this.backgroundClick, false);
  }

  toggleCheckbox(action, removePill = true) {
    let checkbox;
    if (action instanceof Event) checkbox = action.target;
    else checkbox = action;
    const slug = checkbox.value;
    const taxonomy = checkbox.dataset.parent;
    if (checkbox.checked) {
      if (slug) {
        this.buildPill(checkbox.value, checkbox.dataset.name)
        this.activeCases[taxonomy].add(slug);
      }
      this.filterItems();
    } else {
      if (slug) {
        if (removePill) this.removePill(checkbox.value);
        this.activeCases[taxonomy].delete(slug);
      }
      this.filterItems();
    }
  }

  buildPill(slug, name) {
    const pill = this.pillTemplate.content.cloneNode(true).querySelector('.button');
    pill.querySelector('.pill-content').textContent = name;
    pill.dataset.slug = slug;
    pill.dataset.action = 'cases#removePill';
    this.pillsTarget.append(pill);
  }

  removePill(e) {
    let slug;
    let pill;

    if (e.target) {
      pill = e.target.closest('.button');
      slug = pill.dataset.slug;
    } else {
      slug = e;
      pill = this.pillTargets.find((pill) => pill.dataset.slug == slug);
    }

    const checkbox = this.checkboxes.find((checkbox) => checkbox.value === slug);

    if (checkbox.checked == true) {
      checkbox.checked = false;
      this.toggleCheckbox(checkbox, false);
    }

    if (pill) this.pillsTarget.removeChild(pill);
  }

  filterItems() {
    if (this.activeCases.judge.size == 0 && this.activeCases.legal_category.size == 0) {
      this.hiddenItems.forEach((item) => {
        this.showItem(item);
      });
      this.hiddenItems = [];
      this.activeFiltersTarget.classList.add('no-filters')
    } else {
      this.hiddenItems = [];
      this.allItems.forEach((item) => {
        const itemJudges = item.dataset.judges.split(',');
        const itemCategories = item.dataset.caseCategories.split(',');
        const matchingJudge = this.activeCases.judge.size > 0 ? itemJudges.filter(value => this.activeCases.judge.has(value)).length : true;
        const matchingCategory = this.activeCases.legal_category.size > 0 ? itemCategories.filter(value => this.activeCases.legal_category.has(value)).length : true;
        if (matchingJudge && matchingCategory) this.showItem(item)
        else {
          this.hideItem(item);
          this.hiddenItems.push(item);
        }
      })
      this.activeFiltersTarget.classList.remove('no-filters')
    }
    this.setUrlParams();

    if (this.hiddenItems.length === this.allItems.length) {
      this.itemListTarget.classList.add('hidden');
      this.noResultsTarget.classList.remove('hidden');
    } else {
      this.itemListTarget.classList.remove('hidden')
      this.noResultsTarget.classList.add('hidden')
    }

  }

  resetDropdown(e) {
    e.preventDefault();
    const reset = e.target.closest('button');
    this.checkboxes.forEach((checkbox) => {
      if (checkbox.dataset.parent == reset.dataset.parent) {
        checkbox.checked = false;
        this.toggleCheckbox(checkbox);
      }
    });
  }

  setUrlParams() {
    const urlParams = new URLSearchParams(window.location.search);
    this.taxonomies.forEach((taxonomy) => {
      if (this.activeCases[taxonomy.slug].size > 0) urlParams.set(taxonomy.param, Array.from(this.activeCases[taxonomy.slug]));
        else urlParams.delete(taxonomy.param);
    });

    window.history.replaceState({}, "", decodeURIComponent(`${window.location.pathname}${urlParams.size != 0 ? '?' : ''}${urlParams}`));
  }

  backgroundClick(e) {
    if (e.target.closest('.dropdown')) return;
    this.closeAll();
  }

  showItem(item) {
    this.itemListTarget.classList.add('blur-sm');
    item.classList.remove('hidden');
    setTimeout(() => {
      // item.classList.add('active');
      this.itemListTarget.classList.remove('blur-sm');
    }, 150)
  }

  hideItem(item) {
    this.itemListTarget.classList.add('blur-sm');
    item.classList.add('hidden');
    setTimeout(() => {
      this.itemListTarget.classList.remove('blur-sm');
    }, 150)
    // item.classList.remove('active');
  }
}

Cases.targets = ['button', 'item', 'itemList', 'reset', 'dropdown', 'checkbox', 'noResults', 'activeFilters', 'pills', 'pill'];

export default Cases;


/**
 * TO DO:
 * 1. multiple filters doesn't work
 * 
 */