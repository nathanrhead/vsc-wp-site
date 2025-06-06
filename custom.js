// Return anchor tags to their unfocused state.
document.querySelectorAll('.wp-block-button__link').forEach(button => {
  button.addEventListener('click', function() {    
    this.blur();
  });
});