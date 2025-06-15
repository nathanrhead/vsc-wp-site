// Return anchor tags to their unfocused state.
document.querySelectorAll('.wp-block-button__link').forEach(button => {
  button.addEventListener('click', function() {    
    this.blur();
  });
});

// Hide the nav's search icon container when the search form is open.
document.querySelectorAll('.wp-block-search__button').forEach(button => {
  button.addEventListener('click', function() {
    const searchIconContainer = document.querySelector('.wp-block-navigation__responsive-container');
    if (searchIconContainer) {
      searchIconContainer.style.display = 'none';
    }
  });
}
);
