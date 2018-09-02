/* jshint esversion:6 */
import $ from 'jquery';

class Search {
  // describe and create/initiate our object
  constructor() {
    // Adding properties and selecting dom elements here (one must try referencing the dom as little as possible, 
    // so when one creates and instance of the class we have access to those properties
    // also some 'state' like properties, where we can control some ui changes
    this.resultsDiv = $('#search-overlay__results');
    this.openButton = $('.js-search-trigger');
    this.closeButton = $('.search-overlay__close');
    this.searchOverlay = $('.search-overlay');
    this.searchField = $('#search-term'),
    this.events();
    this.isOverlayOpen = false;
    this.isSpinnerVisible = false;
    this.previousValue;
    this.typingTimer;
  }

  // 2. events - putting the various events on the selected elements
  events() {
    this.openButton.on('click', this.openOverlay.bind(this));
    this.closeButton.on('click', this.closeOverlay.bind(this));
    $(document).on('keydown', this.keyPressDispatcher.bind(this)); // this is adding it everywhere
    this.searchField.on('keyup', this.typingLogic.bind(this)); // keyup is when you lift your finger off a key
  }

  // 3. methods (function, action...)
  // setting up logic when you type and set up a spinner
  typingLogic() {


    if (this.searchField.val() !== this.previousValue) { // This if statement is used to prevent showing spinner when pressing navigation type key like the arrows, backspace etc       
      clearTimeout(this.typingTimer);

      if (this.searchField.val()) { // if searchField has a value
        // then we chack if spinner is not active, then we create one      
        if(!this.isSpinnerVisible) {
          this.resultsDiv.html('<div class="spinner-loader"></div>');
          this.isSpinnerVisible = true;
        }
        // bind(this) - big NB , remember we are telling the new method that 'this' must point to the Search object - the old JavaScript quirk
        this.typingTimer = setTimeout(this.getResults.bind(this), 750);  // we use timer so we dont call the server on every keystroke
      } else { // if no value in search field, show nothing in results div and set isSpinnerVariable to false so we dont show it
        this.resultsDiv.html('');
        this.isSpinnerVisible = false;
      }

    }

    this.previousValue = this.searchField.val(); // .val() - jquery fetching the value 
  }

  getResults() {
    // using es6 fat arrow functions help the 'this' issue when refering to properties on the object.
    // If we used a normal anonymous function, it would say x is undefined because 'this' is not pointing to the search object
    // We could have uses the .bind(this) trick if we stayed with using the anonymous function way
    
    $.when(
      // the 'universityData.root_url' part -works in conjunction with functions.php
      $.getJSON(universityData.root_url + '/wp-json/wp/v2/posts?search=' + this.searchField.val()),
      $.getJSON(universityData.root_url + '/wp-json/wp/v2/pages?search=' + this.searchField.val())
      ).then((postsData, pagesData) => {
      
        let combinedResults = postsData[0].concat(pagesData[0]);
        // this template literal (back ticks) help us with multiline html, please note older versions of IE and IE Edge dont support it, so be wary of this. We cant use if statements in template literals, but can use ternary like below
        this.resultsDiv.html(`      
          <h2 class="search-overlay__section-title">General Information</h2>
          ${combinedResults.length ? '<ul class="link-list min-list">' : '<p>No general information matches that search.</p>'}
          ${combinedResults.map(item => `<li><a href="${item.link}">${item.title.rendered}</a></li>`).join('')}
          ${combinedResults.length ? '</ul>' : '' }
        `);
        this.isSpinnerVisible = false;
    }, () => {
      // this block is for the rror
      this.resultsDiv.html('<p>Unexpected error, please try again</p>');
    });
  }

  // Some keypress logi
  keyPressDispatcher(event) {
    // console.log(event.keyCode);
    // checking if 's' is pressed and overlay is not already open or the user isnt focused on an actual input field
    if (event.keyCode === 83 && !this.isOverlayOpen && !$('input', 'textarea').is(':focus')) {
      this.openOverlay();      
    }
    // checking if 'esc' key is pressed and overlay is open
    if (event.keyCode === 27 && this.isOverlayOpen) {
      this.closeOverlay();      
    }
  }

  // open overlay and change property to true, and stop scrolling of body while overlay is open
  openOverlay() {
    this.searchOverlay.addClass('search-overlay--active');
    $('body').addClass('body-no-scroll');
    this.searchField.val('');
    setTimeout(() => this.searchField.focus(), 301);
    this.isOverlayOpen = true;
  }

   // close overlay and change property to false, and enable scrolling of bodyn
  closeOverlay() {
    this.searchOverlay.removeClass('search-overlay--active');
    $('body').removeClass('body-no-scroll');
    this.isOverlayOpen = false;
  }
}

export default Search;